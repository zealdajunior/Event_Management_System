<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentService
{
    public function __construct()
    {
        if (config('services.stripe.secret')) {
            Stripe::setApiKey(config('services.stripe.secret'));
        }
    }

    /**
     * Create a Stripe Checkout Session for ticket purchase
     */
    public function createCheckoutSession(Event $event, int $quantity, User $user)
    {
        $ticketPrice = $event->price; // Price per ticket
        $totalAmount = $ticketPrice * $quantity;
        
        // Create pending payment record
        $payment = Payment::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'amount' => $totalAmount,
            'payment_method' => 'stripe',
            'status' => 'pending',
        ]);

        // Create Stripe Checkout Session
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $event->title,
                        'description' => "Ticket for {$event->title}",
                    ],
                    'unit_amount' => $ticketPrice * 100, // Convert to cents
                ],
                'quantity' => $quantity,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success', ['payment' => $payment->id]) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel', ['payment' => $payment->id]),
            'client_reference_id' => $payment->id,
            'customer_email' => $user->email,
            'metadata' => [
                'payment_id' => $payment->id,
                'event_id' => $event->id,
                'user_id' => $user->id,
                'quantity' => $quantity,
            ],
        ]);

        // Update payment with Stripe session ID
        $payment->update([
            'stripe_session_id' => $session->id,
        ]);

        return [
            'payment' => $payment,
            'session' => $session,
        ];
    }

    /**
     * Process successful payment and generate tickets with QR codes
     */
    public function processSuccessfulPayment(Payment $payment, string $stripeSessionId)
    {
        // Verify Stripe session
        $session = Session::retrieve($stripeSessionId);
        
        if ($session->payment_status !== 'paid') {
            throw new \Exception('Payment not completed');
        }

        // Update payment status
        $payment->update([
            'status' => 'completed',
            'stripe_payment_intent_id' => $session->payment_intent,
            'payment_date' => now(),
        ]);

        $event = $payment->event;
        $quantity = $session->metadata->quantity ?? 1;

        // Calculate revenue sharing
        $totalAmount = $payment->amount;
        $platformFeePercentage = $event->platform_fee_percentage ?? 10;
        $platformFee = ($totalAmount * $platformFeePercentage) / 100;
        $organizerAmount = $totalAmount - $platformFee;

        // Update event revenue
        $event->increment('total_revenue', $totalAmount);
        $event->increment('platform_revenue', $platformFee);
        $event->increment('organizer_revenue', $organizerAmount);

        // Update organizer balance
        $event->user()->increment('balance', $organizerAmount);

        // Generate tickets with QR codes
        $tickets = [];
        for ($i = 0; $i < $quantity; $i++) {
            $ticket = $this->generateTicketWithQR($event, $payment);
            $tickets[] = $ticket;
        }

        return [
            'tickets' => $tickets,
            'payment' => $payment->fresh(),
        ];
    }

    /**
     * Generate a single ticket with QR code
     */
    public function generateTicketWithQR(Event $event, Payment $payment)
    {
        $ticketNumber = 'TKT-' . strtoupper(Str::random(10));
        $qrCodeData = json_encode([
            'ticket_number' => $ticketNumber,
            'event_id' => $event->id,
            'event_title' => $event->title,
            'payment_id' => $payment->id,
            'generated_at' => now()->toIso8601String(),
        ]);

        // Generate QR code and save to storage
        $qrCodePath = 'qrcodes/' . $ticketNumber . '.png';
        $qrCodeFullPath = storage_path('app/public/' . $qrCodePath);
        
        // Ensure directory exists
        if (!file_exists(dirname($qrCodeFullPath))) {
            mkdir(dirname($qrCodeFullPath), 0755, true);
        }
        
        QrCode::format('png')
            ->size(300)
            ->generate($qrCodeData, $qrCodeFullPath);

        // Create ticket record
        $ticket = Ticket::create([
            'event_id' => $event->id,
            'user_id' => $payment->user_id,
            'payment_id' => $payment->id,
            'ticket_number' => $ticketNumber,
            'qr_code' => $qrCodePath,
            'type' => 'general',
            'price' => $event->price,
            'quantity' => 1,
            'status' => 'confirmed',
        ]);

        return $ticket;
    }

    /**
     * Verify and check-in a ticket using QR code
     */
    public function checkInTicket(string $qrData, User $checker)
    {
        $data = json_decode($qrData, true);
        
        if (!isset($data['ticket_number'])) {
            throw new \Exception('Invalid QR code');
        }

        $ticket = Ticket::where('ticket_number', $data['ticket_number'])->first();

        if (!$ticket) {
            throw new \Exception('Ticket not found');
        }

        if ($ticket->status === 'used') {
            throw new \Exception('Ticket already used at ' . $ticket->check_in_at->format('Y-m-d H:i:s'));
        }

        if ($ticket->status === 'cancelled') {
            throw new \Exception('Ticket has been cancelled');
        }

        // Mark ticket as used
        $ticket->update([
            'status' => 'used',
            'check_in_at' => now(),
            'checked_in_by' => $checker->id,
        ]);

        return $ticket;
    }

    /**
     * Process organizer payout request
     */
    public function requestPayout(User $organizer, float $amount, array $paymentDetails)
    {
        if ($amount > $organizer->balance) {
            throw new \Exception('Insufficient balance');
        }

        $payout = $organizer->payouts()->create([
            'amount' => $amount,
            'status' => 'pending',
            'payment_method' => $paymentDetails['method'],
            'payment_details' => json_encode($paymentDetails),
        ]);

        // Deduct from balance immediately (will be refunded if payout fails)
        $organizer->decrement('balance', $amount);

        return $payout;
    }

    /**
     * Process a payment (virtual or Stripe) - Legacy method
     */
    public function processPayment(Booking $booking, string $paymentMethod = 'virtual', array $paymentDetails = []): array
    {
        try {
            if ($paymentMethod === 'stripe') {
                return $this->processStripePayment($booking, $paymentDetails);
            } else {
                return $this->processVirtualPayment($booking, $paymentDetails);
            }
        } catch (\Exception $e) {
            Log::error('Payment processing failed', [
                'booking_id' => $booking->id,
                'method' => $paymentMethod,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Payment processing failed: ' . $e->getMessage(),
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Process virtual payment (for testing/demo)
     */
    public function processVirtualPayment(Booking $booking, array $paymentDetails = []): array
    {
        // Calculate amount from booking's ticket
        $amount = $booking->ticket->price ?? 0;
        
        // Generate transaction ID
        $transactionId = 'TXN_' . strtoupper(Str::random(12));

        // Create payment record
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'amount' => $amount,
            'payment_method' => 'virtual',
            'payment_date' => now(),
            'transaction_id' => $transactionId,
            'status' => 'completed',
            'metadata' => json_encode([
                'card_type' => $paymentDetails['card_type'] ?? 'Virtual Card',
                'last_four' => $paymentDetails['last_four'] ?? '0000',
                'description' => 'Virtual payment for event booking',
            ]),
        ]);

        // Update booking status to paid
        $booking->update([
            'status' => 'paid',
            'payment_id' => $payment->id,
        ]);

        // Send payment received notification
        $booking->user->notify(new \App\Notifications\PaymentReceivedNotification($payment));

        // Send ticket email with PDF attachment
        \Illuminate\Support\Facades\Mail::to($booking->user->email)
            ->send(new \App\Mail\TicketDeliveryMail($booking));

        Log::info('Virtual payment processed successfully', [
            'payment_id' => $payment->id,
            'booking_id' => $booking->id,
            'amount' => $amount,
            'transaction_id' => $transactionId,
        ]);

        return [
            'success' => true,
            'message' => 'Payment processed successfully',
            'payment_id' => $payment->id,
            'transaction_id' => $transactionId,
            'amount' => $amount,
            'payment_method' => 'virtual',
        ];
    }

    /**
     * Process Stripe payment
     */
    public function processStripePayment(Booking $booking, array $paymentDetails = []): array
    {
        // Check if Stripe key is configured
        $stripeKey = config('services.stripe.secret');
        if (!$stripeKey) {
            throw new \Exception('Stripe configuration not found');
        }

        try {
            \Stripe\Stripe::setApiKey($stripeKey);

            $amount = $booking->ticket->price ?? 0;
            $amountInCents = (int)($amount * 100);

            // Create Stripe payment intent
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $amountInCents,
                'currency' => 'usd',
                'payment_method' => $paymentDetails['payment_method_id'] ?? null,
                'confirm' => true,
                'metadata' => [
                    'booking_id' => $booking->id,
                    'event_name' => $booking->event->name,
                    'user_id' => $booking->user_id,
                ],
                'description' => 'Event booking - ' . $booking->event->name,
            ]);

            if ($paymentIntent->status === 'succeeded') {
                // Create payment record
                $payment = Payment::create([
                    'booking_id' => $booking->id,
                    'amount' => $amount,
                    'payment_method' => 'stripe',
                    'payment_date' => now(),
                    'transaction_id' => $paymentIntent->id,
                    'status' => 'completed',
                    'metadata' => json_encode([
                        'stripe_payment_intent_id' => $paymentIntent->id,
                        'stripe_status' => $paymentIntent->status,
                        'charges' => $paymentIntent->charges,
                    ]),
                ]);

                // Update booking status to paid
                $booking->update([
                    'status' => 'paid',
                    'payment_id' => $payment->id,
                ]);

                // Send payment received notification
                $booking->user->notify(new \App\Notifications\PaymentReceivedNotification($payment));

                // Send ticket email with PDF attachment
                \Illuminate\Support\Facades\Mail::to($booking->user->email)
                    ->send(new \App\Mail\TicketDeliveryMail($booking));

                Log::info('Stripe payment processed successfully', [
                    'payment_id' => $payment->id,
                    'booking_id' => $booking->id,
                    'stripe_intent_id' => $paymentIntent->id,
                    'amount' => $amount,
                ]);

                return [
                    'success' => true,
                    'message' => 'Payment processed successfully',
                    'payment_id' => $payment->id,
                    'transaction_id' => $paymentIntent->id,
                    'amount' => $amount,
                    'payment_method' => 'stripe',
                ];
            } else {
                throw new \Exception('Stripe payment failed: ' . $paymentIntent->status);
            }
        } catch (\Stripe\Exception\ApiErrorException $e) {
            throw new \Exception('Stripe API error: ' . $e->getMessage());
        }
    }

    /**
     * Get payment methods available for the user
     */
    public function getAvailablePaymentMethods(): array
    {
        $isSandbox = config('payments.sandbox_mode', true);
        $methods = [];

        foreach (config('payments.payment_methods', []) as $methodId => $methodConfig) {
            // Skip if method is not enabled
            if (!($methodConfig['enabled'] ?? false)) {
                continue;
            }

            // Skip sandbox-only methods in production
            if (($methodConfig['sandbox_only'] ?? false) && !$isSandbox) {
                continue;
            }

            $methods[] = [
                'id' => $methodId,
                'name' => $methodConfig['name'] ?? ucfirst($methodId),
                'description' => $methodConfig['description'] ?? '',
                'icon' => $this->getMethodIcon($methodId),
                'available' => true,
                'sandbox' => $isSandbox && ($methodConfig['sandbox_only'] ?? false),
            ];
        }

        return $methods;
    }

    /**
     * Get icon for payment method
     */
    protected function getMethodIcon(string $method): string
    {
        return match($method) {
            'stripe' => 'stripe',
            'virtual' => 'credit-card',
            default => 'credit-card',
        };
    }

    /**
     * Verify payment status
     */
    public function verifyPaymentStatus(Payment $payment): array
    {
        if ($payment->payment_method === 'stripe') {
            return $this->verifyStripePayment($payment);
        } else {
            return [
                'verified' => $payment->status === 'completed',
                'status' => $payment->status,
                'message' => 'Payment status verified',
            ];
        }
    }

    /**
     * Verify Stripe payment status
     */
    public function verifyStripePayment(Payment $payment): array
    {
        try {
            $stripeKey = config('services.stripe.secret');
            if (!$stripeKey) {
                throw new \Exception('Stripe configuration not found');
            }

            \Stripe\Stripe::setApiKey($stripeKey);
            
            $metadata = json_decode($payment->metadata, true);
            $stripeIntentId = $metadata['stripe_payment_intent_id'] ?? null;

            if (!$stripeIntentId) {
                throw new \Exception('No Stripe intent ID found in payment metadata');
            }

            $paymentIntent = \Stripe\PaymentIntent::retrieve($stripeIntentId);

            return [
                'verified' => $paymentIntent->status === 'succeeded',
                'status' => $paymentIntent->status,
                'message' => 'Stripe payment verified',
                'stripe_status' => $paymentIntent->status,
            ];
        } catch (\Exception $e) {
            Log::error('Failed to verify Stripe payment', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'verified' => false,
                'status' => 'verification_failed',
                'message' => 'Failed to verify payment: ' . $e->getMessage(),
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Refund a payment
     */
    public function refundPayment(Payment $payment): array
    {
        try {
            if ($payment->payment_method === 'stripe') {
                return $this->refundStripePayment($payment);
            } else {
                // Virtual payment refund (mark as refunded)
                $payment->update([
                    'status' => 'refunded',
                    'refunded_at' => now(),
                ]);

                // Update booking status
                $payment->booking->update(['status' => 'cancelled']);

                Log::info('Virtual payment refunded', [
                    'payment_id' => $payment->id,
                    'booking_id' => $payment->booking_id,
                ]);

                return [
                    'success' => true,
                    'message' => 'Payment refunded successfully',
                    'payment_id' => $payment->id,
                ];
            }
        } catch (\Exception $e) {
            Log::error('Payment refund failed', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Refund failed: ' . $e->getMessage(),
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Refund a Stripe payment
     */
    public function refundStripePayment(Payment $payment): array
    {
        try {
            $stripeKey = config('services.stripe.secret');
            if (!$stripeKey) {
                throw new \Exception('Stripe configuration not found');
            }

            \Stripe\Stripe::setApiKey($stripeKey);

            $metadata = json_decode($payment->metadata, true);
            $stripeIntentId = $metadata['stripe_payment_intent_id'] ?? null;

            if (!$stripeIntentId) {
                throw new \Exception('No Stripe intent ID found');
            }

            // Create refund
            $refund = \Stripe\Refund::create([
                'payment_intent' => $stripeIntentId,
            ]);

            // Update payment status
            $payment->update([
                'status' => 'refunded',
                'refunded_at' => now(),
            ]);

            // Update booking status
            $payment->booking->update(['status' => 'cancelled']);

            Log::info('Stripe payment refunded', [
                'payment_id' => $payment->id,
                'refund_id' => $refund->id,
            ]);

            return [
                'success' => true,
                'message' => 'Payment refunded successfully',
                'payment_id' => $payment->id,
                'refund_id' => $refund->id,
            ];
        } catch (\Stripe\Exception\ApiErrorException $e) {
            throw new \Exception('Stripe refund failed: ' . $e->getMessage());
        }
    }
}

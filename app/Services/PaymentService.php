<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    /**
     * Process a payment (virtual or Stripe)
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
        $methods = [
            [
                'id' => 'virtual',
                'name' => 'Virtual Card (Demo)',
                'description' => 'Test payment method for development',
                'icon' => 'credit-card',
                'available' => true,
            ],
        ];

        // Add Stripe if configured
        if (config('services.stripe.public')) {
            $methods[] = [
                'id' => 'stripe',
                'name' => 'Credit/Debit Card',
                'description' => 'Powered by Stripe',
                'icon' => 'stripe',
                'available' => true,
            ];
        }

        return $methods;
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

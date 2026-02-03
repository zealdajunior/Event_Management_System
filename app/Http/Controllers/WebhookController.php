<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentWebhookLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

class WebhookController extends Controller
{
    /**
     * Handle Stripe webhook
     */
    public function stripe(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = config('payments.stripe.webhook_secret');

        // Log incoming webhook
        $this->logWebhook('stripe', $payload, $request->header());

        if (!$webhookSecret) {
            Log::warning('Stripe webhook secret not configured');
            return response()->json(['error' => 'Webhook secret not configured'], 400);
        }

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            Log::error('Invalid Stripe webhook payload', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (SignatureVerificationException $e) {
            // Invalid signature
            Log::error('Invalid Stripe webhook signature', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle the event
        try {
            switch ($event->type) {
                case 'payment_intent.succeeded':
                    $this->handlePaymentIntentSucceeded($event->data->object);
                    break;

                case 'payment_intent.payment_failed':
                    $this->handlePaymentIntentFailed($event->data->object);
                    break;

                case 'charge.refunded':
                    $this->handleChargeRefunded($event->data->object);
                    break;

                case 'charge.succeeded':
                    $this->handleChargeSucceeded($event->data->object);
                    break;

                case 'charge.failed':
                    $this->handleChargeFailed($event->data->object);
                    break;

                case 'payment_intent.canceled':
                    $this->handlePaymentIntentCanceled($event->data->object);
                    break;

                default:
                    Log::info('Unhandled Stripe webhook event', ['type' => $event->type]);
            }

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            Log::error('Error processing Stripe webhook', [
                'type' => $event->type,
                'error' => $e->getMessage(),
            ]);
            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }

    /**
     * Handle successful payment intent
     */
    protected function handlePaymentIntentSucceeded($paymentIntent)
    {
        $payment = Payment::where('transaction_id', $paymentIntent->id)->first();

        if ($payment) {
            $payment->update([
                'status' => 'completed',
                'webhook_verified_at' => now(),
            ]);

            // Update booking status
            $payment->booking->update(['status' => 'paid']);

            Log::info('Payment confirmed via webhook', [
                'payment_id' => $payment->id,
                'stripe_intent_id' => $paymentIntent->id,
            ]);
        } else {
            Log::warning('Payment not found for successful intent', [
                'stripe_intent_id' => $paymentIntent->id,
            ]);
        }
    }

    /**
     * Handle failed payment intent
     */
    protected function handlePaymentIntentFailed($paymentIntent)
    {
        $payment = Payment::where('transaction_id', $paymentIntent->id)->first();

        if ($payment) {
            $payment->update([
                'status' => 'failed',
                'webhook_verified_at' => now(),
                'metadata' => json_encode(array_merge(
                    json_decode($payment->metadata, true) ?? [],
                    ['failure_message' => $paymentIntent->last_payment_error->message ?? 'Unknown error']
                )),
            ]);

            // Update booking status
            $payment->booking->update(['status' => 'pending']);

            Log::warning('Payment failed via webhook', [
                'payment_id' => $payment->id,
                'stripe_intent_id' => $paymentIntent->id,
                'error' => $paymentIntent->last_payment_error->message ?? 'Unknown',
            ]);
        }
    }

    /**
     * Handle charge refunded
     */
    protected function handleChargeRefunded($charge)
    {
        // Find payment by charge ID or payment intent ID
        $payment = Payment::where('transaction_id', $charge->payment_intent)
            ->orWhereRaw("JSON_EXTRACT(metadata, '$.stripe_charge_id') = ?", [$charge->id])
            ->first();

        if ($payment) {
            $payment->update([
                'status' => 'refunded',
                'refunded_at' => now(),
                'webhook_verified_at' => now(),
            ]);

            // Update booking status
            $payment->booking->update(['status' => 'cancelled']);

            Log::info('Refund confirmed via webhook', [
                'payment_id' => $payment->id,
                'charge_id' => $charge->id,
            ]);
        }
    }

    /**
     * Handle charge succeeded
     */
    protected function handleChargeSucceeded($charge)
    {
        Log::info('Charge succeeded webhook received', [
            'charge_id' => $charge->id,
            'amount' => $charge->amount / 100,
        ]);
    }

    /**
     * Handle charge failed
     */
    protected function handleChargeFailed($charge)
    {
        Log::warning('Charge failed webhook received', [
            'charge_id' => $charge->id,
            'failure_message' => $charge->failure_message,
        ]);
    }

    /**
     * Handle payment intent canceled
     */
    protected function handlePaymentIntentCanceled($paymentIntent)
    {
        $payment = Payment::where('transaction_id', $paymentIntent->id)->first();

        if ($payment) {
            $payment->update([
                'status' => 'cancelled',
                'webhook_verified_at' => now(),
            ]);

            Log::info('Payment canceled via webhook', [
                'payment_id' => $payment->id,
                'stripe_intent_id' => $paymentIntent->id,
            ]);
        }
    }

    /**
     * Log webhook for reconciliation
     */
    protected function logWebhook(string $provider, string $payload, array $headers = [])
    {
        if (!config('payments.webhooks.enabled')) {
            return;
        }

        try {
            \DB::table('payment_webhook_logs')->insert([
                'provider' => $provider,
                'payload' => $payload,
                'headers' => json_encode($headers),
                'received_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log webhook', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Test webhook endpoint
     */
    public function test(Request $request)
    {
        if (!config('payments.sandbox_mode')) {
            return response()->json(['error' => 'Test webhook only available in sandbox mode'], 403);
        }

        Log::info('Test webhook received', [
            'payload' => $request->all(),
            'headers' => $request->header(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Test webhook received successfully',
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}

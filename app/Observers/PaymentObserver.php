<?php

namespace App\Observers;

use App\Models\Payment;
use App\Services\RevenueService;
use Illuminate\Support\Facades\Log;

class PaymentObserver
{
    protected RevenueService $revenueService;

    public function __construct(RevenueService $revenueService)
    {
        $this->revenueService = $revenueService;
    }

    /**
     * Handle the Payment "created" event.
     */
    public function created(Payment $payment): void
    {
        // Automatically process revenue split for successful payments
        if ($payment->status === 'completed' && $payment->event_id) {
            $this->revenueService->processPaymentRevenue($payment);
        }
    }

    /**
     * Handle the Payment "updated" event.
     */
    public function updated(Payment $payment): void
    {
        // Process revenue split when payment status changes to completed
        if ($payment->isDirty('status') && 
            $payment->status === 'completed' && 
            $payment->event_id) {
            
            // Check if revenue was already processed
            $existingRevenue = $payment->revenues()->exists();
            
            if (!$existingRevenue) {
                $this->revenueService->processPaymentRevenue($payment);
            }
        }
    }
}

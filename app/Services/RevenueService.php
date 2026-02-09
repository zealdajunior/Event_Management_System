<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventRevenue;
use App\Models\Payment;
use App\Models\OrganizerPayout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RevenueService
{
    /**
     * Process revenue split for a payment
     */
    public function processPaymentRevenue(Payment $payment): ?EventRevenue
    {
        try {
            DB::beginTransaction();

            // Get platform fee percentage from config or use default
            $platformFeePercentage = config('payments.platform_fee_percentage', 10.00);

            // Calculate revenue split
            $split = EventRevenue::calculateSplit($payment->amount, $platformFeePercentage);

            // Create revenue record
            $revenue = EventRevenue::create([
                'event_id' => $payment->event_id,
                'payment_id' => $payment->id,
                'total_amount' => $split['total_amount'],
                'platform_fee' => $split['platform_fee'],
                'organizer_earnings' => $split['organizer_earnings'],
                'platform_fee_percentage' => $split['platform_fee_percentage'],
                'status' => 'pending',
                // Funds available after event ends (7 days after event date as safety period)
                'available_at' => $payment->event?->end_date 
                    ? $payment->event->end_date->addDays(7) 
                    : now()->addDays(14),
            ]);

            DB::commit();

            Log::info('Revenue split processed', [
                'payment_id' => $payment->id,
                'event_id' => $payment->event_id,
                'total_amount' => $split['total_amount'],
                'platform_fee' => $split['platform_fee'],
                'organizer_earnings' => $split['organizer_earnings'],
            ]);

            return $revenue;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to process payment revenue', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Make revenues available for payout after event completion
     */
    public function makeRevenuesAvailable(Event $event): int
    {
        $count = 0;

        $pendingRevenues = EventRevenue::where('event_id', $event->id)
            ->where('status', 'pending')
            ->where('available_at', '<=', now())
            ->get();

        foreach ($pendingRevenues as $revenue) {
            if ($revenue->markAsAvailable()) {
                $count++;
            }
        }

        Log::info('Made revenues available for event', [
            'event_id' => $event->id,
            'count' => $count,
        ]);

        return $count;
    }

    /**
     * Create payout for organizer from available revenues
     */
    public function createOrganizerPayout(Event $event): ?OrganizerPayout
    {
        try {
            DB::beginTransaction();

            // Get all available revenues for this event
            $availableRevenues = EventRevenue::where('event_id', $event->id)
                ->where('status', 'available')
                ->get();

            if ($availableRevenues->isEmpty()) {
                return null;
            }

            // Calculate total organizer earnings
            $totalEarnings = $availableRevenues->sum('organizer_earnings');

            // Create payout record
            $payout = OrganizerPayout::create([
                'user_id' => $event->user_id,
                'event_id' => $event->id,
                'amount' => $totalEarnings,
                'payment_method' => 'bank_transfer', // Default, organizer can change
                'status' => 'pending',
            ]);

            // Mark revenues as paid
            foreach ($availableRevenues as $revenue) {
                $revenue->markAsPaid();
            }

            DB::commit();

            Log::info('Created organizer payout', [
                'payout_id' => $payout->id,
                'event_id' => $event->id,
                'user_id' => $event->user_id,
                'amount' => $totalEarnings,
            ]);

            return $payout;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create organizer payout', [
                'event_id' => $event->id,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Get revenue summary for an event
     */
    public function getEventRevenueSummary(Event $event): array
    {
        $revenues = EventRevenue::where('event_id', $event->id)->get();

        return [
            'total_revenue' => $revenues->sum('total_amount'),
            'platform_fees' => $revenues->sum('platform_fee'),
            'organizer_earnings' => $revenues->sum('organizer_earnings'),
            'pending' => $revenues->where('status', 'pending')->sum('organizer_earnings'),
            'available' => $revenues->where('status', 'available')->sum('organizer_earnings'),
            'paid' => $revenues->where('status', 'paid')->sum('organizer_earnings'),
            'ticket_count' => $revenues->count(),
        ];
    }

    /**
     * Get organizer's total earnings across all events
     */
    public function getOrganizerEarningsSummary(int $userId): array
    {
        $events = Event::where('user_id', $userId)->pluck('id');
        $revenues = EventRevenue::whereIn('event_id', $events)->get();
        $payouts = OrganizerPayout::where('user_id', $userId)->get();

        return [
            'total_earned' => $revenues->sum('organizer_earnings'),
            'pending' => $revenues->where('status', 'pending')->sum('organizer_earnings'),
            'available' => $revenues->where('status', 'available')->sum('organizer_earnings'),
            'paid_out' => $payouts->where('status', 'completed')->sum('amount'),
            'pending_payout' => $payouts->where('status', 'pending')->sum('amount'),
            'processing_payout' => $payouts->where('status', 'processing')->sum('amount'),
        ];
    }
}

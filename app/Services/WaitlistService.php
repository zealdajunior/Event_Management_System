<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Waitlist;
use App\Notifications\WaitlistPromotionNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class WaitlistService
{
    /**
     * Join waitlist for an event/ticket
     */
    public function joinWaitlist(int $userId, int $eventId, ?int $ticketId = null, int $quantity = 1): array
    {
        try {
            DB::beginTransaction();

            // Validate event exists and is not expired
            $event = Event::findOrFail($eventId);
            if ($event->date->isPast()) {
                return [
                    'success' => false,
                    'message' => 'Cannot join waitlist for past events.',
                ];
            }

            // Check if user is already on waitlist
            $existingWaitlist = Waitlist::where('user_id', $userId)
                                      ->where('event_id', $eventId)
                                      ->when($ticketId, fn($q) => $q->where('ticket_id', $ticketId))
                                      ->whereIn('status', ['waiting', 'notified'])
                                      ->first();

            if ($existingWaitlist) {
                DB::rollBack();
                return [
                    'success' => false,
                    'message' => 'You are already on the waitlist for this event.',
                ];
            }

            // Validate ticket if specified
            if ($ticketId) {
                $ticket = Ticket::where('id', $ticketId)
                               ->where('event_id', $eventId)
                               ->first();
                
                if (!$ticket) {
                    DB::rollBack();
                    return [
                        'success' => false,
                        'message' => 'Invalid ticket type.',
                    ];
                }

                // Check if tickets are actually sold out
                if ($ticket->quantity > $this->getBookedQuantity($ticket)) {
                    DB::rollBack();
                    return [
                        'success' => false,
                        'message' => 'Tickets are still available. Please book directly.',
                    ];
                }
            }

            // Add to waitlist
            $waitlistEntry = Waitlist::addToWaitlist($userId, $eventId, $ticketId, $quantity);

            DB::commit();

            return [
                'success' => true,
                'message' => "You've been added to the waitlist at position #{$waitlistEntry->position}.",
                'position' => $waitlistEntry->position,
                'waitlist' => $waitlistEntry,
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Waitlist join failed', ['error' => $e->getMessage(), 'user_id' => $userId, 'event_id' => $eventId]);
            
            return [
                'success' => false,
                'message' => 'Failed to join waitlist. Please try again.',
            ];
        }
    }

    /**
     * Leave waitlist
     */
    public function leaveWaitlist(int $userId, int $eventId, ?int $ticketId = null): array
    {
        try {
            $waitlistEntry = Waitlist::where('user_id', $userId)
                                   ->where('event_id', $eventId)
                                   ->when($ticketId, fn($q) => $q->where('ticket_id', $ticketId))
                                   ->whereIn('status', ['waiting', 'notified'])
                                   ->first();

            if (!$waitlistEntry) {
                return [
                    'success' => false,
                    'message' => 'You are not on the waitlist for this event.',
                ];
            }

            DB::beginTransaction();

            // Remove from waitlist
            $position = $waitlistEntry->position;
            $waitlistEntry->delete();

            // Update positions for users behind in line
            Waitlist::where('event_id', $eventId)
                   ->when($ticketId, fn($q) => $q->where('ticket_id', $ticketId))
                   ->where('position', '>', $position)
                   ->where('status', 'waiting')
                   ->decrement('position');

            DB::commit();

            return [
                'success' => true,
                'message' => 'You have been removed from the waitlist.',
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Waitlist leave failed', ['error' => $e->getMessage(), 'user_id' => $userId, 'event_id' => $eventId]);
            
            return [
                'success' => false,
                'message' => 'Failed to leave waitlist. Please try again.',
            ];
        }
    }

    /**
     * Promote users from waitlist when tickets become available
     */
    public function promoteNext(int $eventId, ?int $ticketId = null, int $availableQuantity = 1): array
    {
        try {
            DB::beginTransaction();

            $promoted = Waitlist::promoteNext($eventId, $ticketId, $availableQuantity);

            // Send notifications
            foreach ($promoted as $waitlistEntry) {
                $this->sendPromotionNotification($waitlistEntry);
            }

            DB::commit();

            Log::info('Waitlist promotion completed', [
                'event_id' => $eventId,
                'ticket_id' => $ticketId,
                'promoted_count' => count($promoted),
            ]);

            return $promoted;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Waitlist promotion failed', [
                'error' => $e->getMessage(),
                'event_id' => $eventId,
                'ticket_id' => $ticketId,
            ]);
            
            throw $e;
        }
    }

    /**
     * Send promotion notification to user
     */
    public function sendPromotionNotification(Waitlist $waitlistEntry): void
    {
        try {
            $user = $waitlistEntry->user;
            $event = $waitlistEntry->event;
            $ticket = $waitlistEntry->ticket;

            Notification::send($user, new WaitlistPromotionNotification($waitlistEntry));

            Log::info('Waitlist promotion notification sent', [
                'user_id' => $user->id,
                'event_id' => $event->id,
                'waitlist_id' => $waitlistEntry->id,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send waitlist promotion notification', [
                'error' => $e->getMessage(),
                'waitlist_id' => $waitlistEntry->id,
            ]);
        }
    }

    /**
     * Expire old waitlist notifications
     */
    public function expireOldNotifications(): int
    {
        try {
            $expired = Waitlist::where('status', 'notified')
                              ->where('expires_at', '<', now())
                              ->get();

            $expiredCount = 0;
            
            foreach ($expired as $waitlistEntry) {
                $waitlistEntry->markAsExpired();
                $expiredCount++;

                // Try to promote next person
                $this->promoteNext(
                    $waitlistEntry->event_id,
                    $waitlistEntry->ticket_id,
                    $waitlistEntry->quantity
                );
            }

            Log::info('Expired waitlist notifications processed', ['count' => $expiredCount]);

            return $expiredCount;

        } catch (\Exception $e) {
            Log::error('Failed to expire waitlist notifications', ['error' => $e->getMessage()]);
            return 0;
        }
    }

    /**
     * Get waitlist statistics for an event
     */
    public function getWaitlistStats(int $eventId): array
    {
        return [
            'total_waiting' => Waitlist::forEvent($eventId)->waiting()->count(),
            'total_notified' => Waitlist::forEvent($eventId)->notified()->count(),
            'total_converted' => Waitlist::forEvent($eventId)->where('status', 'converted')->count(),
            'total_expired' => Waitlist::forEvent($eventId)->where('status', 'expired')->count(),
            'average_position' => Waitlist::forEvent($eventId)->waiting()->avg('position'),
        ];
    }

    /**
     * Check if tickets are available for immediate booking
     */
    public function areTicketsAvailable(Event $event, ?int $ticketId = null, int $quantity = 1): bool
    {
        if ($ticketId) {
            $ticket = $event->tickets()->find($ticketId);
            return $ticket && ($ticket->quantity >= $this->getBookedQuantity($ticket) + $quantity);
        }

        // Check if any tickets are available
        foreach ($event->tickets as $ticket) {
            if ($ticket->quantity > $this->getBookedQuantity($ticket)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get booked quantity for a ticket
     */
    private function getBookedQuantity(Ticket $ticket): int
    {
        return $ticket->bookings()
                     ->whereHas('payment', function($query) {
                         $query->whereIn('status', ['completed', 'pending']);
                     })
                     ->sum('quantity');
    }

    /**
     * Auto-promote waitlist when tickets become available (called from booking cancellations)
     */
    public function handleTicketRelease(int $eventId, ?int $ticketId = null, int $releasedQuantity = 1): void
    {
        try {
            // Only promote if there are people waiting
            $waitingCount = Waitlist::forEvent($eventId)
                                  ->when($ticketId, fn($q) => $q->forTicket($ticketId))
                                  ->waiting()
                                  ->count();

            if ($waitingCount > 0) {
                $this->promoteNext($eventId, $ticketId, $releasedQuantity);
            }

        } catch (\Exception $e) {
            Log::error('Auto waitlist promotion failed', [
                'error' => $e->getMessage(),
                'event_id' => $eventId,
                'ticket_id' => $ticketId,
            ]);
        }
    }

    /**
     * Get user's position in waitlist
     */
    public function getUserPosition(int $userId, int $eventId, ?int $ticketId = null): ?int
    {
        $waitlistEntry = Waitlist::where('user_id', $userId)
                               ->where('event_id', $eventId)
                               ->when($ticketId, fn($q) => $q->where('ticket_id', $ticketId))
                               ->where('status', 'waiting')
                               ->first();

        return $waitlistEntry?->position;
    }

    /**
     * Clean up expired and converted waitlist entries (cleanup job)
     */
    public function cleanup(): array
    {
        $stats = [
            'expired' => 0,
            'cleaned' => 0,
        ];

        try {
            // Expire old notifications
            $stats['expired'] = $this->expireOldNotifications();

            // Clean up old converted/expired entries (older than 30 days)
            $stats['cleaned'] = Waitlist::whereIn('status', ['converted', 'expired'])
                                      ->where('updated_at', '<', now()->subDays(30))
                                      ->delete();

            Log::info('Waitlist cleanup completed', $stats);

        } catch (\Exception $e) {
            Log::error('Waitlist cleanup failed', ['error' => $e->getMessage()]);
        }

        return $stats;
    }
}
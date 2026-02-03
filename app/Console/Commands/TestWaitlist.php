<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Waitlist;
use App\Services\WaitlistService;
use Illuminate\Console\Command;

class TestWaitlist extends Command
{
    protected $signature = 'test:waitlist';
    protected $description = 'Test the waitlist system functionality';

    protected $waitlistService;

    public function __construct(WaitlistService $waitlistService)
    {
        parent::__construct();
        $this->waitlistService = $waitlistService;
    }

    public function handle()
    {
        $this->info('🧪 Testing Waitlist System...');

        // Get the latest future event for testing
        $event = Event::with('tickets')
                     ->where('date', '>', now())
                     ->latest('id')
                     ->first();
                     
        $user = User::where('email', 'testuser1@example.com')->first();

        if (!$event || !$user) {
            $this->error('❌ Run "php artisan create:test-data" first to set up test data');
            return 1;
        }

        $ticket = $event->tickets->first();

        if (!$ticket) {
            $this->error('❌ Event needs at least one ticket to test waitlist');
            return 1;
        }

        $this->info("📅 Testing with event: {$event->name}");
        $this->info("🎫 Testing with ticket: {$ticket->type}");
        $this->info("👤 Testing with user: {$user->name} ({$user->email})");

        // Check ticket availability first
        $this->info("\n🔸 Pre-check: Ticket availability...");
        $availableQuantity = $event->getAvailableTicketQuantity($ticket->id);
        $this->info("   Available tickets: {$availableQuantity}/{$ticket->quantity}");
        
        if ($availableQuantity > 0) {
            $this->info("⚠️  Tickets are still available. Waitlist requires sold-out tickets.");
            $this->info("   You may need to book these tickets first to test waitlist.");
        }

        // Test 1: Join waitlist
        $this->info("\n🔸 Test 1: Joining waitlist...");
        $result = $this->waitlistService->joinWaitlist($user->id, $event->id, $ticket->id, 2);
        
        if ($result['success']) {
            $this->info("✅ Successfully joined waitlist at position #{$result['position']}");
        } else {
            $this->error("❌ Failed to join waitlist: {$result['message']}");
        }

        // Test 2: Check waitlist status
        $this->info("\n🔸 Test 2: Checking waitlist status...");
        $waitlistEntry = Waitlist::where('user_id', $user->id)
                               ->where('event_id', $event->id)
                               ->where('ticket_id', $ticket->id)
                               ->first();

        if ($waitlistEntry) {
            $this->info("✅ Waitlist entry found:");
            $this->info("   Position: #{$waitlistEntry->position}");
            $this->info("   Status: {$waitlistEntry->status}");
            $this->info("   Quantity: {$waitlistEntry->quantity}");
        } else {
            $this->error("❌ Waitlist entry not found");
            return 1;
        }

        // Test 3: Check event methods
        $this->info("\n🔸 Test 3: Testing event helper methods...");
        $totalWaitlist = $event->getTotalWaitlistCount();
        $userPosition = $event->getUserWaitlistPosition($user->id, $ticket->id);
        $isOnWaitlist = $event->userIsOnWaitlist($user->id, $ticket->id);

        $this->info("✅ Event helper methods:");
        $this->info("   Total on waitlist: {$totalWaitlist}");
        $this->info("   User position: #{$userPosition}");
        $this->info("   User on waitlist: " . ($isOnWaitlist ? 'Yes' : 'No'));

        // Test 4: Simulate promotion
        $this->info("\n🔸 Test 4: Simulating waitlist promotion...");
        try {
            $waitlistEntry->markAsNotified();
            $this->info("✅ Marked user as notified");
            $this->info("   Status: {$waitlistEntry->fresh()->status}");
            $this->info("   Expires at: {$waitlistEntry->fresh()->expires_at}");
        } catch (\Exception $e) {
            $this->error("❌ Failed to mark as notified: {$e->getMessage()}");
        }

        // Test 5: Test leaving waitlist
        $this->info("\n🔸 Test 5: Testing leave waitlist...");
        $result = $this->waitlistService->leaveWaitlist($user->id, $event->id, $ticket->id);
        
        if ($result['success']) {
            $this->info("✅ Successfully left waitlist");
        } else {
            $this->error("❌ Failed to leave waitlist: {$result['message']}");
        }

        // Verify cleanup
        $remainingEntry = Waitlist::where('user_id', $user->id)
                                ->where('event_id', $event->id)
                                ->where('ticket_id', $ticket->id)
                                ->first();

        if (!$remainingEntry) {
            $this->info("✅ Waitlist entry successfully removed");
        } else {
            $this->error("❌ Waitlist entry still exists after leaving");
        }

        $this->info("\n🎉 Waitlist system test completed!");
        return 0;
    }
}

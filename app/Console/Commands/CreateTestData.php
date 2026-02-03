<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Console\Command;

class CreateTestData extends Command
{
    protected $signature = 'create:test-data';
    protected $description = 'Create test data for waitlist functionality';

    public function handle()
    {
        $this->info('🔧 Creating test data for waitlist system...');

        // Get first user or create one
        $firstUser = User::first();
        
        if (!$firstUser) {
            $firstUser = User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]);
            $this->info("✅ Created admin user: {$firstUser->name}");
        }

        // Create a future event
        $event = Event::create([
            'name' => 'Future Test Event for Waitlist',
            'description' => 'A test event specifically created for waitlist testing functionality',
            'date' => now()->addDays(30),
            'end_date' => now()->addDays(30)->addHours(3),
            'location' => 'Test Conference Center',
            'user_id' => $firstUser->id,
            'capacity' => 50,
            'price' => 25.00,
            'status' => 'active',
            'allow_registrations' => true,
            'is_featured' => true,
        ]);

        $this->info("✅ Created event: {$event->name} (ID: {$event->id})");

        // Create limited tickets to test sold-out scenario
        $ticket = Ticket::create([
            'event_id' => $event->id,
            'type' => 'general',
            'price' => 25.00,
            'quantity' => 3, // Small number to test sold-out
        ]);

        $this->info("✅ Created ticket: {$ticket->type} (ID: {$ticket->id}) - Quantity: {$ticket->quantity}");

        // Create VIP ticket
        $vipTicket = Ticket::create([
            'event_id' => $event->id,
            'type' => 'vip',
            'price' => 75.00,
            'quantity' => 1, // Only 1 to test waitlist
        ]);

        $this->info("✅ Created VIP ticket: {$vipTicket->type} (ID: {$vipTicket->id}) - Quantity: {$vipTicket->quantity}");

        // Create some test users if they don't exist
        for ($i = 1; $i <= 3; $i++) {
            $email = "testuser{$i}@example.com";
            
            if (!User::where('email', $email)->exists()) {
                $user = User::create([
                    'name' => "Test User {$i}",
                    'email' => $email,
                    'email_verified_at' => now(),
                    'password' => bcrypt('password'),
                    'role' => 'user',
                ]);
                
                $this->info("✅ Created user: {$user->name} ({$user->email})");
            } else {
                $this->info("ℹ️  User {$email} already exists");
            }
        }

        $this->info("\n🎉 Test data creation completed!");
        $this->info("\n📋 Summary:");
        $this->info("   Event: {$event->name}");
        $this->info("   Date: {$event->date->format('M j, Y g:i A')}");
        $this->info("   General Tickets: {$ticket->quantity} available");
        $this->info("   VIP Tickets: {$vipTicket->quantity} available");
        $this->info("\n💡 You can now test the waitlist by:");
        $this->info("   1. Booking all available tickets first");
        $this->info("   2. Then testing waitlist functionality");
        $this->info("   3. Run: php artisan test:waitlist");

        return 0;
    }
}

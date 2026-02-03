<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\User;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SellOutTickets extends Command
{
    protected $signature = 'sellout:tickets';
    protected $description = 'Create bookings to sell out tickets for waitlist testing';

    public function handle()
    {
        $this->info('🎫 Selling out tickets for waitlist testing...');

        // Get the latest future event
        $event = Event::with('tickets')
                     ->where('date', '>', now())
                     ->latest('id')
                     ->first();

        if (!$event) {
            $this->error('❌ No future events found. Run "php artisan create:test-data" first.');
            return 1;
        }

        $users = User::where('email', 'like', 'testuser%@example.com')->get();
        
        if ($users->count() < 3) {
            $this->error('❌ Need test users. Run "php artisan create:test-data" first.');
            return 1;
        }

        $this->info("📅 Selling out tickets for: {$event->name}");

        try {
            DB::beginTransaction();

            foreach ($event->tickets as $ticket) {
                $this->info("\n🎫 Selling out {$ticket->type} tickets (Quantity: {$ticket->quantity})");
                
                $remainingQuantity = $ticket->quantity;
                $userIndex = 0;
                
                while ($remainingQuantity > 0 && $userIndex < $users->count()) {
                    $user = $users[$userIndex];
                    $quantityToBook = min($remainingQuantity, 2); // Book 1-2 tickets per user
                    
                    // Create booking
                    $booking = Booking::create([
                        'user_id' => $user->id,
                        'event_id' => $event->id,
                        'ticket_id' => $ticket->id,
                        'quantity' => $quantityToBook,
                        'booking_date' => now(),
                        'status' => 'confirmed',
                    ]);

                    // Create payment
                    $payment = Payment::create([
                        'booking_id' => $booking->id,
                        'amount' => $ticket->price * $quantityToBook,
                        'payment_method' => 'test',
                        'payment_date' => now(),
                        'status' => 'completed',
                        'transaction_id' => 'test_' . uniqid(),
                        'metadata' => json_encode([
                            'test_payment' => true,
                            'created_for' => 'waitlist_testing',
                        ]),
                    ]);

                    $this->info("   ✅ {$user->name} booked {$quantityToBook} tickets");
                    
                    $remainingQuantity -= $quantityToBook;
                    $userIndex++;
                }

                if ($remainingQuantity > 0) {
                    $this->warn("   ⚠️  {$remainingQuantity} tickets remaining (not enough users)");
                }
            }

            DB::commit();

            $this->info("\n🎉 Tickets sold out successfully!");
            $this->info("\n📊 Current status:");
            
            foreach ($event->tickets as $ticket) {
                $bookedQuantity = $ticket->bookings()
                                        ->whereHas('payment', function($query) {
                                            $query->where('status', 'completed');
                                        })
                                        ->sum('quantity');
                                        
                $this->info("   {$ticket->type}: {$bookedQuantity}/{$ticket->quantity} sold");
            }

            $this->info("\n💡 Now you can test the waitlist system:");
            $this->info("   php artisan test:waitlist");

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ Failed to sell out tickets: {$e->getMessage()}");
            return 1;
        }

        return 0;
    }
}

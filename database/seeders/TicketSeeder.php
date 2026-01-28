<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Ticket;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $events = Event::all();

        foreach ($events as $event) {
            // General Admission tickets
            Ticket::create([
                'event_id' => $event->id,
                'type' => 'General Admission',
                'price' => 50.00,
                'quantity' => 100,
            ]);

            // VIP tickets
            Ticket::create([
                'event_id' => $event->id,
                'type' => 'VIP',
                'price' => 150.00,
                'quantity' => 20,
            ]);

            // Early Bird tickets
            Ticket::create([
                'event_id' => $event->id,
                'type' => 'Early Bird',
                'price' => 35.00,
                'quantity' => 50,
            ]);
        }

        $this->command->info('Created 3 ticket types for each event!');
    }
}

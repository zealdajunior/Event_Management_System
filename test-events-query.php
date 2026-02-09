<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Event;
use Carbon\Carbon;

echo "Current time: " . now() . "\n";
echo "Today: " . today() . "\n\n";

$events = Event::where('approval_status', 'approved')
    ->where('status', 'active')
    ->where('date', '>=', now())
    ->get();

echo "Events found: " . $events->count() . "\n\n";

if ($events->count() > 0) {
    echo "First 5 events:\n";
    foreach($events->take(5) as $event) {
        echo "  - {$event->name} (Date: {$event->date})\n";
    }
} else {
    echo "No events found!\n";
    echo "\nChecking without date filter:\n";
    $allEvents = Event::where('approval_status', 'approved')
        ->where('status', 'active')
        ->get();
    echo "Events without date filter: " . $allEvents->count() . "\n";
    
    if ($allEvents->count() > 0) {
        foreach($allEvents->take(3) as $event) {
            $isPast = $event->date < now();
            echo "  - {$event->name} (Date: {$event->date}) " . ($isPast ? "[PAST]" : "[FUTURE]") . "\n";
        }
    }
}

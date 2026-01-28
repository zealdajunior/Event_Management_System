<?php

// Test database operations
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Testing Database Operations:\n\n";

// Test 1: Can we create and save a booking?
try {
    $booking = new App\Models\Booking();
    $booking->user_id = 1;
    $booking->event_id = 1;
    $booking->ticket_id = 1;
    $booking->booking_date = now();
    $booking->status = 'confirmed';
    $booking->quantity = 1;
    $result = $booking->save();
    echo "✓ Booking Save Test: " . ($result ? "SUCCESS" : "FAILED") . "\n";
    if ($result) {
        echo "  - Booking ID: {$booking->id}\n";
        $booking->delete(); // Clean up
        echo "  - Cleaned up test booking\n";
    }
} catch (\Exception $e) {
    echo "✗ Booking Save Test FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 2: Can we create an event request?
try {
    $eventRequest = App\Models\EventRequest::create([
        'user_id' => 1,
        'event_title' => 'Test Event Request',
        'event_description' => 'Testing database operations',
        'start_date' => now()->addDays(7),
        'end_date' => now()->addDays(8),
        'venue' => 'Test Venue',
        'status' => 'pending',
    ]);
    echo "✓ Event Request Create Test: SUCCESS\n";
    echo "  - Event Request ID: {$eventRequest->id}\n";
    $eventRequest->delete(); // Clean up
    echo "  - Cleaned up test event request\n";
} catch (\Exception $e) {
    echo "✗ Event Request Create Test FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 3: Can we save user onboarding data?
try {
    $user = App\Models\User::first();
    if ($user) {
        $originalData = [
            'location' => $user->location,
            'interests' => $user->interests,
            'bio' => $user->bio,
        ];
        
        $user->location = 'Test Location';
        $user->interests = ['music', 'sports'];
        $user->bio = 'Test bio';
        $result = $user->save();
        
        echo "✓ User Update Test: " . ($result ? "SUCCESS" : "FAILED") . "\n";
        
        // Restore original data
        $user->location = $originalData['location'];
        $user->interests = $originalData['interests'];
        $user->bio = $originalData['bio'];
        $user->save();
        echo "  - Restored original user data\n";
    } else {
        echo "⚠ User Update Test: SKIPPED (No users in database)\n";
    }
} catch (\Exception $e) {
    echo "✗ User Update Test FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 4: Can we create a password reset code?
try {
    $resetCode = App\Models\PasswordResetCode::createForEmail('test@example.com');
    echo "✓ Password Reset Code Test: SUCCESS\n";
    echo "  - Reset Code: {$resetCode->code}\n";
    echo "  - Expires: {$resetCode->expires_at}\n";
    $resetCode->delete(); // Clean up
    echo "  - Cleaned up test reset code\n";
} catch (\Exception $e) {
    echo "✗ Password Reset Code Test FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 5: Check if all tables have data or can accept data
echo "Database Tables Status:\n";
try {
    $tables = [
        'users' => App\Models\User::count(),
        'events' => App\Models\Event::count(),
        'bookings' => App\Models\Booking::count(),
        'tickets' => App\Models\Ticket::count(),
        'event_requests' => App\Models\EventRequest::count(),
        'favorites' => App\Models\Favorite::count(),
        'password_reset_codes' => App\Models\PasswordResetCode::count(),
        'payments' => App\Models\Payment::count(),
    ];
    
    foreach ($tables as $table => $count) {
        echo "  - {$table}: {$count} records\n";
    }
} catch (\Exception $e) {
    echo "✗ Table Count Test FAILED: " . $e->getMessage() . "\n";
}

echo "\n✅ Database operations test complete!\n";

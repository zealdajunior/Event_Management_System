<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$email = 'zealdajunior4@gmail.com';

echo "Testing login for: {$email}\n";
echo "================\n\n";

$user = \App\Models\User::where('email', $email)->first();

if (!$user) {
    echo "ERROR: User not found!\n";
    exit(1);
}

echo "User Details:\n";
echo "ID: {$user->id}\n";
echo "Name: {$user->name}\n";
echo "Email: {$user->email}\n";
echo "Role: {$user->role}\n";
echo "Is Super Admin: " . ($user->is_super_admin ? 'YES' : 'NO') . "\n";
echo "Email Verified: " . ($user->email_verified_at ? 'YES' : 'NO') . "\n";
echo "Onboarding Completed: " . ($user->onboarding_completed ? 'YES' : 'NO') . "\n";
echo "Password Hash: " . substr($user->password, 0, 20) . "...\n";
echo "\n";

// Try to authenticate with a test password
echo "Attempting authentication...\n";

// Check if password is hashed properly
if (empty($user->password)) {
    echo "ERROR: User has no password set!\n";
} else {
    echo "Password is set (hash exists)\n";
    
    // Test with common passwords
    $testPasswords = ['password', 'Password@123', '12345678', 'admin123'];
    
    foreach ($testPasswords as $testPass) {
        if (\Illuminate\Support\Facades\Hash::check($testPass, $user->password)) {
            echo "✓ Password match found: {$testPass}\n";
            break;
        }
    }
}

echo "\n";
echo "Checking authentication guards and config...\n";
echo "Default Guard: " . config('auth.defaults.guard') . "\n";
echo "Fortify Guard: " . config('fortify.guard') . "\n";
echo "Fortify Home: " . config('fortify.home') . "\n";

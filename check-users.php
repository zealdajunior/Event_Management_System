<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Checking Users:\n";
echo "================\n\n";

$users = \App\Models\User::where('role', 'user')->get(['id', 'name', 'email', 'email_verified_at', 'onboarding_completed']);

if ($users->isEmpty()) {
    echo "No regular users found.\n";
} else {
    foreach ($users as $user) {
        echo "ID: {$user->id}\n";
        echo "Name: {$user->name}\n";
        echo "Email: {$user->email}\n";
        echo "Email Verified: " . ($user->email_verified_at ? 'YES' : 'NO') . "\n";
        echo "Onboarding Completed: " . ($user->onboarding_completed ? 'YES' : 'NO') . "\n";
        echo "---\n";
    }
}

echo "\nAdmins:\n";
echo "================\n\n";

$admins = \App\Models\User::where('role', 'admin')->get(['id', 'name', 'email', 'is_super_admin']);

foreach ($admins as $admin) {
    echo "ID: {$admin->id}\n";
    echo "Name: {$admin->name}\n";
    echo "Email: {$admin->email}\n";
    echo "Super Admin: " . ($admin->is_super_admin ? 'YES' : 'NO') . "\n";
    echo "---\n";
}

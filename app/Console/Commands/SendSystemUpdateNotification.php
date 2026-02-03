<?php

namespace App\Console\Commands;

use App\Services\NotificationService;
use App\Models\User;
use Illuminate\Console\Command;

class SendSystemUpdateNotification extends Command
{
    protected $signature = 'notification:system-update {message} {--title=System Update}';
    protected $description = 'Send a system update notification to all users';

    public function handle()
    {
        $notificationService = new NotificationService();
        $title = $this->option('title');
        $message = $this->argument('message');

        // Send to users only (not admins)
        $notificationService->sendToRole(
            'user',
            $title,
            $message,
            'info',
            ['type' => 'system_update'],
            'app'
        );

        $userCount = User::where('role', 'user')->count();
        $this->info("System update notification sent to {$userCount} users!");
        
        return 0;
    }
}
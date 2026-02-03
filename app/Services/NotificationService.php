<?php

namespace App\Services;

use App\Models\AppNotification;
use App\Models\NotificationSetting;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Send notification to a user or multiple users
     */
    public function send(
        array|User $users,
        string $title,
        string $message,
        string $type = 'info',
        array $data = [],
        ?string $channel = null
    ): void {
        $users = is_array($users) ? $users : [$users];

        foreach ($users as $user) {
            $this->sendToUser($user, $title, $message, $type, $data, $channel);
        }
    }

    /**
     * Send notification to a single user
     */
    public function sendToUser(
        User $user,
        string $title,
        string $message,
        string $type = 'info',
        array $data = [],
        ?string $channel = null
    ): void {
        // Determine the channel based on user settings if not specified
        $finalChannel = $channel ?? $this->getChannelForUser($user, $type);

        if ($finalChannel === 'none') {
            return;
        }

        // Send in-app notification
        if (in_array($finalChannel, ['app', 'both'])) {
            AppNotification::create([
                'user_id' => $user->id,
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'channel' => $finalChannel,
                'data' => $data
            ]);
        }

        // Send email notification
        if (in_array($finalChannel, ['email', 'both'])) {
            $this->sendEmailNotification($user, $title, $message, $type, $data);
        }
    }

    /**
     * Send notification to all users
     */
    public function sendToAllUsers(
        string $title,
        string $message,
        string $type = 'announcement',
        array $data = [],
        ?string $channel = null
    ): void {
        $users = User::all();
        $this->send($users->toArray(), $title, $message, $type, $data, $channel);
    }

    /**
     * Send notification to all users with a specific role
     */
    public function sendToRole(
        string $role,
        string $title,
        string $message,
        string $type = 'info',
        array $data = [],
        ?string $channel = null
    ): void {
        $users = User::where('role', $role)->get();
        $this->send($users->toArray(), $title, $message, $type, $data, $channel);
    }

    /**
     * Send event-related notification
     */
    public function sendEventNotification(
        string $eventType,
        array|User $users,
        string $title,
        string $message,
        array $data = []
    ): void {
        $notificationType = "event_{$eventType}";
        $this->send($users, $title, $message, 'info', $data);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(int $notificationId, int $userId): bool
    {
        $notification = AppNotification::where('id', $notificationId)
            ->where('user_id', $userId)
            ->first();

        if ($notification) {
            $notification->markAsRead();
            return true;
        }

        return false;
    }

    /**
     * Mark all notifications as read for a user
     */
    public function markAllAsRead(int $userId): int
    {
        $count = AppNotification::where('user_id', $userId)
            ->where('is_read', false)
            ->count();

        AppNotification::where('user_id', $userId)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return $count;
    }

    /**
     * Get user's notification settings
     */
    private function getChannelForUser(User $user, string $type): string
    {
        $setting = NotificationSetting::where('user_id', $user->id)
            ->where('notification_type', $type)
            ->first();

        if (!$setting) {
            // Create default setting
            NotificationSetting::createDefaultsForUser($user->id);
            $defaults = NotificationSetting::getDefaultSettings();
            return $defaults[$type]['channel'] ?? 'app';
        }

        return $setting->enabled ? $setting->channel : 'none';
    }

    /**
     * Send email notification
     */
    private function sendEmailNotification(
        User $user,
        string $title,
        string $message,
        string $type,
        array $data
    ): void {
        try {
            Mail::send(
                'emails.notification',
                compact('title', 'message', 'type', 'data'),
                function ($mail) use ($user, $title) {
                    $mail->to($user->email)
                        ->subject($title);
                }
            );
        } catch (\Exception $e) {
            Log::error('Failed to send email notification: ' . $e->getMessage());
        }
    }

    /**
     * Get recent notifications for a user
     */
    public function getRecentNotifications(int $userId, int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return AppNotification::forUser($userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get unread count for a user
     */
    public function getUnreadCount(int $userId): int
    {
        return AppNotification::forUser($userId)->unread()->count();
    }

    /**
     * Delete old notifications (cleanup)
     */
    public function cleanup(int $daysOld = 90): int
    {
        return AppNotification::where('created_at', '<', now()->subDays($daysOld))
            ->delete();
    }
}
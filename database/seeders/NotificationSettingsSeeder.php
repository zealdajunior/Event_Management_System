<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\NotificationSetting;

class NotificationSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notificationTypes = [
            'event_created' => 'app',
            'event_updated' => 'both', 
            'event_cancelled' => 'both',
            'booking_confirmed' => 'both',
            'booking_cancelled' => 'both',
            'announcement' => 'app',
            'system_update' => 'app',
        ];

        $users = User::all();

        foreach ($users as $user) {
            foreach ($notificationTypes as $type => $defaultChannel) {
                NotificationSetting::firstOrCreate([
                    'user_id' => $user->id,
                    'notification_type' => $type,
                ], [
                    'channel' => $defaultChannel,
                    'enabled' => true,
                ]);
            }
        }

        $this->command->info('Default notification settings created for all users.');
    }
}

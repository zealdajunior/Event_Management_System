<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );

        // Create default admin user (first admin is automatically super admin)
        $firstAdmin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'is_super_admin' => true, // First admin is super admin
                'email_verified_at' => now(),
            ]
        );
        
        // If this is the first admin ever created, make them super admin
        if (!$firstAdmin->wasRecentlyCreated && !$firstAdmin->is_super_admin) {
            $adminCount = User::where('role', 'admin')->count();
            if ($adminCount === 1) {
                $firstAdmin->update(['is_super_admin' => true]);
            }
        }
    }
}

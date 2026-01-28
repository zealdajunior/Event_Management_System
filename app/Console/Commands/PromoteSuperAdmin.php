<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class PromoteSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:promote-super {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Promote an admin user to super admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email {$email} not found!");
            return 1;
        }
        
        if ($user->role !== 'admin') {
            $this->error("User must be an admin first! Current role: {$user->role}");
            return 1;
        }
        
        if ($user->is_super_admin) {
            $this->info("User {$user->name} is already a super admin!");
            return 0;
        }
        
        $user->is_super_admin = true;
        $user->save();
        
        $this->info("✅ Successfully promoted {$user->name} ({$user->email}) to Super Admin!");
        $this->line("This user now has full system privileges including:");
        $this->line("  - Delete users");
        $this->line("  - Promote/demote admins");
        $this->line("  - Final approval on event requests");
        $this->line("  - Access to all system settings");
        
        return 0;
    }
}

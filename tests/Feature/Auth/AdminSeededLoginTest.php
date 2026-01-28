<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSeededLoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function seeded_admin_can_login_and_is_redirected_to_admin_dashboard()
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'admin123',
        ]);

        $response->assertRedirect('/dashboard');

        $this->assertDatabaseHas('users', [
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        $admin = \App\Models\User::where('email', 'admin@example.com')->first();

        $this->actingAs($admin)->get('/dashboard')->assertRedirect('/admin-dashboard');
        $this->actingAs($admin)->get('/admin-dashboard')->assertStatus(200);
    }
}

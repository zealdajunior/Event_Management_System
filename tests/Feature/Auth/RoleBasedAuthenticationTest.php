<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleBasedAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_register_and_is_redirected_to_user_dashboard()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/dashboard');

        $this->assertDatabaseHas('users', [
            'email' => 'testuser@example.com',
            'role' => 'user',
        ]);

        $user = User::where('email', 'testuser@example.com')->first();
        $this->assertEquals('user', $user->role);

        // Test that accessing /dashboard redirects to user dashboard
        $this->actingAs($user)->get('/dashboard')->assertRedirect('/user-dashboard');
    }

    /** @test */
    public function admin_can_register_and_is_redirected_to_user_dashboard()
    {
        $response = $this->post('/register', [
            'name' => 'Test Admin',
            'email' => 'testadmin@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // Note: Registration defaults to 'user' role. Admin role would need to be set manually or through a different process
        $response->assertRedirect('/dashboard');

        $this->assertDatabaseHas('users', [
            'email' => 'testadmin@example.com',
            'role' => 'user',
        ]);

        $user = User::where('email', 'testadmin@example.com')->first();
        // Test that accessing /dashboard redirects to user dashboard (since role is 'user')
        $this->actingAs($user)->get('/dashboard')->assertRedirect('/user-dashboard');
    }

    /** @test */
    public function user_can_login_and_access_user_dashboard()
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $response = $this->post('/login', [
            'email' => 'user@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');

        // Test that accessing /dashboard redirects to user dashboard
        $this->actingAs($user)->get('/dashboard')->assertRedirect('/user-dashboard');
        $this->actingAs($user)->get('/user-dashboard')->assertStatus(200);
    }

    /** @test */
    public function admin_can_login_and_access_admin_dashboard()
    {
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');

        // Test that accessing /dashboard redirects to admin dashboard
        $this->actingAs($admin)->get('/dashboard')->assertRedirect('/admin-dashboard');
        $this->actingAs($admin)->get('/admin-dashboard')->assertStatus(200);
    }

    /** @test */
    public function user_cannot_access_admin_dashboard()
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $this->actingAs($user)->get('/admin-dashboard')->assertStatus(403);
    }

    /** @test */
    public function admin_can_access_admin_dashboard()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin)->get('/admin-dashboard')->assertStatus(200);
    }

    /** @test */
    public function user_can_logout()
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $this->actingAs($user)->post('/logout')->assertRedirect('/');

        $this->assertGuest();
    }

    /** @test */
    public function admin_can_logout()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin)->post('/logout')->assertRedirect('/');

        $this->assertGuest();
    }
}

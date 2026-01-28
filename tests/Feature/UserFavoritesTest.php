<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserFavoritesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_add_event_to_favorites_and_see_it_on_dashboard()
    {
        $user = User::factory()->create(['role' => 'user']);
        if ($user instanceof \Illuminate\Database\Eloquent\Collection) {
            $user = $user->first();
        }
        $event = Event::factory()->create(['name' => 'Indie Concert']);

        $response = $this->actingAs($user)
            ->post(route('favorites.toggle', $event));

        $response->assertSessionHas('success', 'Event added to favorites.');

        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'event_id' => $event->id,
        ]);

        // Dashboard should show the favorited event
        $this->actingAs($user)
            ->withSession(['active_tab' => 'favorites'])
            ->get(route('user.dashboard'))
            ->assertStatus(200)
            ->assertSee('My Favorites')
            ->assertSee('Indie Concert')
            ->assertSee('⭐ Favorite')
            ->assertDontSee('No Favorites Yet');
    }

    /** @test */
    public function user_can_remove_event_from_favorites()
    {
        $user = User::factory()->create(['role' => 'user']);
        $event = Event::factory()->create(['name' => 'Indie Concert']);

        // Add to favorites
        $this->actingAs($user)->post(route('favorites.toggle', $event));

        // Remove from favorites
        $response = $this->actingAs($user)->post(route('favorites.toggle', $event));
        $response->assertSessionHas('success', 'Event removed from favorites.');

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'event_id' => $event->id,
        ]);

        $this->actingAs($user)
            ->withSession(['active_tab' => 'favorites'])
            ->get(route('user.dashboard'))
            ->assertStatus(200)
            ->assertSee('No Favorites Yet')
            ->assertDontSee('⭐ Favorite');
    }
}

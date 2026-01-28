<?php

namespace Tests\Feature;

use App\Models\EventRequest;
use App\Models\User;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminEventRequestManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_approve_event_request_and_event_is_created()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        if ($admin instanceof \Illuminate\Database\Eloquent\Collection) {
            $admin = $admin->first();
        }
        $user = User::factory()->create();
        if ($user instanceof \Illuminate\Database\Eloquent\Collection) {
            $user = $user->first();
        }

        $req = EventRequest::create([
            'user_id' => $user->id,
            'event_title' => 'Test Event',
            'event_description' => 'Description',
            'start_date' => now()->addWeek(),
            'end_date' => now()->addWeek()->addDay(),
            'venue' => 'Test Venue',
            'status' => EventRequest::STATUS_PENDING,
        ]);

        $this->actingAs($admin)->post(route('admin.event_requests.approve', $req->id))->assertRedirect(route('admin.event_requests.index'));

        $this->assertDatabaseHas('event_requests', [
            'id' => $req->id,
            'status' => EventRequest::STATUS_APPROVED,
        ]);

        $this->assertDatabaseHas('events', [
            'name' => 'Test Event',
            'venue_id' => \App\Models\Venue::where('name', 'Test Venue')->first()->id,
        ]);
    }

    /** @test */
    public function admin_can_delete_event_request()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();

        $req = EventRequest::create([
            'user_id' => $user->id,
            'event_title' => 'Delete Me',
            'event_description' => 'Description',
            'start_date' => now()->addWeek(),
            'end_date' => now()->addWeek()->addDay(),
            'venue' => 'Delete Venue',
            'status' => EventRequest::STATUS_PENDING,
        ]);

        $this->actingAs($admin)->delete(route('admin.event_requests.destroy', $req->id))->assertRedirect(route('admin.event_requests.index'));

        $this->assertDatabaseMissing('event_requests', [
            'id' => $req->id,
        ]);
    }
}

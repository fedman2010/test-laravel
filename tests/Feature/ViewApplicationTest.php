<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ViewApplicationTest extends TestCase
{
    use DatabaseMigrations;

    public function test_manager_can_view_application()
    {
        $client = User::factory()->create();
        $manager = User::factory()->create(['role' => User::ROLE_MANAGER]);

        $application = Application::factory()->create(
            [
                'user_id' => $client->id
            ]
        );

        $response = $this->actingAs($manager)
            ->get('/applications/' . $application->id);

        $response->assertSuccessful();
        $response->assertSeeText($application->topic);
        $response->assertSeeText($application->message);
        $response->assertSeeText($application->file);
    }

    public function test_client_cannot_view_application()
    {
        $client = User::factory()->create();

        $application = Application::factory()->create(
            [
                'user_id' => $client->id
            ]
        );

        $response = $this->actingAs($client)
            ->get('/applications/' . $application->id);

        $response->assertStatus(403);
    }
}

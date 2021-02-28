<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CanViewApplicationsTest extends TestCase
{
    use DatabaseMigrations;

    public function test_client_can_view_his_applications()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        /* @var $apps Collection */
        $apps = Application::factory()->count(2)->create(
            [
                'user_id' => $user1->id
            ]
        );
        $app = Application::factory()->create(
            [
                'user_id' => $user2->id
            ]
        );

        $user1->refresh();
        $response = $this->actingAs($user1)->get('/applications');

        $response->assertSuccessful();
        $response->assertDontSeeText('Topic: ' . $app->topic);
        $response->assertDontSeeText('Message: ' . $app->message);
        foreach ($apps as $app) {
            $response->assertSeeText('Topic: ' . $app->topic);
            $response->assertSeeText('Message: ' . $app->message);
        }
    }

    public function test_manager_can_view_all_applications()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $manager = User::factory()->create(['role' => User::ROLE_MANAGER]);
        /* @var $apps Collection */
        $apps = Application::factory()->count(2)->create(
            [
                'user_id' => $user1->id
            ]
        );
        $app = Application::factory()->create(
            [
                'user_id' => $user2->id
            ]
        );

        $response = $this->actingAs($manager)->get('/applications');

        $response->assertSuccessful();
        $response->assertSeeText('Topic: ' . $app->topic);
        $response->assertSeeText('Message: ' . $app->message);
        foreach ($apps as $app) {
            $response->assertSeeText('Topic: ' . $app->topic);
            $response->assertSeeText('Message: ' . $app->message);
        }
    }
}

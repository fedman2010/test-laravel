<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateApplicationTest extends TestCase
{
    use DatabaseMigrations;

    public function test_client_can_create_application()
    {
        Storage::fake();
        $file = UploadedFile::fake()->create('attachment.pdf', 100);
        $client = User::factory()->create();
        $client->refresh();

        $response = $this->actingAs($client)
            ->post(
                '/applications',
                [
                    'topic' => 'Some topic',
                    'message' => 'Hello Manager! I want to buy...',
                    'file' => $file
                ]
            );

        $model = Application::first();

        $this->assertNotNull($model);
        $response->assertRedirect('/applications');
        Storage::disk()->assertExists('attachments/' . $file->hashName());
    }

    public function test_client_cannot_create_second_application_on_the_same_day()
    {
        Storage::fake();
        $file = UploadedFile::fake()->create('attachment.pdf', 100);
        $client = User::factory()->create();
        $client->refresh();
        Application::factory()->create([
            'created_at' => Date::now()->subHours(23)
        ]);

        $response = $this->actingAs($client)
            ->post(
                '/applications',
                [
                    'topic' => 'Some topic',
                    'message' => 'Hello Manager! I want to buy...',
                    'file' => $file
                ]
            );

        $this->assertEquals(1, Application::count());
        $response->assertSessionHasErrors('created_at');
    }

    public function test_client_can_create_second_application_next_day()
    {
        Storage::fake();
        $file = UploadedFile::fake()->create('attachment.pdf', 100);
        $client = User::factory()->create();
        $client->refresh();
        Application::factory()->create([
            'created_at' => Date::now()->subHours(25)
        ]);

        $response = $this->actingAs($client)
            ->post(
                '/applications',
                [
                    'topic' => 'Some topic',
                    'message' => 'Hello Manager! I want to buy...',
                    'file' => $file
                ]
            );

        $this->assertEquals(2, Application::count());
        $response->assertSessionHasNoErrors('created_at');
    }
}

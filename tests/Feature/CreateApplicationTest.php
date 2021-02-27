<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
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
}

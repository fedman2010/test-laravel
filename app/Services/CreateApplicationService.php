<?php


namespace App\Services;


use App\Events\ClientApplicationCreated;
use App\Models\Application;
use Auth;

class CreateApplicationService
{
    public function handle(array $data)
    {
        $path = $data['file']->store('attachments');

        $application = Application::create(
            [
                'topic' => $data['topic'],
                'message' => $data['message'],
                'file' => $path,
                'user_id' => Auth::getUser()->id
            ]
        );

        ClientApplicationCreated::dispatch($application);
    }
}

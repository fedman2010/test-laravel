<?php

namespace App\Listeners;

use App\Events\ClientApplicationCreated;
use App\Mail\ApplicationCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SendEmailToManager
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ClientApplicationCreated  $event
     * @return void
     */
    public function handle(ClientApplicationCreated $event)
    {
        Mail::to(Auth::getUser())->queue(new ApplicationCreated($event->getApplication()));

    }
}

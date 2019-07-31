<?php

namespace App\Listeners;

use App\Events\NewUserRegisteredEvent;
use App\Mail\WelcomeNewUserMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeMailListener implements ShouldQueue
{
    public function handle(NewUserRegisteredEvent $event): void
    {
    	Mail::to($event->user->email)->send(new WelcomeNewUserMail($event->user));
    }
}

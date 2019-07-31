<?php

namespace App\Listeners;

use App\Events\NewOrChangedEmailEvent;
use App\Mail\VerificationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendVerificationEmailListener implements ShouldQueue
{
    public function handle(NewOrChangedEmailEvent $event): void
    {
		Mail::to($event->object->email)->send(new VerificationMail($event->object));
    }
}

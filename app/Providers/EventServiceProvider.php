<?php

namespace App\Providers;

use App\Events\NewSingleImageUploadedEvent;
use App\Events\NewOrChangedEmailEvent;
use App\Events\NewUserRegisteredEvent;
use App\Listeners\HandleSingleImageListener;
use App\Listeners\SendVerificationEmailListener;
use App\Listeners\SendWelcomeMailListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
		NewSingleImageUploadedEvent::class => [
			HandleSingleImageListener::class,
		],
        NewUserRegisteredEvent::class => [
            SendWelcomeMailListener::class,
        ],
		NewOrChangedEmailEvent::class => [
			SendVerificationEmailListener::class
		],
    ];

    public function boot(): void
    {
        parent::boot();

        //
    }
}

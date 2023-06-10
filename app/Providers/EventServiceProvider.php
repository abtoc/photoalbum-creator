<?php

namespace App\Providers;

use App\Events\AlbumDeleted;
use App\Events\PhotoDeleted;
use App\Events\Subscribed;
use App\Events\Unsubscribed;
use App\Listeners\AlbumDeletedNotification;
use App\Listeners\LoginFailedNotification;
use App\Listeners\LoginNotification;
use App\Listeners\PhotoDeletedNotification;
use App\Listeners\UserOptionsNotification;
use App\Listeners\UserRegisterdNotification;
use App\Listeners\UserSubcribedNotification;
use App\Listeners\UserUnsubcribedNotification;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            UserOptionsNotification::class,
            UserRegisterdNotification::class,
        ],
        Login::class => [
            LoginNotification::class,
        ],
        Failed::class => [
            LoginFailedNotification::class,
        ],
        AlbumDeleted::class => [
            AlbumDeletedNotification::class,
        ],
        PhotoDeleted::class => [
            PhotoDeletedNotification::class,
        ],
        Subscribed::class => [
            UserSubcribedNotification::class,
        ],
        Unsubscribed::class => [
            UserUnsubcribedNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}

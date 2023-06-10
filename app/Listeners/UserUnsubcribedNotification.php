<?php

namespace App\Listeners;

use App\Models\Activity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UserUnsubcribedNotification
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;
        Log::info(sprintf("User %s is unsubcribed.", $user->email));
        Activity::create([
            'user_id' => 0,
            'details' => sprintf(__("User %s is unsubcribed."), $user->email),
        ]);
        Activity::create([
            'user_id' => $user->id,
            'details' => __("Unsubcribed."),
        ]);
    }
}

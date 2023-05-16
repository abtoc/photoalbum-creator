<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class AlbumDeletedNotification
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
        if($event->album->isForceDeleting()){
            $path = sprintf('%s/albums/%08d', $event->album->user->email, $event->album->id);
            Storage::disk('s3')->deleteDirectory($path);
        }
    }
}

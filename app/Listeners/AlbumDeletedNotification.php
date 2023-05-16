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
            $path = $event->album->getDirectory();
            Storage::disk('s3')->deleteDirectory($path);
            $path = $event->album->getEpubPath();
            Storage::disk('s3')->delete($path);
        }
    }
}

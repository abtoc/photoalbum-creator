<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class PhotoDeletedNotification
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
        if($event->photo->isForceDeleting()){
            $path = $event->photo->getPath();
            Storage::disk('s3')->delete($path);
            $path = $event->photo->getPath('_m');
            Storage::disk('s3')->delete($path);
            $path = $event->photo->getPath('_s');
            Storage::disk('s3')->delete($path);
        }
    }
}

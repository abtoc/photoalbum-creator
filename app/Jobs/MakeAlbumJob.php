<?php

namespace App\Jobs;

use App\Enums\Album\Status;
use App\Models\Album;
use App\Traits\MakeAlbum;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

class MakeAlbumJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, MakeAlbum;

    private $album;

    /**
     * Create a new job instance.
     *
     * @param Album $album
     * @return void
     */
    public function __construct(Album $album)
    {
        $this->album = $album;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $this->make($this->album);
        } catch(Throwable $e){
            DB::transaction(function(){
                $this->album->status = Status::ERROR;
                $this->album->save();
            });
            throw $e;
        }
        DB::transaction(function(){
            $this->album->status = Status::PUBLISHED;
            $this->album->save();
        });
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Album;
use App\Traits\MakeAlbum;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MakeAlbumCommand extends Command
{
    use MakeAlbum;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'album:publish {album_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new album';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $album_id = $this->argument('album_id');
        $album = Album::find($album_id);
        if(is_null($album)){
            echo "Not found album id=".$album_id."\n";
            return 1;
        }

        $this->make($album);

        return Command::SUCCESS;
    }
}

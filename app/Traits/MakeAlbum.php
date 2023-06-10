<?php

namespace App\Traits;

use App\Models\Activity;
use App\Models\Album;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait MakeAlbum
{
    /**
     * Collect Photo
     * 
     * @param Album $album
     * @param String $current
     * @return void
     */
    private function collectPhoto(Album $album, String $current): void
    {
        Log::info('Collecting photos start.', ['album_id' => $album->id]);
        $path = $current.'/images/cover.jpg';
        Log::info('Collecting photo start.', ['album_id' => $album->id, 'path' => $path]);
        Storage::disk('local')->writeStream(
            $path,
            Storage::disk('s3')->readStream($album->getCoverPath())
        );
        Log::info('Collected photo terminate.', ['album_id' => $album->id, 'path' => $path]);

        $query = $album->pages()
                    ->orderBy('page', 'asc');
        foreach($query->cursor() as $page){
            $path = sprintf("%s/images/%05d.jpg", $current, $page->page);
            Log::info('Collecting photo start.', ['album_id' => $album->id, 'path' => $path]);
            Storage::disk('local')->writeStream(
                $path,
                Storage::disk('s3')->readStream($page->photo->getPath())
            );
            Log::info('Collected photo terminate.', ['album_id' => $album->id, 'path' => $path]);
        }
        Log::info('Collected photo terminate.', ['album_id' => $album->id]);
    }

    /**
     * 
     */
    private function makeXML(string $path, $content)
    {
        Log::info('Add epub file.', ['path' => $path]);
        Storage::disk('local')->put($path, $content);
    }

    /**
     * Making XML
     */
    private function makeXMLs(Album $album, String $current): void
    {
        Log::info('Adding epub files.', ['album_id' => $album->id]);
        $this->makeXML($current.'/mimetype', 'application/epub+zip');
        $this->makeXML($current.'/META-INF/container.xml', view('epub.container'));

        $this->makeXML($current.'/content.opf', view('epub.content', ['album' => $album]));
        $this->makeXML($current.'/toc.ncx', view('epub.toc', ['album' => $album]));
        $this->makeXML($current.'/text/cover.xhtml', view('epub.cover', ['album' => $album]));
        foreach($album->pages()->orderBy('page', 'asc')->cursor() as $page){
            $this->makeXML($current.'/text/part'.sprintf('%05d', $page->page).'.xhtml', view('epub.section', ['page' => $page]));
        }
        Log::info('Added epub files.', ['album_id' => $album->id]);
    }

    public function make(Album $album)
    {
        Log::info('Maiking album start.', ['album_id' => $album->id, 'email' => $album->user->email]);

        $current = sprintf('albums/%08d', $album->id);
        if(Storage::disk('local')->exists($current)){
            Storage::disk('local')->deleteDirectory($current);
            Log::info('Delete epub working directory.', ['album_id' => $album->id, 'path' => $current]);
        }
        Storage::disk('local')->makeDirectory($current);
        if(Storage::disk('local')->exists($current.'.epub')){
            Storage::disk('local')->delete($current.'.epub');
            Log::info('Delete epub working file.', ['album_id' => $album->id,  'path' => $current.'.epub']);
        }

        $this->collectPhoto($album, $current);
        $this->makeXMLs($album, $current);

        $path = Storage::disk('local')->path($current);
        chdir($path);
        $command = '/usr/bin/zip -0 -X '.$path.'.epub mimetype 2>&1'; 
        Log::info('Making epub file.', ['album_id' =>  $album->id, 'path' => $path.'.epub' ,'command' => $command]);
        exec($command, $output, $result);
        Log::info('Maked epub file.', ['album_id' => $album->id, 'path' => $path.'.epub', 'command' =>$command, 'result' => $result, 'output' => implode(PHP_EOL, $output)]);
        $command = '/usr/bin/zip -r '.$path.'.epub * -x mimetype 2>&1'; 
        Log::info('Making epub file.', ['album_id' => $album->id, 'path' => $path.'.epub', 'command' => $command]);
        exec($command, $output, $result);
        Log::info('Maked epub file.', ['album_id' => $album->id, 'path' => $path.'.epub', 'command' => $command, 'result' => $result, 'output' => implode(PHP_EOL, $output)]);

        Log::info('Uploading epub file.', ['album_id' => $album->id, 'path' => $current.'.epub']);
        Storage::disk('s3')->writeStream(
            $album->getEpubPath(),
            Storage::disk('local')->readStream($current.'.epub'),
        );
        Log::info('Uploaded epub file.', ['album_id' => $album->id, ',path' => $current.'.epub']);

        Storage::disk('local')->deleteDirectory($current);
        Log::info('Delete epub working directory.', ['album_id' => $album->id, 'path' => $current]);
        Storage::disk('local')->delete($current.'.epub');
        Log::info('Delete epub working file.', ['album_id' => $album->id, 'path' => $current.'.epub']);

        Activity::create([
            'user_id' => $album->user->id,
            'details' => sprintf(__('Created %s.'), $album->title),
        ]);
  
        Log::info('Maked album terminate.', ['album_id' => $album->id, 'email' => $album->user->email]);
        return 0;
    }
};
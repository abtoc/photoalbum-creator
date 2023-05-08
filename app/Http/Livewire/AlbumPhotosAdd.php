<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class AlbumPhotosAdd extends Component
{
    public $album;
    
    public function add($id)
    {
        DB::transaction(function() use($id){
            $this->album->album_photos()->create([
                'album_id' => $this->album->id,
                'photo_id' => $id,
            ]);
            $this->emit('refreshComponent');
        });
    }

    public function render()
    {
        $query = Auth::user()->photos()
            ->select('photos.*')
            ->leftJoin('album_photos', function($join){
                $join->on('photos.id', '=', 'album_photos.photo_id')
                    -> where('album_photos.album_id', '=', $this->album->id);
            })
            ->whereNull('album_photos.page')
            ->orderBy('photos.updated_at', 'desc');
        return view('livewire.album-photos-add', ['photos' => $query->get()]);
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\AlbumPhoto;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AlbumPhotosIndex extends Component
{
    public $album;
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function destroy($id)
    {
        DB::transaction(function() use($id){
            $album_photo = AlbumPhoto::select()
                ->where('album_id', $this->album->id)
                ->where('photo_id', $id)
                ->first();
            $album_photo->delete();
        });
    }

    public function render()
    {
        $this->dispatchBrowserEvent('reloadViewer');
        $query = $this->album->album_photos()
                ->select('photos.*', 'album_photos.page')
                ->join('photos', 'album_photos.photo_id', '=', 'photos.id')
                ->orderBy('album_photos.page', 'asc');
        return view('livewire.album-photos-index', ['photos' => $query->get()]);
    }
}

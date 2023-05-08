<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PageIndex extends Component
{
    public $album;
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function destroy($id)
    {
        DB::transaction(function() use($id){
            $album_photo = Page::select()
                ->where('album_id', $this->album->id)
                ->where('photo_id', $id)
                ->first();
            $album_photo->delete();
        });
    }

    public function render()
    {
        $this->dispatchBrowserEvent('reloadViewer');
        $query = $this->album->pages()
                ->select('photos.*', 'pages.page')
                ->join('photos', 'pages.photo_id', '=', 'photos.id')
                ->orderBy('pages.page', 'asc');
        return view('livewire.page-index', ['photos' => $query->get()]);
    }
}

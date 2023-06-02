<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PageIndex extends Component
{
    public $album;
    protected $listeners = [
        'refreshComponent' => '$refresh',
        'drop',
    ];

    public function drop($from_id, $to_id)
    {
        $from = Page::query()
                ->where('album_id', $this->album->id)
                ->where('photo_id', $from_id)
                ->first();
        $to   = Page::query()
                ->where('album_id', $this->album->id)
                ->where('photo_id', $to_id)
                ->first();
        DB::transaction(function() use($from, $to){
            $from->page = $to->page;
            $from->save();
        });
    }

    public function destroy($id)
    {
        DB::transaction(function() use($id){
            $album_photo = Page::query()
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

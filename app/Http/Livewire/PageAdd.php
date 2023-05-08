<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class PageAdd extends Component
{
    public $album;
    
    public function add($id)
    {
        DB::transaction(function() use($id){
            $this->album->pages()->create([
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
            ->leftJoin('pages', function($join){
                $join->on('photos.id', '=', 'pages.photo_id')
                    -> where('pages.album_id', '=', $this->album->id);
            })
            ->whereNull('pages.page')
            ->orderBy('photos.updated_at', 'desc');
        return view('livewire.page-add', ['photos' => $query->get()]);
    }
}

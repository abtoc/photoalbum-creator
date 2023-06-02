<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class PageAdd extends Component
{
    public $album;
    public $favorite = false;
    public $published = true;
    public $not_albumed = true;
    public $uploaded_at = "";
    public $category;

    
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
            ->when($this->favorite, function($q){
                return $q->where('photos.favorite', true);
            })
            ->when($this->not_albumed, function($q){
                return $q->where('photos.album_count', 0);
            })
            ->when($this->uploaded_at, function($q){
                return $q->where('photos.uploaded_at', $this->uploaded_at);
            })
            ->when($this->category, function($q){
                return $q->whereIn('photos.id', function($query){
                    $query->select('photo_id')->from('category_photo')
                        ->where('category_id', $this->category);
                });
            })
            ->orderBy('photos.updated_at', 'desc');
        $photos = $query->get();
        $count = $query->count();

        $favorites = $query->where('favorite', true)->count();

        $uploaded = Auth::user()->photos()->select('uploaded_at')
            ->groupBy('uploaded_at')
            ->orderBy('uploaded_at', 'desc')->get();

        $categories = Auth::user()->categories()->get();

        return view('livewire.page-add', [
            'photos' => $photos,
            'uploaded' => $uploaded,
            'count' => $count,
            'favorites' => $favorites,
            'categories' => $categories,
        ]);
    }
}

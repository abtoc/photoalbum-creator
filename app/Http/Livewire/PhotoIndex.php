<?php

namespace App\Http\Livewire;

use App\Models\Photo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PhotoIndex extends Component
{
    public $favorite = false;
    public $published = false;
    public $not_albumed = false;
    public $uploaded_at = "";

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function like($id)
    {
        $photo = AUth::user()->photos()->where('id', $id)->first();
        if($photo != null){
            DB::transaction(function() use($photo){
                $photo->favorite = ! $photo->favorite;
                $photo->save();
            });
        }
    }

    public function destroy($id)
    {
        $photo = AUth::user()->photos()->where('id', $id)->first();
        if($photo != null){
            DB::transaction(function() use($photo){
                $photo->delete();
            });
        }
    }

    public function render()
    {
        $this->dispatchBrowserEvent('reloadViewer');

        $query = Auth::user()->photos()->select()
            ->when($this->favorite, function($q){
                return $q->where('favorite', true);
            })
            ->when($this->not_albumed, function($q){
                return $q->where('album_count', 0);
            })
            ->when($this->uploaded_at, function($q){
                return $q->where('uploaded_at', $this->uploaded_at);
            })
            ->orderBy('created_at', 'desc');
        $photos = $query->get();
        $count = $query->count();
        $favorites = $query->where('favorite', true)->count();

        $uploaded = Auth::user()->photos()->select('uploaded_at')
            ->groupBy('uploaded_at')
            ->orderBy('uploaded_at', 'desc')->get();

        return view('livewire.photo-index', [
            'photos' => $photos,
            'uploaded' => $uploaded,
            'count' => $count,
            'favorites' => $favorites,
        ]);
    }
}

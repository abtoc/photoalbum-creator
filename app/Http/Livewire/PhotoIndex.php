<?php

namespace App\Http\Livewire;

use App\Models\Photo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PhotoIndex extends Component
{
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
        return view('livewire.photo-index', [
            'photos' => Auth::user()->photos()->orderBy('created_at', 'desc')->get(),
        ]);
    }
}

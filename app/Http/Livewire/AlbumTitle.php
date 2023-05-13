<?php

namespace App\Http\Livewire;

use App\Models\Album;
use Livewire\Component;

class AlbumTitle extends Component
{
    public $album;

    public function render()
    {
        return view('livewire.album-title', ['album' => $this->album]);
    }
}

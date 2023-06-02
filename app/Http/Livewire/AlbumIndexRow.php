<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AlbumIndexRow extends Component
{
    public $album;

    public function render()
    {
        return view('livewire.album-index-row', ['album' => $this->album]);
    }
}

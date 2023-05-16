<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AlbumStatus extends Component
{
    public $album;

    public function render()
    {
        return view('livewire.album-status', ['album' => $this->album]);
    }
}

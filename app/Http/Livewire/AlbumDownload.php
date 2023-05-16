<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AlbumDownload extends Component
{
    public $album;
    
    public function render()
    {
        return view('livewire.album-download', ['album' => $this->album]);
    }
}

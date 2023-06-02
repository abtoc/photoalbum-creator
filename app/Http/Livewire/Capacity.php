<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Capacity extends Component
{
    public function render()
    {
        $total = Auth::user()->getCapacity();
        $used = Auth::user()->getUsedCapacity();
        $progress = (int)($used / $total * 100);
        if($progress > 100){
            $progress = 100;
        }
        return view('livewire.capacity',[
            'total' => $total,
            'used' => $used,
            'progress' => $progress,
        ]);
    }
}

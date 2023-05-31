<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserName extends Component
{
    public $name;
    public $guard = null;

    protected $listeners = [
        'modalOpen' => 'open',
    ];

    protected $rules = [
        'name' => ['requred']
    ];

    protected function validationAttributes()
    {
        return [
            'name' => __('name'),
        ];
    }

    public function open()
    {
        $user = $this->guard ? Auth::guard($this->guard)->user() : Auth::user();
        $this->name = $user->name;
    }

    public function submit()
    {
        $user = $this->guard ? Auth::guard($this->guard)->user() : Auth::user();
        $user->name = $this->name;
        $user->save();

        $this->close();
    }

    public function close()
    {
        $this->emit('modalClosed');
    }

    public function render()
    {
        return view('livewire.user-name');
    }
}

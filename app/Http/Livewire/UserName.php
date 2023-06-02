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
        'name' => ['required', 'string', 'max:255'],
    ];

    protected function validationAttributes()
    {
        return [
            'name' => __('Name'),
        ];
    }

    public function open()
    {
        $user = $this->guard ? Auth::guard($this->guard)->user() : Auth::user();
        $this->name = $user->name;
    }

    public function submit()
    {
        $this->validate();
        
        $user = $this->guard ? Auth::guard($this->guard)->user() : Auth::user();
        $user->name = $this->name;
        $user->save();

        $this->close();
    }

    public function close()
    {
        $user = $this->guard ? Auth::guard($this->guard)->user() : Auth::user();
        $this->name = $user->name; 
        $this->resetErrorBag();
        $this->emit('modalClosed');
    }

    public function render()
    {
        return view('livewire.user-name');
    }
}

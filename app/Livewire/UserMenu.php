<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserMenu extends Component
{

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    public function render()
    {
        return view('livewire.user-menu');
    }
}

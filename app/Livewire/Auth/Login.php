<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $username;
    public $password;

    protected $rules = [
        'username' => 'required',
        'password' => 'required',
    ];

    public function login()
    {
        $credentials = $this->validate();

//        User::create([
//            'employee_id' => 1,
//            'username' => 'marlonhg',
//            'email' => $this->username,
//            'password' => bcrypt($this->p/assword),
//        ]);

        if (Auth::attempt($credentials)) {
            session()->regenerate();
            return redirect()->intended('/administration/dashboard');
        }

        session()->flash('error', 'Invalid credentials, please try again');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}

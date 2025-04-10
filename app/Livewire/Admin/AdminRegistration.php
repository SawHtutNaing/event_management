<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminRegistration extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|confirmed|min:8',
    ];

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $adminRole = Role::where('name', 'admin')->first();
        $user->roles()->attach($adminRole);

        session()->flash('message', 'Admin registered successfully!');

        return redirect()->route('admin.events.index');
    }

    public function render()
    {
        return view('livewire.admin.admin-registration');
    }
}
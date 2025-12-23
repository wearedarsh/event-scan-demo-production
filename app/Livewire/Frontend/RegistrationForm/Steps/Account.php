<?php

namespace App\Livewire\Frontend\RegistrationForm\Steps;

use Livewire\Component;
use App\Models\User;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Account extends Component
{
    public Registration $registration;

    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public string $mode = 'login';

    protected function rules()
    {
        if($this->mode === 'login'){
            return [
                'email' => ['required', 'email'],
                'password' => ['required']
            ];
        }else{
            return [
                'email' => ['required', 'email'],
                'password' => ['required', 'min:8', 'confirmed'],
            ];
        }
    }


    public function logout()
    {
        Auth::logout();

        session()->regenerateToken();

        $this->reset(['email', 'password', 'password_confirmation']);

        $this->mode = 'login';
    }

    public function submit()
    {
        $this->validate();

        if ($this->mode === 'login') {
            $this->login();
        } else {
            $this->register();
        }
    }

    public function attachUser($user){
        $this->registration->update([
            'user_id' => $user->id
        ]);
    }

    public function login()
    {
        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $this->addError('email', 'Invalid credentials');
            return;
        }

        $this->attachUser(Auth::user());
    }

    public function register()
    {
        $existing = User::where('email', $this->email)->first();

        if ($existing) {
            $this->addError('email', 'Account already exists. Please sign in.');
            return;
        }

        $user = User::create([
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'active' => false,
        ]);

        Auth::login($user);

        $this->attachUser($user);
    }


}

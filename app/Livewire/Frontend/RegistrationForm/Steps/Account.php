<?php

namespace App\Livewire\Frontend\RegistrationForm\Steps;

use Livewire\Component;
use App\Models\User;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Account extends Component
{
    protected $listeners = [
        'validate-step' => 'validateStep'
    ];

    public Registration $registration;

    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public string $mode = 'register';

    public $step_help_info;
    public $total_steps;
    public $current_step;
    public bool $is_penultimate_step = false;

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

    public function updateUserModel()
    {
        if(Auth::check()){
            Auth::user()->update([
                'title' => $this->registration->title,
                'first_name' => ucfirst(strtolower($this->registration->first_name)),
                'last_name' => ucfirst(strtolower($this->registration->last_name)),
            ]);
        }
    }

    public function validateStep($direction){
        $this->dispatch('scroll-to-top');
        
        if(!Auth::user() && $direction === 'forward'){
            $this->validate();
            if($this->mode === 'register'){
                $this->register();
            }else{
                $this->login();
            }
        }

        $this->updateUserModel();

        if(!$this->getErrorBag()->any()){
            $this->dispatch('update-step', $direction);
        }
    }


    public function logout()
    {
        Auth::logout();

        session()->regenerateToken();

        $this->reset(['email', 'password', 'password_confirmation']);

        $this->mode = 'login';

        $this->addError('error', 'You are now logged out, please sign in or create an account');

    }

    public function attachUser($user){
        $this->registration->update([
            'user_id' => $user->id,
            'email' => $user->email
        ]);
    }

    public function removeUser(){
        $this->registration->update([
            'user_id' => null
        ]);
    }



    public function login()
    {
        $this->dispatch('scroll-to-top');

         $this->resetErrorBag();
        if(!$this->email){
            $this->addError('error', 'Please enter a valid email address');
            return;
        }

        if(!$this->password){
            $this->addError('error', 'Please enter a password');
            return;
        }

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $this->addError('error', 'Invalid credentials');
            return;
        }

        $this->attachUser(Auth::user());

    }

    public function register()
    {

        $this->resetErrorBag();

        $existing = User::where('email', $this->email)->where('active', true)->first();

        if ($existing) {
            $this->addError('email', 'Account already exists. Please sign in.');
            return;
        }

        $user = User::create([
            'first_name' => $this->registration->first_name,
            'last_name' => $this->registration->last_name,
            'title' => $this->registration->title,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'active' => false,
        ]);

        Auth::login($user);

        $this->attachUser($user);
    }


}

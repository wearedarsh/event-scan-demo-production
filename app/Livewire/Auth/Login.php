<?php

namespace App\Livewire\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

#[Layout('livewire.auth.layouts.app')]
class Login extends Component
{
    public string $page_title = 'Login';

    
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;


    /**
     * Handle an incoming authentication request.
     */
    public function login()
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
            'active' => 1,
        ], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $user = Auth::user();

        if (! $user || ! $user->active || $user->trashed()) {
            Auth::logout();

            throw ValidationException::withMessages([
                'email' => 'Your account is inactive or has been disabled.',
            ]);
        }

        $role_key = $user->role->key_name ?? '';
        Log::info($role_key);

        if ($role_key === 'app_user') {
            activity('auth')
                ->causedBy($user)
                ->log('App user Logged in');
            return redirect()->intended('/admin/app/index');
        }

        if ($user->is_admin) {
            activity('auth')
                ->causedBy($user)
                ->log('Logged in to admin panel');
            return redirect()->intended('/admin/dashboard');
        }

        activity('auth')
            ->causedBy($user)
            ->log('Logged in to customer panel');
        return redirect()->intended('/customer/dashboard');
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}

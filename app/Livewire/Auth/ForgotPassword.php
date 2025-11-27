<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('livewire.auth.layouts.app')]
class ForgotPassword extends Component
{
	public string $email = '';

	public function sendPasswordResetLink(): void
	{
		$this->validate([
			'email' => ['required', 'string', 'email'],
		]);

		$user = \App\Models\User::where('email', $this->email)->where('active', 1)->first();

        if ($user) {
            Password::broker()->sendResetLink(['email' => $user->email]);
        }

		session()->flash('status', __('A reset link will be sent if the account exists.'));
	}
}

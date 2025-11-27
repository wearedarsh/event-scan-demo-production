<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;

#[Layout('livewire.auth.layouts.app')]
class ResetPassword extends Component
{
	#[Locked]
	public string $token = '';

	public string $email = '';
	public string $password = '';
	public string $password_confirmation = '';

	public function mount(string $token): void
	{
		$this->token = $token;
		$this->email = request()->string('email');
	}

	public function resetPassword(): void
	{
		$this->validate([
			'token' => ['required'],
			'email' => ['required', 'string', 'email'],
			'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
		]);

		$user = User::where('email', $this->email)->where('active', 1)->first();

		if (! $user) {
			$this->addError('email', __('We couldn’t find an active account with that email.'));
			return;
		}

		// Lookup valid token match
		$record = DB::table('password_reset_tokens')
			->where('email', $user->email)
			->first();

		if (! $record || ! Hash::check($this->token, $record->token)) {
			$this->addError('email', __('This password reset link is invalid or expired.'));
			return;
		}

		$user->forceFill([
			'password' => Hash::make($this->password),
			'remember_token' => Str::random(60),
		])->save();

		event(new PasswordReset($user));

		// Delete token after use
		DB::table('password_reset_tokens')->where('email', $user->email)->delete();

		Session::flash('status', __('Your password has been reset!'));

		$this->redirectRoute('login', navigate: true);
	}
}

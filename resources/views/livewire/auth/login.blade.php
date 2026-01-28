<div class="w-full flex flex-col items-center">

	<img src="{{ client_setting('branding.frontend.auth.logo.path') }}" alt="{{client_setting('general.customer_friendly_name')}} Logo" class="{{ client_setting('branding.frontend.auth.logo.custom_classes') }}">

	<div class="w-full max-w-md bg-[var(--color-surface)] rounded-2xl p-8 text-center shadow-lg border border-[var(--color-border)]">

		<h1 class="text-2xl font-semibold mb-2 text-[var(--color-text)]">Welcome back</h1>
		<p class="text-[var(--color-text-light)] mb-8">Please log in to continue</p>

		@if($errors->any())
		<div class="mb-4 p-3 rounded-lg bg-[var(--color-accent-light)] text-[var(--color-text)] text-sm text-left">
			{{ $errors->first() }}
		</div>
		@endif

		@if (session('status'))
		<div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm text-left">
			{{ session('status') }}
		</div>
		@endif

		<form wire:submit="login" class="flex flex-col gap-5 text-left">

			<div>
				<label for="email" class="block mb-1 text-sm font-bold text-[var(--color-text)]">
					Email address
				</label>
				<input
					wire:model="email"
					id="email"
					type="email"
					required
					autofocus
					autocomplete="email"
					placeholder="you@example.com"
					class="w-full border border-[var(--color-border)] rounded-lg p-3 focus:ring-2 focus:ring-[var(--color-accent)] outline-none bg-[var(--color-bg)]" />
			</div>

			<div>
				<label for="password" class="block mb-1 text-sm font-bold text-[var(--color-text)]">
					Password
				</label>
				<input
					wire:model="password"
					id="password"
					type="password"
					required
					autocomplete="current-password"
					placeholder="••••••••"
					class="w-full border border-[var(--color-border)] rounded-lg p-3 focus:ring-2 focus:ring-[var(--color-accent)] outline-none bg-[var(--color-bg)]" />
			</div>

			<button
				type="submit"
				class="w-full py-3 rounded-lg font-semibold bg-[var(--color-primary)] text-white transition hover:opacity-90 shadow-md">
				Log in
			</button>

			<!-- Forgot password -->
			<div class="text-center mt-3">
				<a href="{{ route('forgotten-password') }}" class="text-[var(--color-accent)] font-medium hover:underline">
					Forgot your password?
				</a>
			</div>
		</form>
	</div>

	<footer class="mt-8 text-xs text-[var(--color-accent)] text-center">
		&copy; {{ date('Y') }} {{client_setting('general.customer_friendly_name')}}. All rights reserved.
	</footer>
</div>
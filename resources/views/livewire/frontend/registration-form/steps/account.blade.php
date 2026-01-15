<div class="space-y-6">
    @if($errors->any())
        <x-registration.alert type="warning" :message="$errors->first()" />
    @endif
    @auth
        <x-registration.form-step>
            @if($step_help_info)
                <x-registration.form-info>
                    {{ $step_help_info }}
                </x-registration.form-info>
            @endif
            <div class="flex items-center justify-between gap-4">
                <div class="flex-1">
                    <x-registration.form-info>
                        You are signed in as <strong>{{ auth()->user()->email }}</strong>.
                    </x-registration.form-info>
                </div>

                <div class="w-32 text-right">
                    <x-registration.button variant="secondary" wire:click="logout">
                        Logout
                    </x-registration.button>
                </div>
            </div>
        </x-registration.form-step>
    @endauth

    @guest
        <div class="flex gap-4 text-sm px-6">
            <x-registration.account-link
                wire:click="$set('mode', 'register')"
                :active="$mode === 'register'">
                Create account
            </x-registration.account-link>
            
            <x-registration.account-link
                wire:click="$set('mode', 'login')"
                :active="$mode === 'login'">
                Sign in
            </x-registration.account-link>
        </div>

        <x-registration.form-step>
            <span class="font-semibold text-[var(--color-secondary)]">
                {{ $mode === 'register' ? 'Create account' : 'Sign in' }}
            </span>
            <br><br>

            <x-registration.form-info>
                @if($mode === 'register')
                    An account is required to access your registration before,
                    during, and after the event.
                    <br><br>
                    Already have an account?
                    <x-registration.account-link
                        wire:click="$set('mode', 'login')"
                        variant="primary">
                        Sign in
                    </x-registration.account-link>
                @else
                    Sign in to continue your registration.
                    <br><br>
                    Don’t have an account?
                    <x-registration.account-link
                        wire:click="$set('mode', 'register')"
                        variant="primary">
                        Create one
                    </x-registration.account-link>
                @endif
            </x-registration.form-info>

            <div>
                <x-registration.input-label for="email">Email address</x-registration.input-label>
                <x-registration.input-text
                    id="email"
                    type="email"
                    wire:model.defer="email" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-registration.input-label for="password">Password</x-registration.input-label>
                    <x-registration.input-text
                        id="password"
                        type="password"
                        wire:model.defer="password" />
                    @if($mode === 'register')
                        <x-registration.input-help>
                            Your password must be at least 8 characters long.
                        </x-registration.input-help>
                    @endif
                </div>

                @if($mode === 'register')
                    <div>
                        <x-registration.input-label for="password_confirmation">
                            Password confirmation
                        </x-registration.input-label>
                        <x-registration.input-text
                            id="password_confirmation"
                            type="password"
                            wire:model.defer="password_confirmation" />
                    </div>
                @endif
            </div>

            @if($mode !== 'register')
                <div class="text-left">
                    <div class="w-32">
                        <x-registration.button wire:click="login">
                            Login
                        </x-registration.button>
                    </div>
                </div>
            @endif
        </x-registration.form-step>
    @endguest

    <div class="flex gap-4 pt-6">
        <div class="flex-1">
            <x-registration.navigate-button wire:click="$dispatch('validate-step', ['backward'])">
                Previous
            </x-registration.navigate-button>
        </div>

        <div class="flex-1">
            <x-registration.navigate-button wire:click="$dispatch('validate-step', ['forward'])">
                @if($this->registration->type === 'approval' && $this->isPenultimateStep) 
                    client_setting('booking.navigation.approval.final_step_button_label') 
                @else 
                    Next 
                @endif
            </x-registration.navigate-button>
        </div>
    </div>
    <div class="flex w-full flex-row gap-4 pt-6 justify-center">
        <x-registration.navigate-cancel-link wire:click="$dispatch('clear-session')">
            Cancel
        </x-registration.navigate-cancel-link>
    </div>

</div>

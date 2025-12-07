<div class="space-y-6">
@php
    $role = auth()->user()?->role?->key_name;
    $agent = new \Jenssegers\Agent\Agent();
@endphp

@if ($role !== 'app_user')
    <x-admin.breadcrumb :items="[
        ['label' => 'Home', 'href' => route('admin.dashboard')],
        ['label' => 'Check-in App'],
    ]" />
@endif

<x-admin.page-header
    title="Setting up your app"
    subtitle="Install, initialise and start using {{ config('check-in-app.friendly_name') }}."
/>

@if (session()->has('success'))
    <x-admin.alert type="success" :message="session('success')" />
@endif

{{-- MOBILE FLOW --}}
@if($agent->isMobile())

    <div class="px-6 space-y-6">

        <!-- Install -->
        <x-admin.card class="p-6 space-y-4">
            <x-admin.section-title title="Step 1 — Install the app" />

            <p class="text-sm text-[var(--color-text-light)]">
                Choose your device to install the {{ config('check-in-app.friendly_name') }} app.
            </p>

            <div class="flex items-center gap-4">
                <x-admin.button variant="outline" :href="$apple_url">
                    <x-slot:icon><x-heroicon-o-device-phone-mobile class="h-4 w-4" /></x-slot:icon>
                    Apple
                </x-admin.button>

                <x-admin.button variant="outline" :href="$android_url">
                    <x-slot:icon><x-heroicon-o-device-phone-mobile class="h-4 w-4" /></x-slot:icon>
                    Android
                </x-admin.button>
            </div>
        </x-admin.card>

        <!-- Initialise -->
        <x-admin.card class="p-6 space-y-4">
            <x-admin.section-title title="Step 2 — Initialise the app" />

            <p class="text-sm text-[var(--color-text-light)]">
                Tap below to initialise your app securely.
            </p>

            <a href="{{ $initialise_url }}" class="btn-secondary">
                Initialise app
            </a>
        </x-admin.card>

        <!-- Login -->
        <x-admin.card class="p-6 space-y-4">
            <x-admin.section-title title="Step 3 — Log in" />
            <p class="text-sm text-[var(--color-text-light)]">
                Log in using your management panel credentials.
            </p>
        </x-admin.card>

    </div>

@else

    {{-- DESKTOP FLOW --}}
    <div class="px-6 space-y-6">

        <!-- Choose device -->
        <x-admin.card class="p-6 space-y-4">
            <x-admin.section-title title="Step 1 — Choose your device" />

            <p class="text-sm text-[var(--color-text-light)]">
                Select your phone type and follow the steps below.
            </p>

            <div class="flex items-center gap-4">
                <x-admin.button variant="outline" wire:click="selectPhone('apple')">
                    <x-slot:icon><x-heroicon-o-device-phone-mobile class="w-4 h-4" /></x-slot:icon>
                    iPhone
                </x-admin.button>

                <x-admin.button variant="outline" wire:click="selectPhone('android')">
                    <x-slot:icon><x-heroicon-o-device-phone-mobile class="w-4 h-4" /></x-slot:icon>
                    Android
                </x-admin.button>
            </div>
        </x-admin.card>

        <!-- iPhone path -->
        @if($phone_type === 'apple')
            <x-admin.card class="p-6 space-y-6">

                <!-- Install -->
                <div>
                    <x-admin.section-title title="Step 2 — Install on iPhone" />

                    <p class="text-sm text-[var(--color-text-light)]">
                        Scan this QR code with your iPhone camera.
                    </p>

                    <img src="data:image/svg+xml;base64,{{ base64_encode(
                        QrCode::format('svg')->size(160)->generate($apple_url)
                    ) }}" class="mt-3 w-40 h-40" />
                </div>

                <!-- Initialise -->
                <div>
                    <x-admin.section-title title="Step 3 — Initialise the app" />

                    <p class="text-sm text-[var(--color-text-light)]">
                        Scan this code once to initialise.
                    </p>

                    <img src="data:image/svg+xml;base64,{{ base64_encode(
                        QrCode::format('svg')->size(160)->generate($initialise_url)
                    ) }}" class="mt-3 w-40 h-40" />
                </div>

                <!-- Login -->
                <div>
                    <x-admin.section-title title="Step 4 — Log in" />
                    <p class="text-sm text-[var(--color-text-light)]">
                        Log in using your credentials.
                    </p>
                </div>

            </x-admin.card>
        @endif

        <!-- Android path -->
        @if($phone_type === 'android')
            <x-admin.card class="p-6 space-y-6">

                <!-- Install -->
                <div>
                    <x-admin.section-title title="Step 2 — Install on Android" />

                    <p class="text-sm text-[var(--color-text-light)]">
                        Scan this QR code with your Android camera.
                    </p>

                    <img src="data:image/svg+xml;base64,{{ base64_encode(
                        QrCode::format('svg')->size(160)->generate($android_url)
                    ) }}" class="mt-3 w-40 h-40" />
                </div>

                <!-- Initialise -->
                <div>
                    <x-admin.section-title title="Step 3 — Initialise the app" />

                    <p class="text-sm text-[var(--color-text-light)]">
                        Scan this code once to initialise.
                    </p>

                    <img src="data:image/svg+xml;base64,{{ base64_encode(
                        QrCode::format('svg')->size(160)->generate($initialise_url)
                    ) }}" class="mt-3 w-40 h-40" />
                </div>

                <!-- Login -->
                <div>
                    <x-admin.section-title title="Step 4 — Log in" />
                    <p class="text-sm text-[var(--color-text-light)]">
                        Log in using your credentials.
                    </p>
                </div>

            </x-admin.card>
        @endif

        <!-- Email instructions -->
        <x-admin.card class="p-6 space-y-4">
            <x-admin.section-title title="Email instructions" />

            <p class="text-sm text-[var(--color-text-light)]">
                Prefer to set things up later? Email the instructions to yourself.
            </p>

            <x-admin.button variant="outline" wire:click="emailInstructions">
                Email instructions
            </x-admin.button>
        </x-admin.card>

    </div>

@endif
</div>

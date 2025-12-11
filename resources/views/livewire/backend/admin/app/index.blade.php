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

        <x-admin.card class="p-6 space-y-4">
            <x-admin.section-title title="Step 1 Install the app" />
            <p class="text-sm text-[var(--color-text-light)]">
                Select your device type and download the {{ config('check-in-app.friendly_name') }} app to get started.
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

        <x-admin.card class="p-6 space-y-4">
            <x-admin.section-title title="Step 2 Initialise the app" />
            <p class="text-sm text-[var(--color-text-light)]">
                Tap the button below to securely initialise the app with your organisation settings.
            </p>

            <a href="{{ $initialise_url }}" class="btn-secondary">Initialise app</a>
        </x-admin.card>

        <x-admin.card class="p-6 space-y-4">
            <x-admin.section-title title="Step 3 Log in" />
            <p class="text-sm text-[var(--color-text-light)]">
                Once initialised, sign in using your usual management panel credentials.
            </p>
        </x-admin.card>

    </div>


@else


{{-- DESKTOP FLOW --}}
<div class="px-6 space-y-6">

    <x-admin.card class="p-6 space-y-4">
        <x-admin.step-header
            step="Step 1"
            title="Choose your device"
            icon="heroicon-o-device-phone-mobile"
        />
        <p class="text-sm text-[var(--color-text-light)]">
            Select the type of phone you want to set up. The next steps will guide you through installing and activating the app.
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


    {{-- iPhone path --}}
    @if($phone_type === 'apple')

        <x-admin.card class="p-6 space-y-4">
            <x-admin.step-header
                step="Step 2"
                title="Install on iPhone"
                icon="heroicon-o-arrow-down-tray"
            />
            <p class="text-sm text-[var(--color-text-light)]">
                Scan this code using the camera on your iPhone. You will be taken directly to the App Store page where you can install the app.
            </p>

            <img
                class="mt-3 w-40 h-40"
                src="data:image/svg+xml;base64,{{ base64_encode(
                    QrCode::format('svg')->size(160)->generate($apple_url)
                ) }}"
            />
        </x-admin.card>

        <x-admin.card class="p-6 space-y-4">
            <x-admin.step-header
                step="Step 3"
                title="Initialise the app"
                icon="heroicon-o-cog"
            />
            <p class="text-sm text-[var(--color-text-light)]">
                After installing, open your camera again and scan this code. This links the app to your organisation and unlocks access.
            </p>

            <img
                class="mt-3 w-40 h-40"
                src="data:image/svg+xml;base64,{{ base64_encode(
                    QrCode::format('svg')->size(160)->generate($initialise_url)
                ) }}"
            />
        </x-admin.card>

        <x-admin.card class="p-6 space-y-4">
            <x-admin.step-header
                step="Step 4"
                title="Log in"
                icon="heroicon-o-lock-open"
            />
            <p class="text-sm text-[var(--color-text-light)]">
                Once the app is initialised, sign in using your management panel email and password.
            </p>
        </x-admin.card>

    @endif


    {{-- Android path --}}
    @if($phone_type === 'android')

        <x-admin.card class="p-6 space-y-4">
            <x-admin.step-header
                step="Step 2"
                title="Install on Android"
                icon="heroicon-o-arrow-down-tray"
            />
            <p class="text-sm text-[var(--color-text-light)]">
                Scan this code with your Android camera to open the Google Play download page and install the app.
            </p>

            <img
                class="mt-3 w-40 h-40"
                src="data:image/svg+xml;base64,{{ base64_encode(
                    QrCode::format('svg')->size(160)->generate($android_url)
                ) }}"
            />
        </x-admin.card>

        <x-admin.card class="p-6 space-y-4">
            <x-admin.step-header
                step="Step 3"
                title="Initialise the app"
                icon="heroicon-o-cog"
            />
            <p class="text-sm text-[var(--color-text-light)]">
                Scan this code once the app is installed. This securely loads your organisation settings into the app so you can begin checking in attendees.
            </p>

            <img
                class="mt-3 w-40 h-40"
                src="data:image/svg+xml;base64,{{ base64_encode(
                    QrCode::format('svg')->size(160)->generate($initialise_url)
                ) }}"
            />
        </x-admin.card>

        <x-admin.card class="p-6 space-y-4">
            <x-admin.step-header
                step="Step 4"
                title="Log in"
                icon="heroicon-o-lock-open"
            />
            <p class="text-sm text-[var(--color-text-light)]">
                Once the app has been initialised, log in using your management panel credentials to get started.
            </p>
        </x-admin.card>

    @endif


    <x-admin.card class="p-6 space-y-4">
        <x-admin.step-header
            step="In a rush?"
            title="Email the instructions"
            icon="heroicon-o-envelope"
        />
        <p class="text-sm text-[var(--color-text-light)]">
            If you would prefer to finish the setup later, you can email the full instructions to yourself and continue when convenient.
        </p>

        <x-admin.button variant="outline" wire:click="emailInstructions">
            Email instructions
        </x-admin.button>
    </x-admin.card>

</div>

@endif
</div>

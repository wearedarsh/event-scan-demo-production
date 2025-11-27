<div class="space-y-6">
@php
    $role = auth()->user()?->role?->key_name;
    $agent = new \Jenssegers\Agent\Agent();
@endphp


@if ($role !== 'app_user')
    <div class="px-6">
        <x-admin.breadcrumb :items="[
            ['label' => 'Home', 'href' => route('admin.dashboard')],
            ['label' => 'Check-in App']
        ]"/>
    </div>
@endif


<div class="px-6 space-y-6">
    <!-- Page Header -->
    <div class="px-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-[var(--color-text)]">Setting up your app</h1>
            <p class="text-sm text-[var(--color-text-light)] mt-1">
                Install, initialise and start using the {{ config('check-in-app.friendly_name') }} app.
            </p>
        </div>
    </div>

    
    <!-- Alerts -->
    @if (session()->has('success'))
        <div class="px-6">
            <div class="soft-card p-4 border-l-4 border-[var(--color-success)]">
                <p class="text-sm text-[var(--color-success)]">{{ session('success') }}</p>
            </div>
        </div>
    @endif

   



    <!-- ============================================================= -->
    <!-- MOBILE FLOW -->
    <!-- ============================================================= -->
    @if($agent->isMobile())

        <div class="px-6 space-y-6">

            <x-admin.section-title title="Install the app" />

            <div class="soft-card p-6 space-y-4">
                <p class="font-medium">Step 1. Install the app</p>
                <p class="text-sm text-[var(--color-text-light)]">
                    Choose your device type below to install the {{ config('check-in-app.friendly_name') }} app.
                </p>

                <div class="flex items-center gap-4">
                    <a href="{{ $apple_url }}"
                        class="flex items-center px-3 py-1.5 rounded-md text-sm font-medium
                                border border-[var(--color-primary)] text-[var(--color-primary)]
                                hover:bg-[var(--color-primary)] hover:text-white
                                transition">
                        <x-heroicon-o-device-phone-mobile class="h-4 w-4 mr-1.5" />
                        Apple
                    </a>

                    <a href="{{ $android_url }}"
                        class="flex items-center px-3 py-1.5 rounded-md text-sm font-medium
                                border border-[var(--color-primary)] text-[var(--color-primary)]
                                hover:bg-[var(--color-primary)] hover:text-white
                                transition">
                        <x-heroicon-o-device-phone-mobile class="h-4 w-4 mr-1.5" />
                        Android
                    </a>
                </div>
            </div>


            <div class="soft-card p-6 space-y-4">
                <p class="font-medium">Step 2. Initialise the app</p>
                <p class="text-sm text-[var(--color-text-light)]">
                    After installation, use the button below to initialise your app securely.
                </p>

                <a href="{{ $initialise_url }}" class="btn-secondary flex items-center gap-2">
                    Initialise app
                </a>
            </div>

            <div class="soft-card p-6 space-y-4">
                <p class="font-medium">Step 3. Log in</p>
                <p class="text-sm text-[var(--color-text-light)]">
                    Log in using your management panel credentials.
                </p>
            </div>

        </div>


    <!-- ============================================================= -->
    <!-- DESKTOP FLOW -->
    <!-- ============================================================= -->
    @else

        <div class="px-6 space-y-6">

            <x-admin.section-title title="Install on your device" />

            <div class="soft-card p-6 space-y-4">

                <p class="font-medium">Step 1. Choose your phone type</p>
                <p class="text-sm text-[var(--color-text-light)]">
                    Select your device and follow the steps to install and initialise the app.
                </p>

                <div class="flex items-center gap-4">
                    <button wire:click="selectPhone('apple')"
                        class="flex items-center px-3 py-1.5 rounded-md text-sm font-medium
                                border border-[var(--color-primary)] text-[var(--color-primary)]
                                hover:bg-[var(--color-primary)] hover:text-white
                                transition">
                        <x-heroicon-o-device-phone-mobile class="w-4 h-4" /> iPhone
                    </button>

                    <button wire:click="selectPhone('android')"
                        class="flex items-center px-3 py-1.5 rounded-md text-sm font-medium
                                border border-[var(--color-primary)] text-[var(--color-primary)]
                                hover:bg-[var(--color-primary)] hover:text-white
                                transition">
                        <x-heroicon-o-device-phone-mobile class="w-4 h-4" /> Android
                    </button>
                </div>

            </div>


            <!-- iPhone Path -->
            @if($phone_type === 'apple')
                <div class="soft-card p-6 space-y-6">

                    <div>
                        <p class="font-medium">Step 2. Install on iPhone</p>
                        <p class="text-sm text-[var(--color-text-light)]">
                            Scan this QR code with your iPhone camera to install the app from the App Store.
                        </p>
                        <img src="data:image/svg+xml;base64,{{ base64_encode(QrCode::format('svg')->size(160)->generate($apple_url)) }}"
                             class="mt-3 w-40 h-40" />
                    </div>

                    <div>
                        <p class="font-medium">Step 3. Initialise the app</p>
                        <p class="text-sm text-[var(--color-text-light)]">
                            Scan this code once to initialise securely.
                        </p>
                        <img src="data:image/svg+xml;base64,{{ base64_encode(QrCode::format('svg')->size(160)->generate($initialise_url)) }}"
                             class="mt-3 w-40 h-40" />
                    </div>

                    <div>
                        <p class="font-medium">Step 4. Log in</p>
                        <p class="text-sm text-[var(--color-text-light)]">
                            You're ready to log in using your management panel credentials.
                        </p>
                    </div>

                </div>
            @endif


            <!-- Android Path -->
            @if($phone_type === 'android')
                <div class="soft-card p-6 space-y-6">

                    <div>
                        <p class="font-medium">Step 2. Install on Android</p>
                        <p class="text-sm text-[var(--color-text-light)]">
                            Scan this QR code with your Android camera to install via Google Play.
                        </p>
                        <img src="data:image/svg+xml;base64,{{ base64_encode(QrCode::format('svg')->size(160)->generate($android_url)) }}"
                             class="mt-3 w-40 h-40" />
                    </div>

                    <div>
                        <p class="font-medium">Step 3. Initialise the app</p>
                        <p class="text-sm text-[var(--color-text-light)]">
                            Scan this code once to initialise securely.
                        </p>
                        <img src="data:image/svg+xml;base64,{{ base64_encode(QrCode::format('svg')->size(160)->generate($initialise_url)) }}"
                             class="mt-3 w-40 h-40" />
                    </div>

                    <div>
                        <p class="font-medium">Step 4. Log in</p>
                        <p class="text-sm text-[var(--color-text-light)]">
                            You're ready to log in using your credentials.
                        </p>
                    </div>

                </div>
            @endif



            <!-- Email Instructions -->
            <div class="soft-card p-6 space-y-4">
                <p class="font-medium">Email instructions</p>
                <p class="text-sm text-[var(--color-text-light)]">
                    Prefer to set things up later? We can send the installation & setup steps to your email.
                </p>
                <button class="btn-secondary" wire:click="emailInstructions">
                    Email instructions
                </button>
            </div>

        </div>

    @endif

</div>
</div>

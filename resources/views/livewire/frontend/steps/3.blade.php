<!-- Step 3: Account Details -->
<div class="space-y-4">

    <!-- Step Indicator -->
    <div class="bg-[var(--color-surface)] py-3 px-6 mt-6 rounded-lg shadow-sm flex items-center gap-4">
        <span class="bg-[var(--color-accent-light)] text-[var(--color-text)] text-xs px-3 py-1 rounded-full font-semibold">
            3 of 6
        </span>
        <span class="font-semibold text-[var(--color-secondary)]">Account details</span>
    </div>

    <!-- Error Message -->
    @if($errors->any())
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
        <p class="text-yellow-700 text-sm">{{ $errors->first() }}</p>
    </div>
    @endif

    <!-- Form -->
    <form class="text-left bg-[var(--color-surface)] rounded-xl shadow-sm border border-[var(--color-border)] p-6 space-y-6">

        <!-- Mobile -->
        <div class="grid grid-cols-3 md:grid-cols-4 gap-4">
            <div class="col-span-1">
                <label for="mobile_country_code" class="block text-sm font-semibold text-[var(--color-secondary)] mb-1">
                    Country code
                </label>
                <input
                    wire:model="mobile_country_code"
                    id="mobile_country_code"
                    type="text"
                    placeholder="e.g. +44"
                    class="w-full border border-[var(--color-border)] rounded-lg px-3 py-3 focus:ring-2 focus:ring-[var(--color-accent)] focus:outline-none"
                />
            </div>
            <div class="col-span-2 md:col-span-3">
                <label for="mobile_number" class="block text-sm font-semibold text-[var(--color-secondary)] mb-1">
                    Mobile number
                </label>
                <input
                    wire:model="mobile_number"
                    id="mobile_number"
                    type="text"
                    class="w-full border border-[var(--color-border)] rounded-lg px-3 py-3 focus:ring-2 focus:ring-[var(--color-accent)] focus:outline-none"
                />
            </div>
        </div>

        <!-- Info Alert -->
        <div class="bg-[var(--color-accent-light)] border-l-4 border-[var(--color-accent)] p-4 rounded-lg">
            <p class="text-[var(--color-secondary)] text-sm">
                Your email and password will be required to access your account before, during, and after the event. Please make sure you note your account details.
            </p>
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-[var(--color-secondary)] mb-1">
                Email address
            </label>
            <input
                wire:model="email"
                id="email"
                type="email"
                class="w-full border border-[var(--color-border)] rounded-lg px-3 py-3 focus:ring-2 focus:ring-[var(--color-accent)] focus:outline-none"
            />
        </div>

        <!-- Password -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="password" class="block text-sm font-semibold text-[var(--color-secondary)] mb-1">
                    Password
                </label>
                <input
                    wire:model="password"
                    id="password"
                    type="password"
                    class="w-full border border-[var(--color-border)] rounded-lg px-3 py-3 focus:ring-2 focus:ring-[var(--color-accent)] focus:outline-none"
                />
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-[var(--color-secondary)] mb-1">
                    Password confirmation
                </label>
                <input
                    wire:model="password_confirmation"
                    id="password_confirmation"
                    type="password"
                    class="w-full border border-[var(--color-border)] rounded-lg px-3 py-3 focus:ring-2 focus:ring-[var(--color-accent)] focus:outline-none"
                />
            </div>
        </div>
        <p class="text-xs text-[var(--color-text-light)]">
            Your password must be at least 8 characters long.
        </p>

         <div
                x-data
                x-on:stepChanged.window="window.scrollTo({ top: 0, behavior: 'smooth' })"
                x-on:scrollToTop.window="window.scrollTo({ top: 0, behavior: 'smooth' })">
            </div>

        <!-- Navigation Buttons -->
        <div class="flex flex-row gap-4 pt-6">
            <div class="flex-1">
                <button
                    type="button"
                    wire:click="prevStep"
                    class="w-full border border-[var(--color-primary)] text-[var(--color-primary)] font-semibold px-6 py-3 rounded-lg transition hover:bg-[var(--color-primary)] hover:text-[var(--color-surface)]"
                >
                    Previous
                </button>
            </div>
            <div class="flex-1">
                <button
                    type="button"
                    wire:click="nextStep"
                    class="w-full bg-[var(--color-primary)] text-[var(--color-surface)] font-semibold px-6 py-3 rounded-lg transition hover:opacity-90"
                >
                    Next
                </button>
            </div>
        </div>

        <!-- Cancel -->
        <div class="text-center pt-3">
            <a
                href="#"
                wire:click.prevent="clearLocalStorageAndRedirect"
                wire:confirm="Are you sure you want to cancel? This will reset all your details."
                class="font-bold text-[var(--color-accent)] hover:text-[var(--color-primary)] transition"
            >
                Cancel
            </a>
        </div>

    </form>

</div>

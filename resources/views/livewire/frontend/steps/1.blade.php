<div class="space-y-6"> <!-- Single root wrapper -->

    <!-- Step Indicator -->
    <div class="bg-[var(--color-surface)] py-3 px-6 mt-6 rounded-lg shadow-sm flex items-center gap-4">
        <span class="bg-[var(--color-accent-light)] text-[var(--color-text)] text-xs px-3 py-1 rounded-full font-semibold">1 of 6</span>
        <span class="font-semibold text-[var(--color-secondary)]">Personal details</span>
    </div>

    <!-- Error Message -->
    @if($errors->any())
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
        <p class="text-yellow-700 text-sm">{{ $errors->first() }}</p>
    </div>
    @endif

    <!-- Registration Form Step -->
    <form class="text-left bg-[var(--color-surface)] rounded-xl shadow-sm border border-[var(--color-border)] p-6 space-y-6">

        <!-- Title + Name -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="title" class="block text-sm font-semibold text-[var(--color-secondary)] mb-1">Title</label>
                <div class="relative flex items-center">
                    <select
                        wire:model="title"
                        class="appearance-none border border-[var(--color-border)] rounded-lg py-3 pl-3 pr-10 w-full text-[var(--color-text)] 
                        focus:ring-2 focus:ring-[var(--color-accent)] focus:outline-none bg-white">
                        <option value="">Please select...</option>
                        <option value="Dr">Dr</option>
                        <option value="Mr">Mr</option>
                        <option value="Mrs">Mrs</option>
                        <option value="Miss">Miss</option>
                        <option value="Ms">Ms</option>
                        <option value="Professor">Professor</option>
                    </select>

                    <svg
                        class="absolute right-3 w-5 h-5 text-[var(--color-text-light)] pointer-events-none"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>


            </div>

            <div>
                <label for="first_name" class="block text-sm font-semibold text-[var(--color-secondary)] mb-1">First Name</label>
                <input wire:model="first_name" type="text" id="first_name" class="w-full border border-[var(--color-border)] rounded-lg px-3 py-3 focus:ring-2 focus:ring-[var(--color-accent)] focus:outline-none" />
            </div>

            <div>
                <label for="last_name" class="block text-sm font-semibold text-[var(--color-secondary)] mb-1">Last Name</label>
                <input wire:model="last_name" type="text" id="last_name" class="w-full border border-[var(--color-border)] rounded-lg px-3 py-3 focus:ring-2 focus:ring-[var(--color-accent)] focus:outline-none" />
            </div>
        </div>

        <!-- Address Line 1 -->
        <div>
            <label for="address_line_one" class="block text-sm font-semibold text-[var(--color-secondary)] mb-1">Address line 1</label>
            <input wire:model="address_line_one" id="address_line_one" type="text" class="w-full border border-[var(--color-border)] rounded-lg px-3 py-3 focus:ring-2 focus:ring-[var(--color-accent)] focus:outline-none" />
        </div>

        <!-- Town + Postcode -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="town" class="block text-sm font-semibold text-[var(--color-secondary)] mb-1">Town</label>
                <input wire:model="town" id="town" type="text" class="w-full border border-[var(--color-border)] rounded-lg px-3 py-3 focus:ring-2 focus:ring-[var(--color-accent)] focus:outline-none" />
            </div>
            <div>
                <label for="postcode" class="block text-sm font-semibold text-[var(--color-secondary)] mb-1">Postcode</label>
                <input wire:model="postcode" id="postcode" type="text" class="w-full border border-[var(--color-border)] rounded-lg px-3 py-3 focus:ring-2 focus:ring-[var(--color-accent)] focus:outline-none" />
            </div>
        </div>

        <!-- Country -->
        <div>
            <label for="country_id" class="block text-sm font-semibold text-[var(--color-secondary)] mb-1">
                Country
            </label>
            <div class="relative flex items-center">
                <select
                    wire:model="country_id"
                    id="country_id"
                    class="appearance-none border border-[var(--color-border)] rounded-lg py-3 pl-3 pr-10 w-full text-[var(--color-text)] 
                        focus:ring-2 focus:ring-[var(--color-accent)] focus:outline-none bg-white">
                    <option value="">Please select...</option>
                    @foreach ($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>

                <!-- Chevron -->
                <svg
                    class="absolute right-3 w-5 h-5 text-[var(--color-text-light)] pointer-events-none"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>


        <!-- Next Button -->
        <div class="flex flex-row gap-4 pt-6">
            <div class="flex-1"></div>
            <div class="flex-1">
                <button type="button" wire:click="nextStep" class="w-full bg-[var(--color-primary)] text-[var(--color-surface)] font-semibold px-6 py-3 rounded-lg transition hover:opacity-90">
                    Next
                </button>
            </div>
        </div>

        <!-- Cancel Link -->
        <div class="text-center pt-3">
            <a href="#" wire:click.prevent="clearLocalStorageAndRedirect" class="font-bold text-[var(--color-accent)] hover:text-[var(--color-primary)] transition">
                Cancel
            </a>
        </div>

        <div
            x-data
            x-on:stepChanged.window="window.scrollTo({ top: 0, behavior: 'smooth' })"
            x-on:scrollToTop.window="window.scrollTo({ top: 0, behavior: 'smooth' })">
        </div>

    </form>

</div>
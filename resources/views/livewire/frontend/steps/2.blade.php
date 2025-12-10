<!-- Step 2: Professional Details -->
<div class="space-y-4">

    <!-- Step Indicator -->
    <div class="bg-[var(--color-surface)] py-3 px-6 mt-6 rounded-lg shadow-sm flex items-center gap-4">
        <span class="bg-[var(--color-accent-light)] text-[var(--color-text)] text-xs px-3 py-1 rounded-full font-semibold">2 of 6</span>
        <span class="font-semibold text-[var(--color-secondary)]">Professional details</span>
    </div>

    <!-- Error Message -->
    @if($errors->any())
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
        <p class="text-yellow-700 text-sm">{{ $errors->first() }}</p>
    </div>
    @endif

    <!-- Form -->
    <form class="text-left bg-[var(--color-surface)] rounded-xl shadow-sm border border-[var(--color-border)] p-6 space-y-6">

        <!-- Currently held position -->
        <div>
            <label for="currently_held_position" class="block text-sm font-semibold text-[var(--color-secondary)] mb-1">Company</label>
            <input wire:model="currently_held_position" id="currently_held_position" type="text" class="w-full border border-[var(--color-border)] rounded-lg px-3 py-3 focus:ring-2 focus:ring-[var(--color-accent)] focus:outline-none" />
        </div>

        <!-- Attendee Type -->
        <div>
            <label for="attendee_type_id" class="block text-sm font-semibold text-[var(--color-secondary)] mb-1">
                Profession
                <br><span class="text-xs font-normal text-[var(--color-text-light)]">Please select from the list below</span>
            </label>
            <div class="relative">
                <select wire:model="attendee_type_id" id="attendee_type_id" class="appearance-none border border-[var(--color-border)] rounded-lg py-3 pl-3 pr-10 w-full text-[var(--color-text)] focus:ring-2 focus:ring-[var(--color-accent)] bg-white">
                    <option value="">Please select...</option>
                    @foreach($attendee_types as $attendee_type)
                        <option value="{{ $attendee_type->id }}">{{ $attendee_type->name }}</option>
                    @endforeach
                </select>
                <!-- Chevron -->
                <svg class="absolute right-3 w-5 h-5 text-[var(--color-text-light)] pointer-events-none top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>

        <!-- Attendee Type Other -->
        <div>
            <label for="attendee_type_other" class="block text-sm font-semibold text-[var(--color-secondary)] mb-1">
                Other
                <br><span class="text-xs font-normal text-[var(--color-text-light)]">If your profession isn’t listed please enter it here</span>
            </label>
            <input wire:model="attendee_type_other" id="attendee_type_other" type="text" class="w-full border border-[var(--color-border)] rounded-lg px-3 py-3 focus:ring-2 focus:ring-[var(--color-accent)] focus:outline-none" />
        </div>

        <!-- Buttons -->
        <div class="flex flex-row gap-4 pt-6">
            <div class="flex-1">
                <button type="button" wire:click="prevStep" class="w-full border border-[var(--color-primary)] text-[var(--color-primary)] font-semibold px-6 py-3 rounded-lg transition hover:bg-[var(--color-primary)] hover:text-[var(--color-surface)]">
                    Previous
                </button>
            </div>
            <div class="flex-1">
                <button type="button" wire:click="nextStep" class="w-full bg-[var(--color-primary)] text-[var(--color-surface)] font-semibold px-6 py-3 rounded-lg transition hover:opacity-90">
                    Next
                </button>
            </div>
        </div>

            <div
                x-data
                x-on:stepChanged.window="window.scrollTo({ top: 0, behavior: 'smooth' })"
                x-on:scrollToTop.window="window.scrollTo({ top: 0, behavior: 'smooth' })">
            </div>

            

        <!-- Cancel -->
        <div class="text-center pt-3">
            <a href="#" wire:click.prevent="clearLocalStorageAndRedirect" wire:confirm="Are you sure you want to cancel? This will reset all your details." class="font-bold text-[var(--color-accent)] hover:text-[var(--color-primary)] transition">
                Cancel
            </a>
        </div>

    </form>

</div>

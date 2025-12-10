<!-- Step 4: Marketing / GDPR -->
<div class="space-y-4">

    <!-- Step Indicator -->
    <div class="bg-[var(--color-surface)] py-3 px-6 mt-6 rounded-lg shadow-sm flex items-center gap-4">
        <span class="bg-[var(--color-accent-light)] text-[var(--color-text)] text-xs px-3 py-1 rounded-full font-semibold">
            4 of 6
        </span>
        <span class="font-semibold text-[var(--color-secondary)]">GDPR & Marketing Preferences</span>
    </div>

    <!-- Error Message -->
    @if($errors->any())
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
        <p class="text-yellow-700 text-sm">{{ $errors->first() }}</p>
    </div>
    @endif

    <!-- Form -->
    <form class="text-left bg-[var(--color-surface)] rounded-xl shadow-sm border border-[var(--color-border)] p-6 space-y-6">

        <!-- Auto Email Opt-in Notice -->
        @if($event->auto_email_opt_in)
            <div class="bg-[var(--color-accent-light)] border-l-4 border-[var(--color-accent)] p-4 rounded-lg text-sm text-[var(--color-secondary)]">
                {{ $event->email_opt_in_description ?? 'By registering for this event, I agree that I will automatically be enrolled to receive all emails and correspondence relating to the event.' }}
            </div>
        @endif

        <!-- Future Eventscan Events Opt-in -->
        @if($event->show_email_marketing_opt_in)
            <div class="flex items-start gap-3">
                <input
                    wire:model="email_marketing_opt_in"
                    id="email_marketing_opt_in"
                    type="checkbox"
                    class="w-5 h-5 text-[var(--color-primary)] border-[var(--color-border)] rounded focus:ring-[var(--color-accent)] focus:ring-2"
                />
                <label for="email_marketing_opt_in" class="text-[var(--color-text)] text-sm leading-snug">
                    Please keep me informed of future <strong>{{config('customer.contact_details.booking_website_company_name')}}</strong> events.
                </label>
            </div>
        @endif

        <!-- Custom Event Opt-in Checks -->
        @if($event->eventOptInChecks)
            @foreach($event->eventOptInChecks as $check)
                <div class="flex items-start gap-3">
                    <input
                        wire:model="opt_in_responses.{{ $check->id }}"
                        id="opt_in_{{ $check->id }}"
                        type="checkbox"
                        class="w-5 h-5 text-[var(--color-primary)] border-[var(--color-border)] rounded focus:ring-[var(--color-accent)] focus:ring-2"
                    />
                    <label for="opt_in_{{ $check->id }}" class="text-[var(--color-text)] text-sm leading-snug">
                        {{ $check->description }}
                    </label>
                </div>
            @endforeach
        @endif

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

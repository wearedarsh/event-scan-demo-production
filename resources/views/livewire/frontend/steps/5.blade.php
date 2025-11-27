<!-- Step 5: Select Tickets -->
<div class="space-y-6">

  <!-- Step indicator -->
  <div class="bg-[var(--color-surface)] py-3 px-6 mt-6 rounded-lg shadow-sm flex items-center gap-4">
    <span class="bg-[var(--color-accent-light)] text-[var(--color-text)] text-xs px-3 py-1 rounded-full font-semibold">
      5 of 6
    </span>
    <span class="font-semibold text-[var(--color-secondary)]">Select tickets</span>
  </div>

  <!-- Intro alert -->
  <div class="bg-[var(--color-accent-light)] border-l-4 border-[var(--color-accent)] p-4 rounded-lg text-sm text-[var(--color-secondary)]">
    <p>
      <strong>What’s included</strong><br />
      The registration fee includes access to all lectures, workshops, hands-on sessions, tea/coffee breaks, lunch,
      certificate of attendance and conference documentation.
    </p>
  </div>

  <!-- Cancelled payment notice -->
  <div
    x-data="{ show: @entangle('cancelled') }"
    x-show="show"
    x-transition
    x-init="setTimeout(() => show = false, 5000)"
    class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg text-sm text-yellow-800"
    role="alert"
    aria-live="assertive"
  >
    Payment was cancelled. Please reselect your tickets to continue.
  </div>

  <form class="text-left bg-[var(--color-surface)] rounded-xl shadow-sm border border-[var(--color-border)] p-6 space-y-6">

    @if($event->ticketGroups->isNotEmpty())
      @foreach($event->ticketGroups->sortBy('display_order') as $group)

        <!-- Group header -->
        <div>
          <h3 class="text-lg font-semibold text-[var(--color-secondary)]">{{ $group->name }}</h3>
          @if($group->description)
            <p class="text-sm text-[var(--color-text-light)]">{{ $group->description }}</p>
          @endif
        </div>

        @if($group->tickets->isNotEmpty())

          <!-- Single-select group -->
          @if(!$group->multiple_select)
            <div class="relative flex items-center">
              <select
                wire:model.live="single_ticket_selections.{{ $group->id }}"
                class="appearance-none border border-[var(--color-border)] rounded-lg py-3 pl-3 pr-10 w-full text-[var(--color-text)] focus:ring-2 focus:ring-[var(--color-accent)] bg-white"
              >
                <option value="">Please select…</option>
                @foreach($group->activeTickets->sortBy('display_order') as $ticket)
                  <option value="{{ $ticket->id }}">
                    {{ $ticket->name }} – {{ $this->currency_symbol }}{{ $ticket->price }}
                  </option>
                @endforeach
              </select>
              <svg
                class="absolute right-3 w-5 h-5 text-[var(--color-text-light)] pointer-events-none"
                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
              </svg>
            </div>

            @if($errors->any())
              <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg text-sm text-yellow-800">
                {{ $errors->first() }}
              </div>
            @endif

            @php
              $selected_ticket_id = $single_ticket_selections[$group->id] ?? null;
              $selected_ticket = $group->tickets->firstWhere('id', $selected_ticket_id);
            @endphp

            @if($selected_ticket && $selected_ticket->requires_document_upload)
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg text-sm text-yellow-800 space-y-3">
                {!! $selected_ticket->requires_document_copy ?? 'This file requires a document to be uploaded.' !!}

                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                    <!-- Hidden file input -->
                    <input
                        type="file"
                        id="upload_{{ $group->id }}"
                        wire:model="registration_uploads.{{ $group->id }}"
                        class="hidden"
                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                    />

                    <!-- Styled label as button -->
                    <label
                        for="upload_{{ $group->id }}"
                        class="cursor-pointer inline-flex items-center justify-center bg-[var(--color-primary)] text-[var(--color-surface)] font-semibold px-4 py-2 rounded-lg mt-2 transition hover:opacity-90"
                    >
                        Select file
                    </label>

                    <!-- Show selected file name -->
                    @if(isset($registration_uploads[$group->id]))
                        <span class="text-[var(--color-text-light)] text-sm truncate max-w-[200px]">
                            {{ $registration_uploads[$group->id]->getClientOriginalName() }}
                        </span>
                    @endif

                    <!-- Loading state -->
                    <div wire:loading wire:target="registration_uploads.{{ $group->id }}" class="text-xs text-[var(--color-text-light)]">
                        Uploading…
                    </div>
                </div>
            </div>
            @endif

          <!-- Multiple-select group -->
          @else
            <div class="space-y-2">
              @foreach($group->activeTickets as $ticket)
                <div class="flex items-center justify-between border border-[var(--color-border)] rounded-lg p-3">
                  <span class="text-[var(--color-text)]">
                    {{ $ticket->name }} – {{ $this->currency_symbol }}{{ $ticket->price }}
                  </span>
                  <select
                    wire:model.live="ticket_quantities.{{ $ticket->id }}"
                    class="border border-[var(--color-border)] rounded-lg px-2 py-2 text-[var(--color-text)] focus:ring-2 focus:ring-[var(--color-accent)] bg-white"
                  >
                    @for($i = 0; $i <= $ticket->max_volume; $i++)
                      <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                  </select>
                </div>
              @endforeach
            </div>
          @endif

        @else
          <div class="bg-[var(--color-accent-light)] border-l-4 border-[var(--color-accent)] p-4 rounded-lg text-sm text-[var(--color-secondary)]">
            There are currently no tickets for this group.
          </div>
        @endif

      @endforeach
    @else
      <div class="bg-[var(--color-accent-light)] border-l-4 border-[var(--color-accent)] p-4 rounded-lg text-sm text-[var(--color-secondary)]">
        There are currently no ticket groups to display.
      </div>
    @endif

    <!-- Special requirements -->
    <div>
      <h3 class="text-lg font-semibold text-[var(--color-secondary)] mb-1">Special requirements</h3>
      <p class="text-sm text-[var(--color-text-light)] mb-2">
        Please indicate any allergies or dietary requirements.
      </p>
      <input
        wire:model="special_requirements"
        type="text"
        placeholder="e.g. vegan"
        class="w-full border border-[var(--color-border)] rounded-lg px-3 py-3 focus:ring-2 focus:ring-[var(--color-accent)] focus:outline-none"
      />
    </div>

    <!-- Total -->
    <div class="flex items-center justify-between border-t border-[var(--color-border)] pt-4">
      <h3 class="text-lg font-semibold text-[var(--color-secondary)]">Registration total :</h3>
      <h3 class="text-lg font-semibold text-[var(--color-secondary)]">
        {{ $this->currency_symbol }}{{ $registration_total }}
      </h3>
    </div>

     <div
                x-data
                x-on:stepChanged.window="window.scrollTo({ top: 0, behavior: 'smooth' })"
                x-on:scrollToTop.window="window.scrollTo({ top: 0, behavior: 'smooth' })">
            </div>

    <!-- Navigation -->
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

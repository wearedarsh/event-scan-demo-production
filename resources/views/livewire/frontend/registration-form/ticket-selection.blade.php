<div class="space-y-4">

    <x-registration.step-indicator
        :current="5"
        :total="6"
        label="Select tickets"
    />

    <x-registration.form-info>
        <strong>What’s included</strong><br>
        The registration fee includes access to all lectures, workshops, hands-on sessions, tea/coffee breaks, lunch,
        certificate of attendance and conference documentation.
    </x-registration.form-info>

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

    <x-registration.form-step>
        @if($event->ticketGroups->isNotEmpty())
            @foreach($event->ticketGroups->sortBy('display_order') as $group)

                <div>
                    <h3 class="text-lg font-semibold text-[var(--color-secondary)]">{{ $group->name }}</h3>
                    @if($group->description)
                        <p class="text-sm text-[var(--color-text-light)]">{{ $group->description }}</p>
                    @endif
                </div>

                @if($group->tickets->isNotEmpty())
                    @if(!$group->multiple_select)
                        <x-registration.input-select
                            :id="'single_ticket_' . $group->id"
                            :wire:model="'single_ticket_selections.' . $group->id"
                            placeholder="Please select…"
                        >
                            @foreach($group->activeTickets->sortBy('display_order') as $ticket)
                                <option value="{{ $ticket->id }}">
                                    {{ $ticket->name }} – {{ $this->currency_symbol }}{{ $ticket->price }}
                                </option>
                            @endforeach
                        </x-registration.input-select>

                        @php
                            $selected_ticket_id = $single_ticket_selections[$group->id] ?? null;
                            $selected_ticket = $group->tickets->firstWhere('id', $selected_ticket_id);
                        @endphp

                        @if($selected_ticket && $selected_ticket->requires_document_upload)
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg text-sm text-yellow-800 space-y-3">
                                {!! $selected_ticket->requires_document_copy ?? 'This file requires a document to be uploaded.' !!}
                                <x-registration.input-file
                                    :id="'upload_' . $group->id"
                                    :model="'registration_uploads.' . $group->id"
                                />
                            </div>
                        @endif

                    @else
                        <div class="space-y-2">
                            @foreach($group->activeTickets as $ticket)
                                <div class="flex items-center justify-between border border-[var(--color-border)] rounded-lg p-3">
                                    <span class="text-[var(--color-text)]">
                                        {{ $ticket->name }} – {{ $this->currency_symbol }}{{ $ticket->price }}
                                    </span>
                                    <x-registration.input-select
                                        :wire:model="'ticket_quantities.' . $ticket->id"
                                    >
                                        @for($i = 0; $i <= $ticket->max_volume; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </x-registration.input-select>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    <x-registration.form-info>
                        There are currently no tickets for this group.
                    </x-registration.form-info>
                @endif

            @endforeach
        @else
            <x-registration.form-info>
                There are currently no ticket groups to display.
            </x-registration.form-info>
        @endif

        <div>
            <x-registration.input-label for="special_requirements">Special requirements</x-registration.input-label>
            <x-registration.input-text
                id="special_requirements"
                wire:model="special_requirements"
                placeholder="e.g. vegan"
            />
        </div>

        <div class="flex items-center justify-between border-t border-[var(--color-border)] pt-4">
            <h3 class="text-lg font-semibold text-[var(--color-secondary)]">Registration total :</h3>
            <h3 class="text-lg font-semibold text-[var(--color-secondary)]">
                {{ $this->currency_symbol }}{{ $registration_total }}
            </h3>
        </div>

        <div class="flex flex-row gap-4 pt-6">
            <div class="flex-1">
                <x-registration.navigate-button action="prevStep">
                    Previous
                </x-registration.navigate-button>
            </div>
            <div class="flex-1">
                <x-registration.navigate-button action="nextStep">
                    Next
                </x-registration.navigate-button>
            </div>
        </div>

        <x-registration.navigate-cancel-link action="clearLocalStorageAndRedirect" />

    </x-registration.form-step>

</div>

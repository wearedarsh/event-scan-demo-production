<div class="space-y-6">

    @if($errors->any())
    <x-registration.alert type="warning" :message="$errors->first()" />
    @endif

    <x-registration.form-step>

        @foreach($event->ticketGroups->sortBy('display_order') as $group)

        <div class="space-y-3">

            <div>
                <h3 class="text-lg font-semibold text-[var(--color-secondary)]">
                    {{ $group->name }}
                </h3>

                @if($group->description)
                <p class="text-sm text-[var(--color-text-light)]">
                    {{ $group->description }}
                </p>
                @endif
            </div>

            @if(!$group->multiple_select)

            <x-registration.input-select
                wire:model.live="single_ticket_selections.{{ $group->id }}"
                placeholder="Please select…">
                @foreach($group->activeTickets->sortBy('display_order') as $ticket)
                <option value="{{ $ticket->id }}">
                    {{ $ticket->name }} – [£]{{ $ticket->Price }}
                </option>
                @endforeach
            </x-registration.input-select>

            @else

            <div class="space-y-2">
                @foreach($group->activeTickets as $ticket)
                <div class="flex justify-between items-center rounded-md border border-[var(--color-border)] p-3">
                    <span>
                        {{ $ticket->name }} – [£]{{ $ticket->Price }}
                    </span>

                    <x-registration.input-select
                        wire:model.live="multiple_ticket_selections.{{ $ticket->id }}">
                        @for($i = 0; $i <= $ticket->max_volume; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                    </x-registration.input-select>
                </div>
                @endforeach
            </div>

            @endif

            @foreach(
            $this->selectedTicketsRequiringUploads()
            ->where('ticket_group_id', $group->id)
            as $ticket
            )
            @php
            $existingDocument = $registration->registrationDocuments
            ->firstWhere('ticket_id', $ticket->id);
            @endphp

            <div class="mt-3 rounded-md bg-[var(--color-bg-soft)] space-y-3 pt-1">

                @if($existingDocument && empty($replace_document[$ticket->id]))

                <x-registration.document-uploaded
                    :ticket="$ticket"
                    message="Document uploaded: {{ $existingDocument->original_name }}" />

                @else

                <x-registration.input-file
                    :id="'ticket-upload-' . $ticket->id"
                    :model="'ticket_documents.' . $ticket->id"
                    label="Upload document"
                    :download_copy="$ticket->requires_document_copy"
                    :accept="
                $ticket->allowedFileTypes()
                    ? implode(',', array_map(fn ($t) => '.' . $t, $ticket->allowedFileTypes()))
                    : '.pdf,.doc,.docx,.jpg,.jpeg,.png'
            "
                    :filename="
                isset($ticket_documents[$ticket->id])
                    ? $ticket_documents[$ticket->id]->getClientOriginalName()
                    : null
            " />

                @endif

            </div>
            @endforeach


        </div>

        <hr class="border-[var(--color-border)] my-4">

        @endforeach

        <div class="flex justify-between pt-4">
            <strong>Total</strong>
            <strong>[£]{{ $this->registrationTotal }}</strong>
        </div>

    </x-registration.form-step>

    <div class="flex gap-4">
        <x-registration.navigate-button
            wire:click="$dispatch('validate-step', ['backward'])">
            Previous
        </x-registration.navigate-button>

        <x-registration.navigate-button
            wire:click="$dispatch('validate-step', ['forward'])">
            Next
        </x-registration.navigate-button>
    </div>

</div>
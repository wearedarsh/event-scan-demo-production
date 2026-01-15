<div class="space-y-4">
    @if($errors->any())
    <x-registration.alert type="warning" :message="$errors->first()" />
    @endif

    <x-registration.form-step>
        @if($step_help_info)
            <x-registration.form-info>
                {{ $step_help_info }}
            </x-registration.form-info>
            
        @endif

        @foreach($inputs as $input)
            @if($input->type != 'document_upload')
                <x-registration.input-dynamic-field :input="$input" />
            @else

                @php
                    $existing_document = $registration->registrationDocuments
                    ->firstWhere('registration_form_input_id', $input->id);
                @endphp

                <x-registration.input-label>
                    {{ $input->label }}
                </x-registration.input-label>

                @if($existing_document && empty($replace_document[$input->id]))

                <x-registration.document-uploaded
                    key_path="replace_document.{{ $input->id }}"
                    message="Document uploaded: {{ $existing_document->original_name }}" />

                @else

                <x-registration.input-file
                    :id="'document-upload-' . $input->id"
                    :model="'document_uploads.' . $input->id"
                    :download_copy="$input->help"
                    :accept="$input->allowed_file_types"
                    :filename="
                    isset($document_uploads[$input->id])
                        ? $document_uploads[$input->id]->getClientOriginalName()
                        : null
                " />

                @endif

            @endif
        @endforeach
    </x-registration.form-step>

    <div class="flex w-full flex-row gap-4 pt-6">
        <div class="flex-1">
            @if($current_step > 1)
            <x-registration.navigate-button wire:click="$dispatch('validate-step', ['backward'])">
                Previous
            </x-registration.navigate-button>
            @endif
        </div>
        <div class="flex-1">
            <x-registration.navigate-button wire:click="$dispatch('validate-step', ['forward'])">
                @if($current_step === $total_steps) client_setting('booking.navigation.approval.final_step_button_label') @else Next @endif
            </x-registration.navigate-button>
        </div>
    </div>
    <div class="flex w-full flex-row gap-4 pt-6 justify-center">
        <x-registration.navigate-cancel-link wire:click="$dispatch('clear-session')">
            Cancel
        </x-registration.navigate-cancel-link>
    </div>
</div>
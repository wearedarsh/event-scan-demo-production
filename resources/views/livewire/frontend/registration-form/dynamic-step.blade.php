<div class="space-y-4">

    <x-registration.step-indicator
        :current="$step->display_order"
        :total="$step->form->steps->count()"
        :label="$step->label"
    />

    <x-registration.message type="error" />

    <x-registration.form-step>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($step->inputs->sortBy('display_order') as $input)

                <div class="{{ $input->width === 'full' ? 'md:col-span-2' : '' }}">

                    <x-registration.input-label :for="$input->key_name">
                        {{ $input->label }}
                    </x-registration.input-label>

                    {{-- TEXT --}}
                    @if($input->type === 'text')
                        <x-registration.input-text
                            :id="$input->key_name"
                            :placeholder="$input->placeholder"
                            wire:model.defer="state.{{ $input->key_name }}"
                        />
                    @endif

                    {{-- SELECT --}}
                    @if($input->type === 'select')
                        <x-registration.input-select
                            :id="$input->key_name"
                            :placeholder="$input->placeholder"
                            wire:model.defer="state.{{ $input->key_name }}"
                            :options="$this->getSelectOptions($input)"
                        />
                    @endif

                </div>

            @endforeach
        </div>

        <div class="flex flex-row gap-4 pt-6">
            <div class="flex-1">
                <x-registration.navigate-button action="prevStep" style="outline">
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

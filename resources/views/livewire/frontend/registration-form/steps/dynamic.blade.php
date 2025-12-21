<div class="space-y-4">
    <x-registration.form-step>
        @foreach($inputs as $input)
            <x-registration.input-dynamic-field :input="$input" wire.model="form_data.{{$input->key_name}}" />
        @endforeach
    </x-registration.form-step>

    <div class="flex w-full flex-row gap-4 pt-6">
            <div class="flex-1">
                <x-registration.navigate-button wire:click="$dispatch('prev-step')">
                    Previous
                </x-registration.navigate-button>
            </div>
            <div class="flex-1">
                <x-registration.navigate-button wire:click="$dispatch('next-step')">
                    Next
                </x-registration.navigate-button>
            </div>
        </div>
</div>

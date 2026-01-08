<div class="space-y-4">
    @if($errors->any())
        <x-registration.alert type="warning" :message="$errors->first()" />
    @endif

    <x-registration.form-step>
        @foreach($inputs as $input)
            <x-registration.input-dynamic-field :input="$input" />
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
                    Next
                </x-registration.navigate-button>
            </div>
        </div>
</div>

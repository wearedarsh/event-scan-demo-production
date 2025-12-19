<div class="space-y-4">
    <x-registration.form-step>
        <div class="grid grid-cols-12 gap-6">
        @foreach($inputs as $input)
            <div class="col-span-12 md:col-span-{{ $input->col_span ?? 12 }} space-y-2">
                <x-registration.input-label :for="$input->key_name">
                    {{ $input->label }}
                </x-registration.input-label>
                
                @if($input->type === 'text')
                    <x-registration.input-text
                        :id="$input->key_name"
                        wire:model="{{$input->key_name}}"
                    />
                @elseif($input->type === 'textarea')
                    <x-registration.input-textarea
                        :id="$input->key_name"
                        wire:model="{{$input->key_name}}"
                    />
                @elseif($input->type === 'checkbox')
                    <x-registration.input-checkbox
                        id="{{$input->key_name.$input->id }}"
                        wire:model="{{$input->key_name.$input->id }}"
                        label="{{ $input->label }}"
                    />
                @elseif($input->type === 'select')
                    <x-registration.input-select
                        wire:model="{{$input->key_name}}"
                        :placeholder="$input->place_holder"
                    >
                        @foreach($this->getInputOptions($input) as $option)
                            <option value="{{ $option['value'] }}">
                                {{ $option['label'] }}
                            </option>
                        @endforeach

                    </x-registration.input-select>
                @endif

                @if($input->help)
                    <x-registration.input-help>
                        {{ $input->help }}
                    </x-registration.input-help>
                @endif
            </div>
        
        @endforeach
        </div>
    </x-registration.form-step>
</div>

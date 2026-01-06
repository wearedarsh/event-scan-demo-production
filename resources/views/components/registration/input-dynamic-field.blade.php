@props([
    'input' => null,
])

@php
$col_span_class = match ((int) $input->col_span) {
    1 => 'md:col-span-1',
    2 => 'md:col-span-2',
    3 => 'md:col-span-3',
    4 => 'md:col-span-4',
    5 => 'md:col-span-5',
    6 => 'md:col-span-6',
    7 => 'md:col-span-7',
    8 => 'md:col-span-8',
    9 => 'md:col-span-9',
    10 => 'md:col-span-10',
    11 => 'md:col-span-11',
    default => 'md:col-span-12',
};
@endphp
@if($input->row_start)
    <div class="grid grid-cols-12 gap-6">
@endif
    <div class="col-span-12 {{ $col_span_class }} space-y-2">
            <x-registration.input-label :for="$input->key_name">
                {{ $input->label }}
            </x-registration.input-label>
        @if($input->type === 'text')
            <x-registration.input-text
                :id="$input->key_name"
                wire:model="form_data.{{ $input->key_name }}"
                :placeholder="$input->placeholder"
            />
        @elseif($input->type === 'textarea')
            <x-registration.input-textarea
                :id="$input->key_name"
                wire:model="form_data.{{ $input->key_name }}"
                :placeholder="$input->placeholder"
            />
        @elseif($input->type === 'checkbox')
            <x-registration.input-checkbox
                id="{{$input->key_name.$input->id }}"
                wire:model="form_data.{{ $input->key_name }}.{{$input->id}}"
                label="{{ $input->label }}"
            />
        @elseif($input->type === 'select')
            <x-registration.input-select
                wire:model.live="form_data.{{ $input->key_name }}"
                :placeholder="$input->placeholder"
            >
                @foreach($this->getInputOptions($input) as $option)
                    <option value="{{ $option['value'] }}">
                        {{ $option['label'] }}
                    </option>
                @endforeach

            </x-registration.input-select>

        @elseif($input->type === 'document_upload')
            <x-registration.input-file
                :id="$input->key_name"
                model="form_data.{{ $input->key_name }}"
                accept=".pdf,.doc,.docx"
            />
        @endif

        @if($input->help)
            <x-registration.input-help>
                {{ $input->help }}
            </x-registration.input-help>
        @endif

    </div>

@if($input->row_end)
    </div>
@endif
@props([
    'active' => false,
    'showLabel' => false,
    'labelOn' => 'Active',
    'labelOff' => 'Inactive',
])

<button
    {{ $attributes->merge([
        'class' => 'flex items-center gap-2 cursor-pointer select-none',
    ]) }}
    wire:loading.attr="disabled"
>

    {{-- Toggle Switch --}}
    <div class="relative inline-flex items-center">

        {{-- Background --}}
        <div class="w-6 h-3 rounded-full transition-colors duration-300
            {{ $active ? 'bg-[var(--color-success)]' : 'bg-gray-300' }}">
        </div>

        {{-- Knob --}}
        <div class="absolute left-0 top-0 h-3 w-3 bg-white rounded-full shadow 
            transform transition-transform duration-300
            {{ $active ? 'translate-x-3' : '' }}">
        </div>

    </div>

    {{-- Optional Status Label --}}
    @if($showLabel)
        <span class="text-sm font-regular
            {{ $active ? 'text-[var(--color-text)]' : 'text-[var(--color-text)]' }}">
            {{ $active ? $labelOn : $labelOff }}
        </span>
    @endif

</button>

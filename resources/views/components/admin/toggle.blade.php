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
        <div class="w-8 h-4 rounded-full transition-colors duration-300
            {{ $active ? 'bg-[var(--color-success)]' : 'bg-gray-300' }}">
        </div>

        {{-- Knob --}}
        <div class="absolute left-0 top-0 h-4 w-4 bg-white rounded-full shadow 
            transform transition-transform duration-300
            {{ $active ? 'translate-x-5' : '' }}">
        </div>

    </div>

    {{-- Optional Status Label --}}
    @if($showLabel)
        <span class="text-sm font-semibold
            {{ $active ? 'text-[var(--color-success)]' : 'text-[var(--color-danger)]' }}">
            {{ $active ? $labelOn : $labelOff }}
        </span>
    @endif

</button>

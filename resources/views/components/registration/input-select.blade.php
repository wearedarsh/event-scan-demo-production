@props([
    'id' => null,
    'name' => null,
    'options' => [],
    'placeholder' => 'Please select...',
])

<div class="relative">
    <select
        @if($id) id="{{ $id }}" @endif
        @if($name) name="{{ $name }}" @endif
        {{ $attributes->merge([
            'class' => 'appearance-none border border-[var(--color-border)] rounded-lg py-3 pl-3 pr-10 w-full text-[var(--color-text)]
                        focus:ring-2 focus:ring-[var(--color-accent)] focus:outline-none bg-white'
        ]) }}
    >
        <option value="">{{ $placeholder }}</option>

        @if(count($options) > 0)
            @foreach ($options as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        @else
            {{ $slot }}
        @endif

    </select>

    <x-heroicon-o-chevron-down
        class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-[var(--color-text-light)] pointer-events-none"
    />
</div>

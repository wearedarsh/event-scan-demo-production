@props([
    'href' => '#',
    'target' => null,
])

<a href="{{ $href }}"
   @if($target) target="{{ $target }}" @endif
   {{ $attributes->merge([
        'class' =>
            'group inline-flex items-center text-sm font-medium
             text-[var(--color-primary)] hover:text-[var(--color-primary-hover)]
             transition-colors duration-200'
   ]) }}>

    <span>{{ $slot }}</span>

    <img
        src="{{ asset('images/backend/link-arrow.svg') }}"
        alt=""
        class="ml-1 h-3 w-3 opacity-80
               transition-all duration-200 ease-out
               group-hover:opacity-100 group-hover:translate-x-[4px]"
    />

</a>

@props(['items' => []])

<nav class="w-full px-6 py-2 text-xs text-[var(--color-text-light)]  
     border-[var(--color-border)] font-light">

    <ol class="flex rounded-md items-center gap-2 bg-[var(--color-border)]/50 p-2 px-3">

        @foreach ($items as $item)
            @if (!$loop->last)
                <li>
                    <a href="{{ $item['href'] }}"
                       class="hover:text-[var(--color-primary)]">
                        {{ $item['label'] }}
                    </a>
                </li>
                <li>/</li>
            @else
                <li class="text-[var(--color-text)] font-light">
                    {{ $item['label'] }}
                </li>
            @endif
        @endforeach

    </ol>
</nav>

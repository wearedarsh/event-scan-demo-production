@props(['items' => []])

<nav class="w-full px-6 py-2 text-sm text-[var(--color-text-light)] border-b 
     border-[var(--color-border)] bg-[var(--color-surface-box)]">

    <ol class="flex items-center gap-2">

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
                <li class="text-[var(--color-text)] font-medium">
                    {{ $item['label'] }}
                </li>
            @endif
        @endforeach

    </ol>
</nav>

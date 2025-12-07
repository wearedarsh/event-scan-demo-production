@props([
    'labels' => [],
    'counts' => [],
    'totals' => [],
    'currency' => '€',
])

<ul class="space-y-2">
    @foreach($labels as $i => $label)
        <li class="flex justify-between text-sm">
            <span>{{ $label }}</span>

            <span>
                <strong>{{ $counts[$i] ?? 0 }}</strong>
                <small class="text-[var(--color-text-light)]">
                    • {{ $currency }}{{ number_format($totals[$i] ?? 0, 2) }}
                </small>
            </span>
        </li>
    @endforeach
</ul>

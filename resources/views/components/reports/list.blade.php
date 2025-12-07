@props([
    'labels' => [],
    'counts' => [],
    'totals' => [],
    'type' => 'currency',
    'currency' => '€',
])

@php
    $formatValue = function ($value) use ($type, $currency) {
        $value = $value ?? 0;

        return match ($type) {
            'currency'   => $currency . number_format($value, 2),
            'count'      => number_format($value),
            'percentage' => number_format($value, 1) . '%',
            default      => $value,
        };
    };
@endphp

<ul class="space-y-2">
    @foreach($labels as $i => $label)
        <li class="flex justify-between text-sm">
            <span>{{ $label }} ({{ $counts[$i] ?? 0 }})</span>

            <span>
                <strong>{{ $formatValue($totals[$i] ?? 0) }}</strong>
            </span>
        </li>
    @endforeach
</ul>

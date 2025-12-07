@props([
    'stats' => [], // [['label'=>'', 'value'=>'', 'type'=>null], ...]
])

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach($stats as $stat)
        <x-admin.stat-card
            :label="$stat['label']"
            :value="$stat['value']"
            :type="$stat['type'] ?? null"
        />
    @endforeach
</div>

@props([
    'type' => 'error',
])

@if($errors->any())
    <div @class([
        'p-4 rounded-lg',
        'bg-yellow-50 border-l-4 border-yellow-400' => $type === 'error',
        'bg-green-50 border-l-4 border-green-400' => $type === 'success',
        'bg-blue-50 border-l-4 border-blue-400' => $type === 'info',
    ])>
        <p class="text-sm" @class([
            'text-yellow-700' => $type === 'error',
            'text-green-700' => $type === 'success',
            'text-blue-700' => $type === 'info',
        ])>
            {{ $errors->first() }}
        </p>
    </div>
@endif

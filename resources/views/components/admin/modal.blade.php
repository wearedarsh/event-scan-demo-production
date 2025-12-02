@props([
    'show' => false,
    'title' => null,
    'model' => null,
    'subtitle' => null,
    'maxWidth' => 'md',
])

@if($show)
<div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">

    <x-admin.card :hover="false" class="w-full max-w-{{ $maxWidth }} p-6 space-y-6">

        <!-- Header -->
        <div class="flex items-start justify-between">
            <div>
                @if($title)
                    <h2 class="text-lg font-semibold text-[var(--color-text)]">{{ $title }}</h2>
                @endif

                @if($subtitle)
                    <p class="text-sm text-[var(--color-text-light)] mt-1">{{ $subtitle }}</p>
                @endif
            </div>

            <x-admin.icon-button
                icon="heroicon-o-x-mark"
                class="text-[var(--color-text-light)] hover:text-[var(--color-text)]"
                wire:click="$set('{{ $model }}', false)"
            />
        </div>

        <!-- Body -->
        <div class="space-y-4">
            {{ $slot }}
        </div>

        <!-- Footer -->
        @if(isset($footer))
            <div class="flex items-center justify-end gap-3 pt-2">
                {{ $footer }}
            </div>
        @endif

    </x-admin.card>

</div>
@endif

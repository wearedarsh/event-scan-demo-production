@props([
    'submit' => null,   // wire:submit handler (optional)
])

<form
    @if($submit)
        wire:submit.prevent="{{ $submit }}"
    @endif
    class="text-left bg-[var(--color-surface)] rounded-xl shadow-sm border border-[var(--color-border)] p-6 space-y-6"
>
    {{ $slot }}
</form>

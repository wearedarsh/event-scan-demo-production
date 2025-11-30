@props(['message' => null])

@if($message)
    <p class="text-xs bg-[var(--color-danger)]/10 text-[var(--color-danger)] px-3 py-1.5 font-medium rounded-md mt-2">
        {{ $message }}
    </p>
@endif
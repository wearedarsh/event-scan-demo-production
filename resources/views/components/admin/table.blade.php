<div class="relative">

    <!-- Scroll fade (right) -->
    <div class="pointer-events-none absolute top-0 right-0 h-full w-8
                bg-gradient-to-l from-[var(--color-surface)] to-transparent"></div>

    <!-- Horizontal scroll wrapper -->
    <div class="overflow-x-auto">
        {{ $slot }}
    </div>

</div>

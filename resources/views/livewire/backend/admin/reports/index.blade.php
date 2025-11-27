<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Reports'],
    ]" />

    <!-- Page Header -->
    <div class="px-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-[var(--color-text)]">Reports</h1>
            <p class="text-sm text-[var(--color-text-light)] mt-1">
                View all reporting available for this event.
            </p>
        </div>
    </div>

    <!-- Alerts -->
    @if($errors->any())
        <div class="px-6">
            <div class="soft-card p-4 border-l-4 border-[var(--color-warning)]">
                <p class="text-sm text-[var(--color-warning)] font-medium">
                    {{ $errors->first() }}
                </p>
            </div>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="px-6">
            <div class="soft-card p-4 border-l-4 border-[var(--color-success)]">
                <p class="text-sm text-[var(--color-success)] font-medium">
                    {{ session('success') }}
                </p>
            </div>
        </div>
    @endif


    <!-- ================================ -->
    <!-- REPORT CARDS                     -->
    <!-- ================================ -->

    <!-- Feedback & Demographics -->
    <div class="soft-card p-6 mx-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Feedback -->
            <div class="p-5 rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)]">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-chat-bubble-left-right class="h-5 w-5 text-[var(--color-primary)]" />
                    <h5 class="text-base font-semibold text-[var(--color-text)]">Feedback forms</h5>
                </div>

                <p class="text-sm text-[var(--color-text-light)] mt-2">
                    View the feedback form responses for this event.
                </p>

                <a href="{{ route('admin.events.reports.feedback.index', $event->id) }}"
                   class="inline-flex items-center gap-2 mt-4 px-3 py-1.5 rounded-md
                          bg-[var(--color-primary)] text-white text-sm
                          hover:bg-[var(--color-primary-dark)] transition">
                    <x-heroicon-o-arrow-right class="h-4 w-4" />
                    View
                </a>
            </div>

            <!-- Demographics -->
            <div class="p-5 rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)]">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-chart-pie class="h-5 w-5 text-[var(--color-primary)]" />
                    <h5 class="text-base font-semibold text-[var(--color-text)]">Demographics</h5>
                </div>

                <p class="text-sm text-[var(--color-text-light)] mt-2">
                    View the demographics of attendees for this event.
                </p>

                <a href="{{ route('admin.events.reports.demographics.view', $event->id) }}"
                   class="inline-flex items-center gap-2 mt-4 px-3 py-1.5 rounded-md
                          bg-[var(--color-primary)] text-white text-sm
                          hover:bg-[var(--color-primary-dark)] transition">
                    <x-heroicon-o-arrow-right class="h-4 w-4" />
                    View
                </a>
            </div>

        </div>
    </div>



    <!-- Financial & Check-ins -->
    <div class="soft-card p-6 mx-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Financial -->
            <div class="p-5 rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)]">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-banknotes class="h-5 w-5 text-[var(--color-primary)]" />
                    <h5 class="text-base font-semibold text-[var(--color-text)]">Financial</h5>
                </div>

                <p class="text-sm text-[var(--color-text-light)] mt-2">
                    View the financial reporting for this event.
                </p>

                <a href="{{ route('admin.events.reports.financial.view', $event->id) }}"
                   class="inline-flex items-center gap-2 mt-4 px-3 py-1.5 rounded-md
                          bg-[var(--color-primary)] text-white text-sm
                          hover:bg-[var(--color-primary-dark)] transition">
                    <x-heroicon-o-arrow-right class="h-4 w-4" />
                    View
                </a>
            </div>

            <!-- Check-ins -->
            <div class="p-5 rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)]">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-check-circle class="h-5 w-5 text-[var(--color-primary)]" />
                    <h5 class="text-base font-semibold text-[var(--color-text)]">Check ins</h5>
                </div>

                <p class="text-sm text-[var(--color-text-light)] mt-2">
                    View the check-in reporting for this event.
                </p>

                <a href="{{ route('admin.events.reports.checkin.view', $event->id) }}"
                   class="inline-flex items-center gap-2 mt-4 px-3 py-1.5 rounded-md
                          bg-[var(--color-primary)] text-white text-sm
                          hover:bg-[var(--color-primary-dark)] transition">
                    <x-heroicon-o-arrow-right class="h-4 w-4" />
                    View
                </a>
            </div>

        </div>
    </div>


    <!-- Attendees -->
    <div class="soft-card p-6 mx-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Attendees -->
            <div class="p-5 rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)]">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-users class="h-5 w-5 text-[var(--color-primary)]" />
                    <h5 class="text-base font-semibold text-[var(--color-text)]">Attendees</h5>
                </div>

                <p class="text-sm text-[var(--color-text-light)] mt-2">
                    View and export all attendees for this event.
                </p>

                <a href="{{ route('admin.events.reports.attendees.view', $event->id) }}"
                   class="inline-flex items-center gap-2 mt-4 px-3 py-1.5 rounded-md
                          bg-[var(--color-primary)] text-white text-sm
                          hover:bg-[var(--color-primary-dark)] transition">
                    <x-heroicon-o-arrow-right class="h-4 w-4" />
                    View
                </a>
            </div>

        </div>
    </div>

</div>

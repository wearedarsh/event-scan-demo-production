<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title],
    ]" />

    <!-- ======================= -->
    <!-- PAGE HEADER -->
    <!-- ======================= -->
    <div class="px-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <!-- Title + Date -->
        <div>
            <h1 class="text-2xl font-semibold text-[var(--color-text)]">{{ $event->title }}</h1>
            <p class="text-sm text-[var(--color-text-light)] mt-1">
                {{ $event->formatted_start_date }} – {{ $event->formatted_end_date }}
            </p>
        </div>

        <!-- Top Stats -->
        <div class="flex flex-wrap md:flex-nowrap items-center gap-3">

            <!-- Link + Copy -->
            <div class="soft-card px-4 py-2 flex flex-col items-center">
                <span class="text-xs text-[var(--color-text-light)]">Link</span>
                <div class="flex items-center gap-2 mt-1">
                    <button 
                        x-data 
                        @click="copyToClipboard('{{ route('event', ['event' => $event->id]) }}'); $dispatch('copied')"
                        class="text-[var(--color-primary)] hover:underline text-xs font-medium flex items-center gap-1"
                    >
                        <x-heroicon-o-clipboard class="w-4 h-4" />
                        Copy
                    </button>

                    <a href="{{ route('event', ['event' => $event->id]) }}" target="_blank" 
                    class="text-[var(--color-primary)] hover:underline text-xs font-medium flex items-center gap-1">
                        <x-heroicon-o-arrow-top-right-on-square class="w-4 h-4" />
                        View
                    </a>
                </div>
            </div>

            <!-- Status -->
            <div 
            class="soft-card px-4 py-2 flex flex-col items-center cursor-pointer select-none"
            wire:click="toggleActive"
            wire:loading.attr="disabled"
        >
            <span class="text-xs text-[var(--color-text-light)] mb-1">Status</span>

            <div class="flex col items-center gap-2">
                <!-- Toggle Switch -->
                <div class="relative inline-flex items-center">
                    <div class="w-8 h-4 rounded-full transition-colors duration-300
                        {{ $event->active ? 'bg-[var(--color-success)]' : 'bg-gray-300' }}
                    "></div>

                    <div class="absolute left-0 top-0 h-4 w-4 bg-white rounded-full shadow transform transition-transform duration-300
                        {{ $event->active ? 'translate-x-5' : '' }}
                    "></div>
                </div>
                <div class="items-center">
                    <!-- Status Text -->
                    <span class="text-sm font-semibold
                        {{ $event->active ? 'text-[var(--color-success)]' : 'text-[var(--color-danger)]' }}"
                    >
                        {{ $event->active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        </div>


            <!-- Attendees -->
            <div class="soft-card px-4 py-2 flex flex-col items-center">
                <span class="text-xs text-[var(--color-text-light)]">Attendees</span>
                <span class="text-sm font-semibold">{{ $event->attendees->count() }}</span>
            </div>

            <!-- Unpaid -->
            <div class="soft-card px-4 py-2 flex flex-col items-center">
                <span class="text-xs text-[var(--color-text-light)]">Unpaid</span>
                <span class="text-sm font-semibold text-[var(--color-warning)]">
                    {{ $event->registrations->count() }}
                </span>
            </div>
        </div>
    </div>



    <!-- ALERTS -->
    @if($errors->any())
        <div class="px-6">
            <div class="soft-card p-4 border-l-4 border-[var(--color-warning)]">
                <p class="text-sm text-[var(--color-warning)]">{{ $errors->first() }}</p>
            </div>
        </div>
    @endif

    @if(session()->has('success'))
        <div class="px-6">
            <div class="soft-card p-4 border-l-4 border-[var(--color-success)]">
                <p class="text-sm text-[var(--color-success)]">{{ session('success') }}</p>
            </div>
        </div>
    @endif






    <!-- ============================================================= -->
    <!--                       GENERAL SETTINGS                        -->
    <!-- ============================================================= -->
    <div class="px-6 space-y-4">

        <x-admin.section-title title="Settings" />

        <div class="soft-card p-5 transition hover:shadow-md hover:-translate-y-0.5 ">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-medium">General Settings</h3>
                    <p class="text-sm text-[var(--color-text-light)]">
                        Core event details such as title, dates, visibility, and pricing.
                    </p>
                </div>

                <x-link-arrow href="{{ route('admin.events.edit', $event->id) }}">
                    Edit settings
                </x-link-arrow>
            </div>
        </div>




        <!-- ============================================================= -->
        <!--                       PRIMARY ACTION BLOCKS                   -->
        <!-- ============================================================= -->

        <x-admin.section-title title="Primary actions" />

        <!-- Row: 3 columns -->
        <div class="grid md:grid-cols-2 gap-6">

            <!-- PEOPLE -->
            <div class="soft-card p-5 hover:shadow-md hover:-translate-y-0.5 ">
                <h3 class="font-medium mb-2">People</h3>
                <p class="text-sm text-[var(--color-text-light)] mb-4">
                    Manage attendees, registrations, and personnel.
                </p>

                <x-link-arrow href="{{ route('admin.events.attendees.index', $event->id) }}">
                    Attendees
                </x-link-arrow><br>

                <x-link-arrow href="{{ route('admin.events.registrations.index', $event->id) }}">
                    Registrations
                </x-link-arrow><br>

                <x-link-arrow href="{{ route('admin.events.personnel.index', $event->id) }}">
                    Personnel
                </x-link-arrow>
            </div>

             <!-- Content -->
            <div class="soft-card p-5 hover:shadow-md hover:-translate-y-0.5 ">
                <h3 class="font-medium mb-2">Content</h3>
                <p class="text-sm text-[var(--color-text-light)] mb-4">
                    Manage sessions, tickets, and website content.
                </p>

                <x-link-arrow href="{{ route('admin.events.event-sessions.index', $event->id) }}">
                    Manage sessions
                </x-link-arrow><br>

                <x-link-arrow href="{{ route('admin.events.tickets.index', $event->id) }}">
                    Manage tickets
                </x-link-arrow><br>

                <x-link-arrow href="{{ route('admin.events.content.index', $event->id) }}">
                    Manage website content
                </x-link-arrow>
            </div>




        </div>




        <!-- ============================================================= -->
        <!--                            BADGES                             -->
        <!-- ============================================================= -->
        <div class="soft-card p-5 hover:shadow-md hover:-translate-y-0.5 ">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-medium">Badges</h3>
                    <p class="text-sm text-[var(--color-text-light)]">
                        Print-ready badges and blank badge templates.
                    </p>
                </div>

                <div class="flex gap-4">
                    <x-link-arrow href="{{ route('admin.events.attendees.badges.export', $event->id) }}">
                        Print badges
                    </x-link-arrow>

                    <x-link-arrow href="{{ route('admin.events.attendees.blank-badge.export', $event->id) }}">
                        Blank badge
                    </x-link-arrow>
                </div>
            </div>
        </div>




        <!-- ============================================================= -->
        <!--                          EVENT CONTENT                        -->
        <!-- ============================================================= -->

        <x-admin.section-title title="Event content" />

        <div class="grid md:grid-cols-3 gap-6">

            <!-- COMMUNICATION -->
            <div class="soft-card p-5 hover:shadow-md hover:-translate-y-0.5 ">
                <h3 class="font-medium mb-2">Communication</h3>
                <p class="text-sm text-[var(--color-text-light)] mb-4">
                    Send targeted email messages to attendees or registrants.
                </p>

                <x-link-arrow href="{{ route('admin.events.emails.send-email', ['event' => $event->id, 'audience' => 'attendees_paid']) }}">
                    Email paid attendees
                </x-link-arrow>

                <div class="mt-1">
                    <x-link-arrow href="{{ route('admin.events.emails.send-email', ['event' => $event->id, 'audience' => 'registrations_unpaid']) }}">
                        Email unpaid registrations
                    </x-link-arrow>
                </div>
            </div>

            <!-- DOWNLOADS -->
            <div class="soft-card p-5 hover:shadow-md hover:-translate-y-0.5 ">
                <h3 class="font-medium mb-2">Downloads</h3>
                <p class="text-sm text-[var(--color-text-light)] mb-4">
                    Export attendee requirements and payment information.
                </p>

                <x-link-arrow href="#" wire:click.prevent="exportAttendeeSpecialRequirements">
                    Attendee requirements XLSX
                </x-link-arrow>

                <div class="mt-1">
                    <x-link-arrow href="{{ route('admin.events.reports.payments.export', $event->id) }}">
                        Payment data XLSX
                    </x-link-arrow>
                </div>
            </div>


            <!-- Feedback & Analytics -->
            <div class="soft-card p-5 hover:shadow-md hover:-translate-y-0.5 ">
                <h3 class="font-medium mb-2">Feedback & Analytics</h3>
                <p class="text-sm text-[var(--color-text-light)] mb-4">
                    Manage feedback forms and access reporting tools.
                </p>

                <x-link-arrow href="{{ route('admin.events.feedback-form.index', $event->id) }}">
                    Manage feedback
                </x-link-arrow>

                <div class="mt-1">
                    <x-link-arrow href="{{ route('admin.events.reports.index', $event->id) }}">
                        View reports
                    </x-link-arrow>
                </div>
            </div>
            


        </div>




        <!-- ============================================================= -->
        <!--                           CHECK-IN APP                        -->
        <!-- ============================================================= -->
        <div class="soft-card p-5 hover:shadow-md hover:-translate-y-0.5 ">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-medium">Check-In App</h3>
                    <p class="text-sm text-[var(--color-text-light)]">
                        Set up your mobile app and manage manual check-ins.
                    </p>
                </div>

                <div class="flex gap-4">

                    <x-link-arrow href="{{ route('admin.app.index') }}">
                        Install app
                    </x-link-arrow>

                    <x-link-arrow href="{{ route('admin.events.manual-check-in.groups', $event->id) }}">
                        Manual guestlist
                    </x-link-arrow>

                </div>
            </div>
        </div>

    </div>

</div>

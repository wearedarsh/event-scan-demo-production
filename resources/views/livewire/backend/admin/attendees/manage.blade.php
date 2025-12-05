<div class="space-y-6">

    <!-- Breadcrumb -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Attendees', 'href' => route('admin.events.attendees.index', $event->id)],
        ['label' => $attendee->title . ' ' . $attendee->last_name],
    ]" />

    <!-- Header -->
    <x-admin.page-header
        title="{{ $attendee->title }} {{ $attendee->last_name }}"
        subtitle="Attendee overview for {{ $event->title }}">
        <!-- Summary Tiles -->
        <div class="flex items-center gap-3">

            <!-- Payment Status -->
            @php $isPaid = ! empty($attendee->formatted_paid_date); @endphp
            <x-admin.stat-card label="Status">
                <span class="text-sm font-semibold {{ $isPaid ? 'text-[var(--color-success)]' : 'text-[var(--color-warning)]' }}">
                    {{ $isPaid ? 'Paid' : 'Unpaid' }}
                </span>
            </x-admin.stat-card>

            <!-- Group -->
            <x-admin.stat-card label="Group">
                <span class="text-sm font-semibold">
                    {{ $attendee->attendeeGroup->title ?? '—' }}
                </span>
            </x-admin.stat-card>

            <!-- Tickets -->
            <x-admin.stat-card label="Tickets">
                <span class="text-sm font-semibold">
                    {{ $attendee->registrationTickets->sum('quantity') }}
                </span>
            </x-admin.stat-card>

        </div>
    </x-admin.page-header>

    <!-- Alerts -->
    @if($errors->any())
    <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if(session()->has('success'))
    <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- Primary tools -->
    <div class="py-4 px-6">
        <x-admin.section-title title="Primary tools" />

        <div class="grid md:grid-cols-3 gap-6">

            <!-- Attendee tools -->
            <x-admin.tile-card
                title="Attendee tools"
                description="Manage attendee data and details.">
                <x-link-arrow
                    href="{{ route('admin.events.attendees.edit', [$event->id, $attendee->id]) }}">
                    Edit attendee
                </x-link-arrow>
            </x-admin.tile-card>


            <!-- Communication -->
            <x-admin.tile-card
                title="Communication"
                description="Send emails or manage payment updates.">
                <x-link-arrow href="#" wire:click.prevent="sendWelcome">
                    Send welcome email
                </x-link-arrow>

                <x-link-arrow class="mt-1" href="#" wire:click.prevent="sendReceipt">
                    Send receipt email
                </x-link-arrow>

                @if($attendee->eventPaymentMethod->payment_method === 'bank_transfer')
                <x-link-arrow
                    class="mt-1"
                    href="#"
                    wire:click.prevent="sendBankTransferInfo">
                    Send bank transfer details
                </x-link-arrow>

                <x-link-arrow
                    class="mt-1"
                    href="#"
                    wire:click.prevent="openMarkPaidModal">
                    Mark as paid
                </x-link-arrow>
                @endif
            </x-admin.tile-card>


            <!-- Badges & Labels -->
            <x-admin.tile-card
                title="Badges & labels"
                description="Export digital badges or Avery labels.">
                <x-link-arrow
                    wire.click.prevent="downloadSingleBadge"
                    href="#">
                    Download digital badge
                </x-link-arrow>

                <x-link-arrow
                    class="mt-1"
                    href="#"
                    wire:click.prevent="openLabelModal">
                    Download Avery label
                </x-link-arrow>
            </x-admin.tile-card>

        </div>
    </div>


    <!-- Attendee details -->
    <div class="px-6 space-y-4">

        <x-admin.section-title title="Attendee details" />

        <div class="grid md:grid-cols-2 gap-6">

            <!-- Personal details -->
            <x-admin.tile-card
                title="Personal details"
                description="Core attendee contact and address information.">

                @if($this->roleKey === 'developer')
                <p class="text-sm">
                    <span class="font-semibold">ID:</span> {{ $attendee->id }}
                </p>
                @endif

                <p class="text-sm">
                    <span class="font-semibold">Name:</span>
                    {{ $attendee->title }} {{ $attendee->first_name }} {{ $attendee->last_name }}
                </p>

                <p class="text-sm">
                    <span class="font-semibold">Email:</span>
                    <a href="mailto:{{ $attendee->user->email }}"
                        class="underline-offset-2 hover:underline">
                        {{ $attendee->user->email }}
                    </a>
                </p>

                <p class="text-sm">
                    <span class="font-semibold">Mobile:</span>
                    {{ $attendee->mobile_country_code }}{{ $attendee->mobile_number }}
                </p>

                <p class="text-sm">
                    <span class="font-semibold">Address line 1:</span>
                    {{ $attendee->address_line_one }}
                </p>

                <p class="text-sm">
                    <span class="font-semibold">Town:</span> {{ $attendee->town }}
                </p>

                <p class="text-sm">
                    <span class="font-semibold">Country:</span> {{ $attendee->country->name }}
                </p>

                <p class="text-sm">
                    <span class="font-semibold">Postcode:</span> {{ $attendee->postcode }}
                </p>

            </x-admin.tile-card>


            <!-- Professional + actions -->
            <x-admin.tile-card
                title="Professional details"
                description="Work-related information and attendee type.">

                <p class="text-sm">
                    <span class="font-semibold">Position:</span>
                    {{ $attendee->currently_held_position }}
                </p>

                <p class="text-sm">
                    <span class="font-semibold">Profession:</span>
                    @if($attendee->AttendeeType->name !== 'Other')
                    {{ $attendee->AttendeeType->name }}
                    @else
                    {{ $attendee->attendee_type_other }}
                    @endif
                </p>

                <!-- Actions -->
                <div class="mt-4 space-y-2">

                    <x-admin.outline-btn-icon
                        :href="route('admin.events.attendees.edit', [$event->id, $attendee->id])"
                        icon="heroicon-o-pencil-square">
                        Edit attendee
                    </x-admin.outline-btn-icon>

                    <x-admin.outline-btn-icon
                        wire:click.prevent="sendWelcome"
                        icon="heroicon-o-envelope">
                        Send welcome email
                    </x-admin.outline-btn-icon>

                </div>

            </x-admin.tile-card>

        </div>

    </div>




    <!-- Email marketing & account -->
    <div class="px-6 space-y-4">

        <x-admin.section-title title="Email marketing & account" />

        <div class="grid md:grid-cols-2 gap-6">

            <!-- Marketing -->
            <x-admin.tile-card
                title="Email marketing"
                description="Manage marketing preferences and event-specific opt-ins.">

                <p class="text-sm">
                    <span class="font-semibold">General marketing opt-in:</span>
                    <span class="text-[var(--color-text-light)]">
                        {{ $attendee->user->email_marketing_opt_in ? 'Opted in' : 'Opted out' }}
                    </span>
                </p>

                <x-link-arrow
                    href="#"
                    wire:click.prevent="updateEmailOptIn"
                    wire:confirm="@if($attendee->user->email_marketing_opt_in) Are you sure you want to opt out? @else Are you sure you want to opt in? @endif"
                    class="mt-1">
                    @if($attendee->user->email_marketing_opt_in)
                    Opt out user
                    @else
                    Opt in user
                    @endif
                </x-link-arrow>

                <!-- Event-specific opt-ins -->
                <div class="pt-4 space-y-3">
                    @foreach($attendee->optInResponses as $opt)
                    <div class="text-sm">
                        <p class="font-medium">{{ $opt->eventOptInCheck->friendly_name }}</p>
                        <p class="text-[var(--color-text-light)]">
                            {{ $opt->value ? 'Opted in' : 'Opted out' }}
                        </p>
                    </div>
                    @endforeach
                </div>

            </x-admin.tile-card>


            <!-- Account -->
            <x-admin.tile-card
                title="Account"
                description="Your attendee’s login and authentication details.">

                <div class="text-sm space-y-3">

                    <div>
                        <p class="font-medium">Account email</p>
                        <p class="text-[var(--color-text-light)]">
                            {{ $attendee->user->email }}
                        </p>
                    </div>

                    <div>
                        <p class="font-medium">Password</p>
                        <p class="text-[var(--color-text-light)] inline-flex items-center gap-1">
                            <x-heroicon-o-lock-closed class="w-4 h-4" />
                            Stored securely (encrypted).
                        </p>
                    </div>

                </div>

            </x-admin.tile-card>

        </div>
    </div>



    <!-- Registration & payment -->
    <div class="px-6 space-y-4">

        <x-admin.section-title title="Registration & payment" />

        <!-- Grid: Overview + Breakdown -->
        <div class="grid md:grid-cols-2 gap-6">

            <!-- Overview tile -->
            <x-admin.tile-card
                title="Payment overview"
                description="Summary of payment method, status and totals.">

                <p class="text-sm">
                    <span class="font-semibold">Payment method:</span>
                    <span class="text-[var(--color-text-light)]">
                        {{ $attendee->eventPaymentMethod->name }}
                    </span>
                </p>

                <p class="text-sm">
                    <span class="font-semibold">Paid at:</span>
                    <span class="text-[var(--color-text-light)]">
                        {{ $attendee->formatted_paid_date ?? 'Not paid yet' }}
                    </span>
                </p>

                <p class="text-sm">
                    <span class="font-semibold">Total amount:</span>
                    {{ $currency_symbol }}{{ $attendee->registration_total }}
                </p>

                @if($attendee->eventPaymentMethod->payment_method === 'stripe' && $attendee->payment_intent_id)
                <x-link-arrow
                    class="mt-2"
                    href="{{ config('services.stripe.payment_link') }}{{ $attendee->payment_intent_id }}"
                    target="_blank">
                    View on Stripe
                </x-link-arrow>
                @endif

            </x-admin.tile-card>


            <!-- Breakdown tile -->
            <x-admin.tile-card
                title="Price breakdown"
                description="Tickets purchased and full itemised totals.">

                <table class="w-full text-sm border-t border-[var(--color-border)]">
                    <thead>
                        <tr class="text-xs text-[var(--color-primary)] border-b border-[var(--color-border)]">
                            <th class="py-2 text-left">Description</th>
                            <th class="py-2 text-right">Amount</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($attendee->registrationTickets as $ticket)
                        <tr class="border-b border-[var(--color-border)]">
                            <td class="py-2">
                                {{ $ticket->quantity }} × {{ $ticket->ticket->name }} (inc. VAT)
                            </td>
                            <td class="py-2 text-right">
                                {{ $currency_symbol }}{{ number_format($ticket->price_at_purchase * $ticket->quantity, 2) }}
                            </td>
                        </tr>
                        @endforeach

                        <tr>
                            <td class="py-3 font-semibold text-right">Total</td>
                            <td class="py-3 font-semibold text-right">
                                {{ $currency_symbol }}{{ number_format(
                                $attendee->registrationTickets->sum(
                                    fn($t) => $t->price_at_purchase * $t->quantity
                                ), 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>

            </x-admin.tile-card>

        </div>


        <!-- Uploads -->
        @if($attendee->registrationDocuments->isNotEmpty())
        <x-admin.tile-card
            title="Uploaded documents"
            description="Files provided during registration."
            class="mt-4">

            <div class="space-y-4 text-sm">

                @foreach($attendee->registrationDocuments as $doc)
                <div>
                    <p class="mb-1">
                        Upload for
                        <span class="font-semibold">{{ $doc->ticket->name }}</span>
                    </p>

                    <x-admin.outline-btn-icon
                        :href="route('admin.registration-documents.download', $doc)"
                        icon="heroicon-o-arrow-down-tray">
                        View upload
                    </x-admin.outline-btn-icon>
                </div>
                @endforeach

            </div>

        </x-admin.tile-card>
        @endif


        <!-- Payment actions -->
        <x-admin.tile-card
            title="Payment actions"
            description="Send payment emails or update attendee payment status."
            class="mt-4">

            <div class="flex flex-wrap gap-3">

                <x-admin.outline-btn-icon
                    icon="heroicon-o-check-circle"
                    wire:click.prevent="openMarkPaidModal">
                    Mark as paid
                </x-admin.outline-btn-icon>

                <x-admin.outline-btn-icon
                    icon="heroicon-o-envelope"
                    wire:confirm="Send bank transfer details?"
                    wire:click.prevent="sendBankTransferInfo">
                    Send bank transfer details
                </x-admin.outline-btn-icon>

                <x-admin.outline-btn-icon
                    icon="heroicon-o-envelope-open"
                    wire:confirm="Send receipt email?"
                    wire:click.prevent="sendReceipt">
                    Send receipt
                </x-admin.outline-btn-icon>

            </div>

        </x-admin.tile-card>

    </div>




    <!-- Email log -->
    <div class="px-6 space-y-4">

        <x-admin.section-title title="Received email log" />

        <x-admin.card hover="false" class="p-6 space-y-4">

            <x-admin.table>
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-xs text-[var(--color-text-light)] uppercase border-b border-[var(--color-border)]">
                            <th class="px-4 py-2">Type</th>
                            <th class="px-4 py-2">Subject</th>
                            <th class="px-4 py-2">Sent</th>
                            <th class="px-4 py-2 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($email_sends as $email_send)
                            <tr class="border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">

                                <td class="px-4 py-3">{{ $email_send->broadcast->type }}</td>

                                <td class="px-4 py-3">{{ $email_send->subject }}</td>

                                <td class="px-4 py-3">{{ $email_send->sent_at->diffForHumans() }}</td>

                                <td class="px-4 py-3 text-right">
                                    <div class="inline-flex gap-2">
                                        <x-admin.table-action-button
                                            type="link"
                                            :href="route('admin.emails.broadcasts.view', [
                                                'event' => $event->id,
                                                'email_send' => $email_send->id
                                            ])"
                                            icon="eye"
                                            label="View" />

                                        <x-admin.table-action-button
                                            type="button"
                                            wireClick="resendEmail({{ $email_send->id }})"
                                            confirm="Resend this email to {{ $email_send->email_address }}?"
                                            icon="arrow-path"
                                            label="Resend" />
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"
                                    class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                    No email logs found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </x-admin.table>

            <!-- Pagination -->
            <x-admin.pagination :paginator="$email_sends" />

        </x-admin.card>

    </div>

    <!-- Check-ins -->
    <div class="px-6 space-y-4">

        <x-admin.section-title title="Check-ins" />

        <x-admin.card hover="false" class="p-6 space-y-4">

            <x-admin.table>
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-xs text-[var(--color-text-light)] uppercase border-b border-[var(--color-border)]">
                            <th class="px-4 py-2">Session</th>
                            <th class="px-4 py-2">Checked in at</th>
                            <th class="px-4 py-2">Checked in by</th>
                            <th class="px-4 py-2">Route</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($check_ins as $ci)

                            <tr class="border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">

                                <td class="px-4 py-3">{{ $ci->session?->title ?? '—' }}</td>

                                <td class="px-4 py-3">
                                    @if($ci->checked_in_at)
                                        {{ $ci->checked_in_at->setTimezone('Europe/London')->format('d/m/Y H:i') }}
                                    @else
                                        —
                                    @endif
                                </td>

                                <td class="px-4 py-3">
                                    {{ $ci->checkedInBy?->first_name }} {{ $ci->checkedInBy?->last_name }}
                                </td>

                                <td class="px-4 py-3">{{ $ci->checked_in_route ?? '—' }}</td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="4"
                                    class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                    No check-ins found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </x-admin.table>

            <!-- Pagination -->
            <x-admin.pagination :paginator="$check_ins" />

        </x-admin.card>

    </div>

    <!-- Activity log -->
    <div class="px-6 space-y-4">
        <x-admin.section-title title="Activity log" />

        <x-admin.card hover="false" class="p-6 space-y-4">

            <x-admin.table>
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-xs text-[var(--color-text-light)] uppercase border-b border-[var(--color-border)]">
                            <th class="px-4 py-2">Description</th>
                            <th class="px-4 py-2">Occurred</th>
                            <th class="px-4 py-2">IP</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($activity_logs as $log)
                        <tr class="border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">
                            <td class="px-4 py-3">{{ $log->description }}</td>
                            <td class="px-4 py-3">{{ $log->created_at->diffForHumans() }}</td>
                            <td class="px-4 py-3">{{ $log->properties['ip'] ?? '—' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                No activity found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </x-admin.table>

            <x-admin.pagination :paginator="$activity_logs" />

        </x-admin.card>
    </div>

    <!-- Modals -->
    @include('livewire.backend.admin.attendees.modals.label-modal')
    @include('livewire.backend.admin.attendees.modals.mark-paid-modal')

</div>
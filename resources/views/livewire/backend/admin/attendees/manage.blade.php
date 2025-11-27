<div class="space-y-6">

    <!-- ============================================================= -->
    <!-- BREADCRUMBS -->
    <!-- ============================================================= -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Attendees', 'href' => route('admin.events.attendees.index', $event->id)],
        ['label' => $attendee->title . ' ' . $attendee->last_name],
    ]" />


    <!-- ============================================================= -->
    <!-- PAGE HEADER -->
    <!-- ============================================================= -->
    <div class="px-6 flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-semibold text-[var(--color-text)]">
                {{ $attendee->title }} {{ $attendee->last_name }}
            </h1>
            <p class="text-sm text-[var(--color-text-light)] mt-1">
                Attendee overview for {{ $event->title }}
            </p>
        </div>

        <!-- Summary Tiles -->
        <div class="flex items-center gap-3">

            <!-- Status -->
            @php
            $isPaid = ! empty($attendee->formatted_paid_date);
            @endphp
            <div class="soft-card px-4 py-2 flex flex-col items-center">
                <span class="text-xs text-[var(--color-text-light)]">Status</span>
                <span class="text-sm font-semibold {{ $isPaid ? 'text-[var(--color-success)]' : 'text-[var(--color-warning)]' }}">
                    {{ $isPaid ? 'Paid' : 'Unpaid' }}
                </span>
            </div>

            <!-- Group -->
            <div class="soft-card px-4 py-2 flex flex-col items-center">
                <span class="text-xs text-[var(--color-text-light)]">Group</span>
                <span class="text-sm font-semibold">
                    {{ $attendee->attendeeGroup->title ?? '—' }}
                </span>
            </div>

            <!-- Ticket Count -->
            <div class="soft-card px-4 py-2 flex flex-col items-center">
                <span class="text-xs text-[var(--color-text-light)]">Tickets</span>
                <span class="text-sm font-semibold">
                    {{ $attendee->registrationTickets->sum('quantity') }}
                </span>
            </div>

        </div>
    </div>



    <!-- ============================================================= -->
    <!-- ALERTS -->
    <!-- ============================================================= -->
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
    <!-- QUICK TOOLS STRIP -->
    <!-- ============================================================= -->
    <div class="px-6 grid md:grid-cols-3 gap-6">

        <!-- ============================================================= -->
        <!-- COLUMN 1: ATTENDEE TOOLS -->
        <!-- ============================================================= -->
        <div class="soft-card p-5 hover:shadow-md hover:-translate-y-0.5 transition">
            <h3 class="font-medium mb-2">Attendee tools</h3>
            <p class="text-sm text-[var(--color-text-light)] mb-4">
                Manage attendee data and details.
            </p>

            <x-link-arrow
                href="{{ route('admin.events.attendees.edit', [$event->id, $attendee->id]) }}">
                Edit attendee
            </x-link-arrow>
        </div>



        <!-- ============================================================= -->
        <!-- COLUMN 2: COMMUNICATION -->
        <!-- ============================================================= -->
        <div class="soft-card p-5 hover:shadow-md hover:-translate-y-0.5 transition space-y-2">
            <h3 class="font-medium mb-2">Communication</h3>
            <p class="text-sm text-[var(--color-text-light)] mb-4">
                Send event-related emails or manage payment updates.
            </p>

            <x-link-arrow href="#" wire:click.prevent="sendWelcome">
                Send welcome email
            </x-link-arrow>

            <x-link-arrow href="#" wire:click.prevent="sendReceipt">
                Send receipt email
            </x-link-arrow>

            @if($attendee->eventPaymentMethod->payment_method === 'bank_transfer')
            <x-link-arrow href="#"
                wire:click.prevent="sendBankTransferInfo"
                wire:confirm="Send bank transfer details to this attendee?">
                Send bank transfer details
            </x-link-arrow>

            <x-link-arrow href="#" wire:click.prevent="openMarkPaidModal">
                Mark as paid
            </x-link-arrow>
            @endif
        </div>



        <!-- ============================================================= -->
        <!-- COLUMN 3: BADGES & LABELS -->
        <!-- ============================================================= -->
        <div class="soft-card p-5 hover:shadow-md hover:-translate-y-0.5 transition">
            <h3 class="font-medium mb-2">Badges & labels</h3>
            <p class="text-sm text-[var(--color-text-light)] mb-4">
                Export digital badges or print Avery labels.
            </p>

            <x-link-arrow
                href="{{ route('admin.events.attendees.single-badge.export', [$event->id, $attendee->id]) }}">
                Download digital badge
            </x-link-arrow>

            <x-link-arrow
                href="#"
                wire:click.prevent="openLabelModal">
                Download Avery label
            </x-link-arrow>
        </div>

    </div>


    <!-- ============================================================= -->
    <!-- FEEDBACK & CME OVERVIEW -->
    <!-- ============================================================= -->
    <div class="px-6">

        <div class="soft-card p-6 space-y-6">

            <x-admin.section-title title="Feedback & CME Overview" />


            @php
            $activeForms = $event->feedbackFormsActive ?? collect();
            $completedForm = null;
            foreach ($activeForms as $form) {
            $sub = $attendee->feedbackFormSubmissions
            ->firstWhere('feedback_form_id', $form->id);
            if ($sub && $sub->status === 'complete') {
            $completedForm = $sub;
            break;
            }
            }

            $isComplete = !is_null($completedForm);

            $firstActiveForm = $activeForms->first();

            $cmePoints = $attendee->total_cme_points ?? 0;
            @endphp


            <!-- GRID -->
            <div class="grid md:grid-cols-3 gap-6">

                <!-- STATUS -->
                <div class="soft-card p-5 text-sm">
                    <p class="font-medium mb-1">Feedback form status</p>

                    @if($activeForms->count() === 0)
                    <p class="text-[var(--color-text-light)]">No feedback forms</p>
                    @elseif($isComplete)
                    <p class="text-[var(--color-success)] font-semibold">Completed</p>
                    <p class="text-xs text-[var(--color-text-light)] mt-1">
                        Submitted {{ $completedForm->updated_at->diffForHumans() }}
                    </p>
                    @else
                    <p class="text-[var(--color-warning)] font-semibold">Incomplete</p>
                    @if($firstActiveForm)
                    <x-link-arrow
                        class="mt-2 block"
                        href="{{ route('admin.feedback.open-form', [
                                'event' => $event->id,
                                'attendee' => $attendee->id,
                                'feedback_form' => $firstActiveForm->id
                            ]) }}">
                        Open feedback form
                    </x-link-arrow>
                    @endif
                    @endif
                </div>


                <!-- CME POINTS -->
                <div class="soft-card p-5 text-sm">
                    <p class="font-medium mb-1">CME points accrued</p>

                    <p class="text-[var(--color-primary)] font-semibold text-lg">
                        {{ $cmePoints }}
                    </p>

                    <p class="text-xs text-[var(--color-text-light)] mt-1">
                        Based on check-ins recorded for this attendee.
                    </p>
                </div>


                <!-- CERTIFICATE -->
                <div class="soft-card p-5 text-sm">
                    <p class="font-medium mb-1">Certificate of attendance</p>

                    @if($isComplete)
                    <p class="text-[var(--color-success)] font-semibold mb-3">
                        Eligible to download
                    </p>
                    @else
                    <p class="text-[var(--color-warning)] font-semibold mb-3">
                        Feedback incomplete
                    </p>
                    @endif

                    <a href="{{ route('customer.event-completed-certificate.download', $attendee->id) }}"
                        class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                          bg-[var(--color-surface)] px-3 py-1.5 text-sm font-medium
                          {{ $isComplete ? 'text-[var(--color-primary)] hover:bg-[var(--color-primary)] hover:text-white' : 'text-[var(--color-text-light)] opacity-70' }}
                          transition-colors">

                        <x-heroicon-o-document-arrow-down class="w-4 h-4 mr-1.5" />
                        Download certificate
                    </a>

                    @unless($isComplete)
                    <p class="text-xs text-[var(--color-text-light)] mt-2">
                        Feedback not complete — manual download allowed.
                    </p>
                    @endunless
                </div>

            </div>

        </div>

    </div>

    <!-- ============================================================= -->
    <!-- PERSONAL + PROFESSIONAL DETAILS -->
    <!-- ============================================================= -->
    <div class="px-6 space-y-4">
        <x-admin.section-title title="Attendee details" />
        <div class="soft-card p-6 space-y-6">
            <div class="grid md:grid-cols-2 gap-8 text-sm">

                <!-- PERSONAL -->
                <div class="space-y-2">
                    <h3 class="font-medium mb-1">Personal details</h3>

                    @if($this->roleKey === 'developer')
                    <p><span class="font-semibold">ID:</span> {{ $attendee->id }}</p>
                    @endif

                    <p><span class="font-semibold">Name:</span> {{ $attendee->title }} {{ $attendee->first_name }} {{ $attendee->last_name }}</p>

                    <p>
                        <span class="font-semibold">Email:</span>
                        <a href="mailto:{{ $attendee->user->email }}" class="underline-offset-2 hover:underline">
                            {{ $attendee->user->email }}
                        </a>
                    </p>

                    <p><span class="font-semibold">Mobile:</span> {{ $attendee->mobile_country_code }}{{ $attendee->mobile_number }}</p>
                    <p><span class="font-semibold">Address line 1:</span> {{ $attendee->address_line_one }}</p>
                    <p><span class="font-semibold">Town:</span> {{ $attendee->town }}</p>
                    <p><span class="font-semibold">Country:</span> {{ $attendee->country->name }}</p>
                    <p><span class="font-semibold">Postcode:</span> {{ $attendee->postcode }}</p>
                </div>

                <!-- PROFESSIONAL -->
                <div class="space-y-2">
                    <h3 class="font-medium mb-1">Professional details</h3>

                    <p><span class="font-semibold">Position:</span> {{ $attendee->currently_held_position }}</p>

                    <p>
                        <span class="font-semibold">Profession:</span>
                        @if($attendee->AttendeeType->name !== 'Other')
                        {{ $attendee->AttendeeType->name }}
                        @else
                        {{ $attendee->attendee_type_other }}
                        @endif
                    </p>

                    <div class="mt-4">
                        <h4 class="font-medium mb-1">Attendee actions</h4>

                        <a href="{{ route('admin.events.attendees.edit', [$event->id, $attendee->id]) }}"
                            class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                                  bg-[var(--color-surface)] px-3 py-1.5 text-sm font-medium text-[var(--color-primary)]
                                  hover:bg-[var(--color-primary)] hover:text-white transition-colors">
                            <x-heroicon-o-pencil-square class="w-4 h-4 mr-1.5" />
                            Edit attendee
                        </a>

                        <div class="mt-2">
                            <button
                                wire:confirm="Are you sure you want to send a welcome email?"
                                wire:click.prevent="sendWelcome"
                                class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                                       bg-[var(--color-surface)] px-3 py-1.5 text-sm font-medium text-[var(--color-primary)]
                                       hover:bg-[var(--color-primary)] hover:text-white transition-colors">
                                <x-heroicon-o-envelope class="w-4 h-4 mr-1.5" />
                                Send welcome email
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>



    <!-- ============================================================= -->
    <!-- MARKETING + ACCOUNT -->
    <!-- ============================================================= -->
    <div class="px-6 space-y-4">

        <x-admin.section-title title="Email marketing & account" />

        <div class="grid md:grid-cols-2 gap-6">

            <!-- MARKETING -->
            <div class="soft-card p-6 space-y-4 text-sm">
                <p class="font-medium">General marketing opt-in</p>
                <p class="text-[var(--color-text-light)]">
                    {{ $attendee->user->email_marketing_opt_in ? 'Opted in' : 'Opted out' }}
                </p>

                <x-link-arrow
                    href="#"
                    wire:click.prevent="updateEmailOptIn"
                    wire:confirm="@if($attendee->user->email_marketing_opt_in) Are you sure you want to opt out? @else Are you sure you want to opt in? @endif">
                    @if($attendee->user->email_marketing_opt_in)
                    Opt out user
                    @else
                    Opt in user
                    @endif
                </x-link-arrow>

                <div class="pt-3 space-y-3">
                    @foreach($attendee->optInResponses as $opt)
                    <div>
                        <p class="font-medium">{{ $opt->eventOptInCheck->friendly_name }}</p>
                        <p class="text-[var(--color-text-light)]">
                            {{ $opt->value ? 'Opted in' : 'Opted out' }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- ACCOUNT -->
            <div class="soft-card p-6 space-y-4 text-sm">
                <p class="font-medium">Account email</p>
                <p>{{ $attendee->user->email }}</p>

                <div>
                    <p class="font-medium">Password</p>
                    <p class="text-[var(--color-text-light)] inline-flex items-center gap-1">
                        <x-heroicon-o-lock-closed class="w-4 h-4" />
                        Encrypted and stored securely.
                    </p>
                </div>
            </div>

        </div>

    </div>




    <!-- ============================================================= -->
    <!-- REGISTRATION & PAYMENT -->
    <!-- ============================================================= -->
    <div class="px-6 space-y-4">
        <x-admin.section-title title="Registration & payment" />
        <div class="soft-card p-6 space-y-6">

            <div class="grid md:grid-cols-2 gap-6 text-sm">

                <!-- OVERVIEW -->
                <div class="space-y-2">

                    <p><span class="font-semibold">Payment method:</span> {{ $attendee->eventPaymentMethod->name }}</p>

                    <p><span class="font-semibold">Paid at:</span> {{ $attendee->formatted_paid_date ?? 'Not paid yet' }}</p>

                    <p><span class="font-semibold">Total amount:</span> {{ $currency_symbol }}{{ $attendee->registration_total }}</p>

                    @if($attendee->eventPaymentMethod->payment_method === 'stripe' && $attendee->payment_intent_id)
                    <p>
                        <a href="{{ config('services.stripe.payment_link') }}{{ $attendee->payment_intent_id }}"
                            target="_blank"
                            class="text-[var(--color-primary)] underline-offset-2 hover:underline">
                            View on Stripe
                        </a>
                    </p>
                    @endif
                </div>

                <!-- BREAKDOWN -->
                <div>
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
                                    {{ $currency_symbol }}{{ number_format($attendee->registrationTickets->sum(fn($t) => $t->price_at_purchase * $t->quantity), 2) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>


            <!-- UPLOADS -->
            @if($attendee->registrationDocuments->isNotEmpty())
            <div class="border-t border-[var(--color-border)] pt-4 mt-2">
                <h3 class="font-medium mb-2">Uploads</h3>

                <div class="space-y-3 text-sm">
                    @foreach($attendee->registrationDocuments as $doc)
                    <div>
                        <p class="mb-1">
                            Upload for <span class="font-semibold">{{ $doc->ticket->name }}</span>
                        </p>

                        <a href="{{ route('admin.registration-documents.download', $doc) }}"
                            class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                                          bg-[var(--color-surface)] px-3 py-1.5 text-sm font-medium text-[var(--color-primary)]
                                          hover:bg-[var(--color-primary)] hover:text-white transition-colors">
                            <x-heroicon-o-arrow-down-tray class="w-4 h-4 mr-1.5" />
                            View upload
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif


            <!-- ACTIONS -->
            <div class="border-t border-[var(--color-border)] pt-4 mt-2 space-y-3">
                <h3 class="font-medium">Payment actions</h3>

                <div class="flex flex-wrap gap-3">

                    <button
                        wire:click.prevent="openMarkPaidModal"
                        class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                               bg-[var(--color-surface)] px-3 py-1.5 text-sm font-medium text-[var(--color-primary)]
                               hover:bg-[var(--color-primary)] hover:text-white transition-colors">
                        <x-heroicon-o-check-circle class="w-4 h-4 mr-1.5" />
                        Mark as paid
                    </button>

                    <button
                        wire:confirm="Send bank transfer details?"
                        wire:click.prevent="sendBankTransferInfo"
                        class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                               bg-[var(--color-surface)] px-3 py-1.5 text-sm font-medium text-[var(--color-primary)]
                               hover:bg-[var(--color-primary)] hover:text-white transition-colors">
                        <x-heroicon-o-envelope class="w-4 h-4 mr-1.5" />
                        Send bank transfer details
                    </button>

                    <button
                        wire:confirm="Send receipt email?"
                        wire:click.prevent="sendReceipt"
                        class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                               bg-[var(--color-surface)] px-3 py-1.5 text-sm font-medium text-[var(--color-primary)]
                               hover:bg-[var(--color-primary)] hover:text-white transition-colors">
                        <x-heroicon-o-envelope-open class="w-4 h-4 mr-1.5" />
                        Send receipt
                    </button>

                </div>
            </div>

        </div>
    </div>



    <!-- ============================================================= -->
    <!-- EMAIL LOG -->
    <!-- ============================================================= -->
    <div class="px-6">
        <div class="soft-card p-6 space-y-4">
            <x-admin.section-title title="Received email log" />

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-[var(--color-surface-hover)] text-xs text-[var(--color-text-light)] border-b border-[var(--color-border)]">
                            <th class="px-4 py-2">Type</th>
                            <th class="px-4 py-2">Subject</th>
                            <th class="px-4 py-2">Sent</th>
                            <th class="px-4 py-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($email_sends as $email_send)
                        <tr class="border-b border-[var(--color-border)]">
                            <td class="px-4 py-3">{{ $email_send->broadcast->type }}</td>
                            <td class="px-4 py-3">{{ $email_send->subject }}</td>
                            <td class="px-4 py-3">{{ $email_send->sent_at->diffForHumans() }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex gap-2">
                                    <x-admin.table-action-button
                                        type="link"
                                        :href="route('admin.emails.broadcasts.view', ['event' => $event->id, 'email_send' => $email_send->id])"
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
                            <td colspan="4" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                No email logs found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>



    <!-- ============================================================= -->
    <!-- CHECK INS -->
    <!-- ============================================================= -->
    <div class="px-6">
        <div class="soft-card p-6 space-y-4">

            <x-admin.section-title title="Check-ins" />

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-[var(--color-surface-hover)] text-xs text-[var(--color-text-light)] border-b border-[var(--color-border)]">
                            <th class="px-4 py-2">Session</th>
                            <th class="px-4 py-2">Checked in at</th>
                            <th class="px-4 py-2">Checked in by</th>
                            <th class="px-4 py-2">Route</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($check_ins as $ci)
                        <tr class="border-b border-[var(--color-border)]">
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
                            <td colspan="4" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                No check-ins found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>


    <!-- ============================================================= -->
    <!-- LABEL PRINTING MODAL -->
    <!-- ============================================================= -->
    @if($showLabelModal)
    <div class="fixed inset-0 z-40 flex items-center justify-center bg-black/50">
        <div class="soft-card p-6 w-full max-w-md space-y-5">

            <!-- Header -->
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-[var(--color-text)]">
                        Download Avery label
                    </h2>
                    <p class="text-sm text-[var(--color-text-light)] mt-1">
                        Choose the label format and sheet position.
                    </p>
                </div>

                <button
                    type="button"
                    wire:click="$set('showLabelModal', false)"
                    class="text-[var(--color-text-light)] hover:text-[var(--color-text)]">
                    ✕
                </button>
            </div>

            <!-- Form -->
            <form
                method="GET"
                action="{{ route('admin.events.attendees.label.export', ['event' => $event->id, 'attendee' => $attendee->id]) }}"
                target="_blank"
                class="space-y-5">

                <!-- Label format -->
                <div>
                    <label class="form-label-custom">Label format</label>
                    <x-admin.select name="mode">
                        <option value="overlay_core">No Header – Avery (75×110 mm)</option>
                        <option value="a6_full">Full – Avery A6 (105×148 mm)</option>
                    </x-admin.select>
                </div>

                <!-- Sheet position pills -->
                <div>
                    <label class="form-label-custom">Sheet position</label>

                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach([1 => 'Top left', 2 => 'Top right', 3 => 'Bottom left', 4 => 'Bottom right'] as $num => $label)
                        <x-admin.filter-pill
                            :active="(string) request('slot', '1') === (string) $num"
                            onclick="document.getElementById('slot_{{ $num }}').checked = true">
                            {{ $num }} — {{ $label }}
                        </x-admin.filter-pill>
                        <input id="slot_{{ $num }}" type="radio" name="slot" value="{{ $num }}" class="hidden" {{ $num === 1 ? 'checked' : '' }}>
                        @endforeach
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4">
                    <button type="button"
                        wire:click="$set('showLabelModal', false)"
                        class="inline-flex items-center rounded-md border border-[var(--color-border)]
                                    bg-[var(--color-surface)] px-3 py-1.5 text-sm font-medium text-[var(--color-text)]
                                    hover:bg-[var(--color-surface-hover)] transition">
                        Cancel
                    </button>

                    <button type="submit"
                        wire:click="$set('showLabelModal', false)"
                        class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                                    bg-[var(--color-surface)] px-3 py-1.5 text-sm font-medium text-[var(--color-primary)]
                                    hover:bg-[var(--color-surface-hover)] transition">
                        <x-heroicon-o-document-arrow-down class="w-4 h-4 mr-1.5" />
                        Download label
                    </button>
                </div>

            </form>

        </div>
    </div>
    @endif



    <!-- ============================================================= -->
    <!-- MARK AS PAID MODAL -->
    <!-- ============================================================= -->
    @if($showMarkPaidModal)
    <div class="fixed inset-0 z-40 flex items-center justify-center bg-black/50">
        <div class="soft-card p-6 w-full max-w-md space-y-4">

            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-lg font-semibold">Confirm payment</h2>
                    <p class="text-sm text-[var(--color-text-light)] mt-1">
                        Enter the date payment was received.
                    </p>
                </div>

                <button
                    wire:click="$set('showMarkPaidModal', false)"
                    class="text-[var(--color-text-light)] hover:text-[var(--color-text)]">
                    ✕
                </button>
            </div>

            @if($errors->any())
            <div class="soft-card p-3 border-l-4 border-[var(--color-warning)]">
                <p class="text-sm text-[var(--color-warning)]">{{ $errors->first() }}</p>
            </div>
            @endif

            <form wire:submit.prevent="confirmMarkAsPaid" class="space-y-4">

                <div>
                    <label class="form-label-custom">Payment date</label>
                    <input type="text" wire:model="payment_date" maxlength="10"
                        placeholder="dd-mm-yyyy" class="input-text" />
                </div>

                <div class="flex items-center justify-end gap-3">

                    <button type="button"
                        wire:click="$set('showMarkPaidModal', false)"
                        class="inline-flex items-center rounded-md border border-[var(--color-border)]
                                       bg-[var(--color-surface)] px-3 py-1.5 text-sm font-medium text-[var(--color-text)]
                                       hover:bg-[var(--color-surface-hover)] transition">
                        Cancel
                    </button>

                    <button type="submit"
                        class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                                       bg-[var(--color-surface)] px-3 py-1.5 text-sm font-medium text-[var(--color-primary)]
                                       hover:bg-[var(--color-primary)] hover:text-white transition">
                        Confirm &amp; mark as paid
                    </button>

                </div>

            </form>
        </div>
    </div>
    @endif

</div>
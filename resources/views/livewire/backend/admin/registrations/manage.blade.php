<div class="space-y-4">

    <!-- Breadcrumb -->
    <x-admin.breadcrumb :items="[
    ['label' => 'Events', 'href' => route('admin.events.index')],
    ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
    ['label' => 'Registrations', 'href' => route('admin.events.registrations.index', $event->id)],
    ['label' => $attendee->title . ' ' . $attendee->last_name],
]" />


    <!-- Page Header -->
    <x-admin.page-header
        title="{{ $attendee->title }} {{ $attendee->last_name }}"
        subtitle="Registration overview for {{ $event->title }}">
        <!-- Summary Tiles -->
        <div class="flex items-center gap-3">

            <!-- Status -->
            @php $isPaid = ! empty($attendee->formatted_paid_date); @endphp
            <x-admin.stat-card label="Status">
                <span class="text-sm font-semibold {{ $isPaid ? 'text-[var(--color-success)]' : 'text-[var(--color-warning)]' }}">
                    {{ $isPaid ? 'Paid' : 'Unpaid' }}
                </span>
            </x-admin.stat-card>

            <!-- Total -->
            <x-admin.stat-card label="Total">
                <span class="text-sm font-semibold">
                    {{ $currency_symbol }}{{ $attendee->registration_total }}
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

    @if(session()->has('receipt'))
    <x-admin.alert type="success" :message="session('receipt')" />
    @endif


    <div class="px-6 space-y-4">

        <x-admin.section-title title="Tools" />

        <div class="grid md:grid-cols-2 gap-6">

            <!-- Payment Tools -->
            <x-admin.tile-card
                title="Payment"
                description="Manage payment status and communication with the registrant.">
                <x-link-arrow
                    href="#"
                    wire:click.prevent="openMarkPaidModal">
                    Mark as paid
                </x-link-arrow><br>

                <x-link-arrow
                    class="mt-1"
                    href="#"
                    wire:confirm="Are you sure you want to send bank transfer details to this registrant?"
                    wire:click.prevent="sendBankTransferInfo">
                    Send bank transfer details
                </x-link-arrow>
            </x-admin.tile-card>


            <!-- Registration Tools -->
            <x-admin.tile-card
                title="Registration"
                description="Manage or modify this registration and view uploaded documents.">
                <x-link-arrow
                    href="{{ route('admin.events.registrations.edit', [$event->id, $attendee->id]) }}">
                    Edit registration
                </x-link-arrow>

                @if($attendee->registrationDocuments->isNotEmpty())
                <x-link-arrow
                    class="mt-1"
                    href="{{ route('admin.registration-documents.download', $attendee->registrationDocuments->first()) }}">
                    View uploads
                </x-link-arrow>
                @endif
            </x-admin.tile-card>

        </div>

    </div>



    <div class="px-6 space-y-4">

        <x-admin.section-title title="Registration details" />

        <div class="grid md:grid-cols-2 gap-6">

            <!-- Personal Details -->
            <x-admin.tile-card
                title="Personal details"
                description="Core registrant contact and address information.">
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
                    <span class="font-semibold">Town:</span>
                    {{ $attendee->town }}
                </p>

                <p class="text-sm">
                    <span class="font-semibold">Country:</span>
                    {{ $attendee->country->name }}
                </p>

                <p class="text-sm">
                    <span class="font-semibold">Postcode:</span>
                    {{ $attendee->postcode }}
                </p>

            </x-admin.tile-card>



            <!-- Professional Details -->
            <x-admin.tile-card
                title="Professional details"
                description="Work-related and attendee type information.">
                <p class="text-sm">
                    <span class="font-semibold">Company:</span>
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

                <!-- Registration actions -->
                <div class="mt-4 space-y-2">
                    <x-admin.outline-btn-icon
                        :href="route('admin.events.registrations.edit', [$event->id, $attendee->id])"
                        icon="heroicon-o-pencil-square">
                        Edit registration
                    </x-admin.outline-btn-icon>
                </div>

            </x-admin.tile-card>

        </div>

    </div>




    <div class="px-6 space-y-4">

        <x-admin.section-title title="Marketing & account" />

        <div class="grid md:grid-cols-2 gap-6">

            <!-- Email marketing -->
            <x-admin.tile-card
                title="Email marketing"
                description="Marketing preferences and event-specific opt-ins.">
                <p class="text-sm">
                    <span class="font-medium">General marketing opt-in:</span>
                    <span class="text-[var(--color-text-light)]">
                        {{ $attendee->user->email_marketing_opt_in ? 'Opted in' : 'Opted out' }}
                    </span>
                </p>

                <div class="pt-3 space-y-3">
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
                title="User account"
                description="Registrant’s login and authentication details.">
                <p class="text-sm">
                    <span class="font-medium">Account email:</span><br>
                    {{ $attendee->user->email }}
                </p>

                <p class="text-sm mt-3">
                    <span class="font-medium">Password:</span><br>
                    <span class="inline-flex items-center gap-1 text-[var(--color-text-light)]">
                        <x-heroicon-o-lock-closed class="w-4 h-4" />
                        Stored securely (encrypted).
                    </span>
                </p>
            </x-admin.tile-card>

        </div>

    </div>




    <div class="px-6 space-y-4">

        <x-admin.section-title title="Registration & payment" />

        <div class="grid md:grid-cols-2 gap-6">

            <!-- Payment Overview -->
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



            <!-- Price Breakdown -->
            <x-admin.tile-card
                title="Price breakdown"
                description="Tickets purchased and itemised totals.">
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
                                {{ $currency_symbol }}
                                {{
                                number_format(
                                    $attendee->registrationTickets->sum(
                                        fn($t) => $t->price_at_purchase * $t->quantity
                                    ),
                                2)
                            }}
                            </td>
                        </tr>
                    </tbody>

                </table>
            </x-admin.tile-card>

        </div>



        <!-- Uploaded Documents -->
        @if($attendee->registrationDocuments->isNotEmpty())
        <x-admin.tile-card
            title="Uploaded documents"
            description="Files provided during registration."
            class="mt-4">
            <div class="space-y-4 text-sm">
                @foreach($attendee->registrationDocuments as $doc)
                <div>
                    <p class="mb-1">
                        Upload for <span class="font-semibold">{{ $doc->ticket->name }}</span>
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



        <!-- Payment Actions -->
        <x-admin.tile-card
            title="Payment actions"
            description="Send payment emails or update registration status."
            class="mt-4">
            <div class="flex flex-wrap gap-3">

                @if($attendee->eventPaymentMethod->payment_method === 'bank_transfer'
                && $attendee->payment_status !== 'paid')
                <x-admin.outline-btn-icon
                    icon="heroicon-o-check-circle"
                    wire:click.prevent="openMarkPaidModal">
                    Mark as paid
                </x-admin.outline-btn-icon>
                @endif

                @if($attendee->eventPaymentMethod->payment_method === 'bank_transfer')
                <x-admin.outline-btn-icon
                    icon="heroicon-o-envelope"
                    wire:confirm="Send bank transfer details?"
                    wire:click.prevent="sendBankTransferInfo">
                    Send bank transfer details
                </x-admin.outline-btn-icon>
                @endif

                <x-admin.outline-btn-icon
                    icon="heroicon-o-envelope-open"
                    wire:confirm="Send receipt email?"
                    wire:click.prevent="sendReceipt">
                    Send receipt
                </x-admin.outline-btn-icon>

            </div>
        </x-admin.tile-card>

    </div>

    @include('livewire.backend.admin.attendees.modals.mark-paid-modal')



    <div class="px-6 space-y-4">

        <x-admin.section-title title="Received email log" />

        <x-admin.card hover="false" class="p-6 space-y-4">

            <x-admin.table>
                <table class="min-w-full text-sm">

                    <thead>
                        <tr class="text-xs text-[var(--color-text-light)] uppercase border-b border-[var(--color-border)]">
                            <th class="px-4 py-2 text-left">Type</th>
                            <th class="px-4 py-2 text-left">Subject</th>
                            <th class="px-4 py-2 text-left">Sent</th>
                            <th class="px-4 py-2 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($email_sends as $email_send)

                        <tr class="border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">

                            <td class="px-4 py-3">
                                {{ $email_send->broadcast->type }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $email_send->subject }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $email_send->sent_at?->diffForHumans() }}
                            </td>

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


</div>
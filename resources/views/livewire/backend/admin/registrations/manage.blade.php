<div class="space-y-6">

    <!-- ============================================================= -->
    <!-- BREADCRUMBS -->
    <!-- ============================================================= -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Registrations', 'href' => route('admin.events.registrations.index', $event->id)],
        ['label' => $attendee->title . ' ' . $attendee->last_name],
    ]" />


    <!-- ============================================================= -->
    <!-- PAGE HEADER + SUMMARY -->
    <!-- ============================================================= -->
    <div class="px-6 flex items-center justify-between">

        <!-- Title -->
        <div>
            <h1 class="text-2xl font-semibold text-[var(--color-text)]">
                {{ $attendee->title }} {{ $attendee->last_name }}
            </h1>
            <p class="text-sm text-[var(--color-text-light)] mt-1">
                Registration overview for {{ $event->title }}
            </p>
        </div>

        <!-- Summary tiles -->
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

            <!-- Total paid -->
            <div class="soft-card px-4 py-2 flex flex-col items-center">
                <span class="text-xs text-[var(--color-text-light)]">Total</span>
                <span class="text-sm font-semibold">
                    {{ $currency_symbol }}{{ $attendee->registration_total }}
                </span>
            </div>

            <!-- Tickets -->
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
                <p class="text-sm text-[var(--color-warning)]">
                    {{ $errors->first() }}
                </p>
            </div>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="px-6">
            <div class="soft-card p-4 border-l-4 border-[var(--color-success)]">
                <p class="text-sm text-[var(--color-success)]">
                    {{ session('success') }}
                </p>
            </div>
        </div>
    @endif

    @if (session()->has('receipt'))
        <div class="px-6">
            <div class="soft-card p-4 border-l-4 border-[var(--color-success)]">
                <p class="text-sm text-[var(--color-success)]">
                    {{ session('receipt') }}
                </p>
            </div>
        </div>
    @endif

    <!-- ============================================================= -->
    <!-- TOP ACTION CARDS -->
    <!-- ============================================================= -->
    <div class="px-6 space-y-4">
        <x-admin.section-title title="Tools" />
    
        <div class="grid md:grid-cols-2 gap-6">

            <!-- PAYMENT TOOLS -->
            <div class="soft-card p-5 hover:shadow-md hover:-translate-y-0.5 transition">
                <h3 class="font-medium mb-2">Payment</h3>
                <p class="text-sm text-[var(--color-text-light)] mb-4">
                    Manage payment status and communication with the registrant.
                </p>

                <!-- Mark as paid -->
                <x-link-arrow
                    href="#"
                    wire:click.prevent="openMarkPaidModal">
                    Mark as paid
                </x-link-arrow><br>

                <!-- Send bank transfer details -->
                <x-link-arrow
                    class="mt-1"
                    href="#"
                    wire:confirm="Are you sure you want to send bank transfer details to this registrant?"
                    wire:click.prevent="sendBankTransferInfo">
                    Send bank transfer details
                </x-link-arrow>
            </div>


            <!-- REGISTRATION TOOLS -->
            <div class="soft-card p-5 hover:shadow-md hover:-translate-y-0.5 transition">
                <h3 class="font-medium mb-2">Registration</h3>
                <p class="text-sm text-[var(--color-text-light)] mb-4">
                    Manage or modify this registration and view uploaded documents.
                </p>

                <!-- Edit registration -->
                <x-link-arrow href="{{ route('admin.events.registrations.edit', [$event->id, $attendee->id]) }}">
                    Edit registration
                </x-link-arrow>

                @if($attendee->registrationDocuments->isNotEmpty())
                    <x-link-arrow class="mt-1"
                                href="{{ route('admin.registration-documents.download', $attendee->registrationDocuments->first()) }}">
                        View uploads
                    </x-link-arrow>
                @endif


            </div>

        </div>
    </div>



    <!-- ============================================================= -->
    <!-- PERSONAL & PROFESSIONAL DETAILS -->
    <!-- ============================================================= -->
    <div class="px-6 space-y-4">
        <x-admin.section-title title="Attendee details" />
        <div class="soft-card p-6 space-y-6">

            

            <div class="grid md:grid-cols-2 gap-8 text-sm">

                <!-- Personal -->
                <div class="space-y-2">
                    <h3 class="font-medium text-[var(--color-text)] mb-1">Personal details</h3>

                    @if($this->roleKey === 'developer')
                        <p><span class="font-semibold">ID:</span> {{ $attendee->id }}</p>
                    @endif

                    <p>
                        <span class="font-semibold">Name:</span>
                        {{ $attendee->title }} {{ $attendee->first_name }} {{ $attendee->last_name }}
                    </p>

                    <p>
                        <span class="font-semibold">Email:</span>
                        <a href="mailto:{{ $attendee->user->email }}"
                           class="underline-offset-2 hover:underline">
                            {{ $attendee->user->email }}
                        </a>
                    </p>

                    <p><span class="font-semibold">Mobile:</span> {{ $attendee->mobile_country_code }}{{ $attendee->mobile_number }}</p>
                    <p><span class="font-semibold">Address line 1:</span> {{ $attendee->address_line_one }}</p>
                    <p><span class="font-semibold">Town:</span> {{ $attendee->town }}</p>
                    <p><span class="font-semibold">Country:</span> {{ $attendee->country->name }}</p>
                    <p><span class="font-semibold">Postcode:</span> {{ $attendee->postcode }}</p>
                </div>

                <!-- Professional -->
                <div class="space-y-2">
                    <h3 class="font-medium text-[var(--color-text)] mb-1">Professional details</h3>

                    <p>
                        <span class="font-semibold">Company:</span>
                        {{ $attendee->currently_held_position }}
                    </p>

                    <p>
                        <span class="font-semibold">Profession:</span>
                        @if($attendee->AttendeeType->name !== 'Other')
                            {{ $attendee->AttendeeType->name }}
                        @else
                            {{ $attendee->attendee_type_other }}
                        @endif
                    </p>

                    <div class="mt-4">
                        <h4 class="font-medium text-[var(--color-text)] mb-1">Registration actions</h4>
                        <a href="{{ route('admin.events.registrations.edit', ['event' => $event->id, 'attendee' => $attendee->id]) }}"
                           class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                                  bg-[var(--color-surface)] px-3 py-1.5 text-sm font-medium
                                  text-[var(--color-primary)]
                                  hover:bg-[var(--color-primary)] hover:text-white
                                  transition-colors duration-150">
                            <x-heroicon-o-pencil-square class="w-4 h-4 mr-1.5" />
                            Edit registration
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>



    <!-- ============================================================= -->
    <!-- EMAIL MARKETING & ACCOUNT -->
    <!-- ============================================================= -->
    <div class="px-6 space-y-4">
        <x-admin.section-title title="Marketing and account" />
        <div class="grid md:grid-cols-2 gap-6">

            <!-- Email marketing -->
            <div class="soft-card p-6 space-y-4 text-sm">

                <div class="space-y-3">
                    <div>
                        <p class="font-medium">General marketing opt-in</p>
                        <p class="text-[var(--color-text-light)]">
                            @if($attendee->user->email_marketing_opt_in)
                                Opted in
                            @else
                                Opted out
                            @endif
                        </p>
                    </div>

                    @foreach($attendee->optInResponses as $opt_in_response)
                        <div>
                            <p class="font-medium">{{ $opt_in_response->eventOptInCheck->friendly_name }}</p>
                            <p class="text-[var(--color-text-light)]">
                                @if($opt_in_response->value)
                                    Opted in
                                @else
                                    Opted out
                                @endif
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- User account -->
            <div class="soft-card p-6 space-y-4 text-sm">
                <x-admin.section-title title="User account" />

                <div class="space-y-3">
                    <div>
                        <p class="font-medium">Account email</p>
                        <p>{{ $attendee->user->email }}</p>
                    </div>

                    <div>
                        <p class="font-medium">Password</p>
                        <p class="text-[var(--color-text-light)]">
                            <span class="inline-flex items-center gap-1">
                                <x-heroicon-o-lock-closed class="w-4 h-4" />
                                Encrypted and stored securely.
                            </span>
                        </p>
                    </div>
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

                <!-- Overview -->
                <div class="space-y-2">
                    <p>
                        <span class="font-semibold">Payment method:</span>
                        {{ $attendee->eventPaymentMethod->name }}
                    </p>

                    <p>
                        <span class="font-semibold">Paid at:</span>
                        {{ $attendee->formatted_paid_date ?? 'Not paid yet' }}
                    </p>

                    <p>
                        <span class="font-semibold">Total amount:</span>
                        {{ $currency_symbol }}{{ $attendee->registration_total }}
                    </p>

                    @if($attendee->eventPaymentMethod->payment_method === 'stripe' && $attendee->payment_intent_id)
                        <p>
                            <a href="{{ config('services.stripe.payment_link') }}{{ $attendee->payment_intent_id }}"
                               target="_blank"
                               class="text-[var(--color-primary)] underline-offset-2 hover:underline">
                                View payment on Stripe
                            </a>
                        </p>
                    @endif
                </div>

                <!-- Ticket breakdown -->
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



            <!-- Uploads -->
            @if($attendee->registrationDocuments->isNotEmpty())
                <div class="border-t border-[var(--color-border)] pt-4 mt-2">
                    <h3 class="font-medium text-[var(--color-text)] mb-2">Uploads</h3>

                    <div class="space-y-3 text-sm">
                        @foreach($attendee->registrationDocuments as $document)
                            <div>
                                <p class="mb-1">
                                    Upload for <span class="font-semibold">{{ $document->ticket->name }}</span> ticket
                                </p>

                                <a href="{{ route('admin.registration-documents.download', $document) }}"
                                   class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                                          bg-[var(--color-surface)] px-3 py-1.5 text-sm font-medium
                                          text-[var(--color-primary)]
                                          hover:bg-[var(--color-primary)] hover:text-white
                                          transition-colors duration-150">
                                    <x-heroicon-o-arrow-down-tray class="w-4 h-4 mr-1.5" />
                                    View upload
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif



            <!-- Actions -->
            <div class="border-t border-[var(--color-border)] pt-4 mt-2 space-y-3">
                <h3 class="font-medium text-[var(--color-text)]">Payment actions</h3>

                <div class="flex flex-wrap gap-3">

                    <button
                        wire:click.prevent="openMarkPaidModal"
                        class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                               bg-[var(--color-surface)] px-3 py-1.5 text-sm font-medium
                               text-[var(--color-primary)]
                               hover:bg-[var(--color-primary)] hover:text-white
                               transition-colors duration-150">
                        <x-heroicon-o-check-circle class="w-4 h-4 mr-1.5" />
                        Mark as paid
                    </button>

                    <button
                        wire:confirm="Are you sure you want to send bank transfer details to the registrant?"
                        wire:click.prevent="sendBankTransferInfo"
                        class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                               bg-[var(--color-surface)] px-3 py-1.5 text-sm font-medium
                               text-[var(--color-primary)]
                               hover:bg-[var(--color-primary)] hover:text-white
                               transition-colors duration-150">
                        <x-heroicon-o-envelope class="w-4 h-4 mr-1.5" />
                        Send bank transfer details
                    </button>

                </div>
            </div>

        </div>
    </div>



    <!-- ============================================================= -->
    <!-- MARK AS PAID MODAL -->
    <!-- ============================================================= -->
    @if($showMarkPaidModal)
        <div class="fixed inset-0 z-40 flex items-center justify-center bg-black/50">
            <div class="soft-card p-6 w-full max-w-md space-y-4">

                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-[var(--color-text)]">Confirm payment</h2>
                        <p class="text-sm text-[var(--color-text-light)] mt-1">
                            Please confirm the date on which the payment was received.
                        </p>
                    </div>

                    <button
                        type="button"
                        wire:click="$set('showMarkPaidModal', false)"
                        class="text-[var(--color-text-light)] hover:text-[var(--color-text)]">
                        ✕
                    </button>
                </div>

                @if($errors->any())
                    <div class="soft-card p-3 border-l-4 border-[var(--color-warning)] bg-[var(--color-surface)]">
                        <p class="text-sm text-[var(--color-warning)]">
                            {{ $errors->first() }}
                        </p>
                    </div>
                @endif

                <form wire:submit.prevent="confirmMarkAsPaid" class="space-y-4">

                    <div>
                        <label for="payment_date" class="form-label-custom">
                            Payment date
                            <span class="block text-xs text-[var(--color-text-light)]">
                                Please use dd-mm-yyyy format.
                            </span>
                        </label>
                        <input
                            type="text"
                            id="payment_date"
                            wire:model="payment_date"
                            class="input-text"
                            placeholder="dd-mm-yyyy"
                            maxlength="10"
                        />
                    </div>

                    <div class="flex gap-4 hidden">
                        <div class="flex-1">
                            <label for="payment_hour" class="form-label-custom">Hour</label>
                            <input
                                type="text"
                                id="payment_hour"
                                wire:model="payment_hour"
                                class="input-text"
                                placeholder="HH"
                                maxlength="2"
                            />
                        </div>

                        <div class="flex-1">
                            <label for="payment_minute" class="form-label-custom">Minute</label>
                            <input
                                type="text"
                                id="payment_minute"
                                wire:model="payment_minute"
                                class="input-text"
                                placeholder="MM"
                                maxlength="2"
                            />
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">

                        <button type="button"
                                wire:click="$set('showMarkPaidModal', false)"
                                class="inline-flex items-center rounded-md border border-[var(--color-border)]
                                       bg-[var(--color-surface)] px-3 py-1.5 text-sm font-medium
                                       text-[var(--color-text)]
                                       hover:bg-[var(--color-surface-hover)] transition">
                            Cancel
                        </button>

                        <button type="submit"
                                class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                                       bg-[var(--color-surface)] px-3 py-1.5 text-sm font-medium
                                       text-[var(--color-primary)]
                                       hover:bg-[var(--color-primary)] hover:text-white
                                       transition-colors duration-150">
                            Confirm &amp; mark as paid
                        </button>

                    </div>

                </form>
            </div>
        </div>
    @endif



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
                            <th class="px-4 py-2 text-left">Type</th>
                            <th class="px-4 py-2 text-left">Subject</th>
                            <th class="px-4 py-2 text-left">Sent</th>
                            <th class="px-4 py-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($email_sends as $email_send)
                            <tr class="border-b border-[var(--color-border)]">
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
                                    <div class="inline-flex items-center gap-2">

                                        <x-admin.table-action-button
                                            type="link"
                                            :href="route('admin.emails.broadcasts.view', ['event' => $event->id, 'email_send' => $email_send->id])"
                                            icon="eye"
                                            label="View"
                                        />

                                        <x-admin.table-action-button
                                            type="button"
                                            wireClick="resendEmail({{ $email_send->id }})"
                                            confirm="Are you sure you want to resend this email to {{ $email_send->email_address }}?"
                                            icon="arrow-path"
                                            label="Resend"
                                        />

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                    No broadcasts found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

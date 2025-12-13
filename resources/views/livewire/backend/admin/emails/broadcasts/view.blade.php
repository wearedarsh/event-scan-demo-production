<div class="space-y-4">

    <!-- Breadcrumb -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Email broadcasts', 'href' => route('admin.events.emails.broadcasts.index', $event->id)],
        ['label' => $email_send->subject],
    ]" />

    <!-- Header -->
    <x-admin.page-header
        title="{{ $email_send->subject }}"
        subtitle="Email send overview">

        <div class="flex items-center gap-3">

            <x-admin.stat-card label="Status" 
                :value="{{ ucfirst($email_send->status) }}"
            />

            <x-admin.stat-card label="Sent"
                :value="{{ $email_send->sent_at?->diffForHumans() ?? '—' }}"
            />

            <x-admin.stat-card label="Opens"
                :value="{{ $email_send->opens_count }}"
            />

            <x-admin.stat-card label="Clicks"
                :value="{{ $email_send->clicks_count }}"
            />
            
        </div>
    </x-admin.page-header>

    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if(session()->has('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif

    <!-- Details -->
    <div class="px-6 space-y-4">

        <x-admin.section-title title="Send details" />

        <div class="grid md:grid-cols-2 gap-6">

            <!-- Recipient -->
            <x-admin.tile-card
                title="Recipient"
                description="Who this email was sent to.">

                <p class="text-sm">
                    <span class="font-semibold">Email:</span>
                    <a href="mailto:{{ $email_send->email_address }}" class="hover:underline">
                        {{ $email_send->email_address }}
                    </a>
                </p>

                @if($email_send->recipient)
                    <p class="text-sm">
                        <span class="font-semibold">Name:</span>
                        {{ $email_send->recipient->title }} {{ $email_send->recipient->first_name }} {{ $email_send->recipient->last_name }}
                    </p>
                @endif

            </x-admin.tile-card>

            <!-- Meta -->
            <x-admin.tile-card
                title="Delivery"
                description="When and how this email was sent.">

                <p class="text-sm">
                    <span class="font-semibold">Status:</span>
                    {{ ucfirst($email_send->status) }}
                </p>

                <p class="text-sm">
                    <span class="font-semibold">Sent at:</span>
                    {{ $email_send->sent_at?->format('d/m/Y H:i') ?? '—' }}
                </p>

                <p class="text-sm">
                    <span class="font-semibold">Sent by:</span>
                    @if($email_send->broadcast?->sender)
                        {{ $email_send->broadcast->sender->first_name }} {{ $email_send->broadcast->sender->last_name }}
                    @else
                        System
                    @endif
                </p>

            </x-admin.tile-card>

        </div>
    </div>

    <!-- Broadcast -->
    <div class="px-6 space-y-4">

        <x-admin.section-title title="Broadcast" />

        <div class="grid md:grid-cols-2 gap-6">

            <x-admin.tile-card
                title="Broadcast details"
                description="The parent broadcast this email belongs to.">

                <p class="text-sm">
                    <span class="font-semibold">Type:</span>
                    {{ $email_send->broadcast?->type?->label ?? '—' }}
                </p>

                <p class="text-sm">
                    <span class="font-semibold">Name:</span>
                    {{ $email_send->broadcast->friendly_name ?? '-' }}
                </p>

                @if($email_send->broadcast->event)
                    <p class="text-sm">
                        <span class="font-semibold">Event:</span>
                        {{ $email_send->broadcast->event->title ?? '-' }}
                    </p>
                @endif

            </x-admin.tile-card>

            <x-admin.tile-card
                title="Engagement"
                description="Recipient interaction with this email.">

                <p class="text-sm">
                    <span class="font-semibold">Opened:</span>
                    {{ $email_send->opens_count }} {{ Str::plural('time', $email_send->opens_count) }}
                </p>

                <p class="text-sm">
                    <span class="font-semibold">Clicked:</span>
                    {{ $email_send->clicks_count }} {{ Str::plural('time', $email_send->clicks_count) }}
                </p>

            </x-admin.tile-card>

        </div>
    </div>

    <!-- Content -->
    <div class="px-6 space-y-4">

        <x-admin.section-title title="Email content" />

        <x-admin.card hover="false" class="p-6 space-y-4">

            <p class="text-sm">
                <span class="font-semibold">Subject:</span>
                {{ $email_send->subject }}
            </p>

            <div class="prose max-w-none">
                <iframe
                    class="w-full rounded-lg bg-white"
                    style="min-height: 600px"
                    srcdoc="{!! $email_send->html_content !!}">
                </iframe>
            </div>

        </x-admin.card>

    </div>

</div>

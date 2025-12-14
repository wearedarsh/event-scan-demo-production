<div class="space-y-4">

    <!-- Breadcrumb -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Email broadcasts', 'href' => route('admin.events.emails.broadcasts.index', $event->id)],
        ['label' => $email_send->subject],
    ]" />

    <!-- Header -->
    <x-admin.page-header
        title="{{ $email_send->recipient->title }} {{ $email_send->recipient->first_name }} {{ $email_send->recipient->last_name }}"
        subtitle="{{ $email_send->email_address }}">

        <div class="flex items-center gap-3">

            <x-admin.stat-card label="Status" 
                :value="ucfirst($email_send->status)"
            />

            <x-admin.stat-card label="Sent"
                :value="$email_send->sent_at?->diffForHumans()"
            />

            <x-admin.stat-card label="Opens"
                :value="$email_send->opens_count"
            />

            <x-admin.stat-card label="Clicks"
                :value="$email_send->clicks_count"
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
                description="Who this email was sent to."
                :micro="['title' => 'Details']"
                icon="heroicon-o-user"
                >

                <p class="text-sm">
                    <x-link-arrow href="mailto:{{ $email_send->email_address }}" class="mt-1">
                        {{ $email_send->email_address }}
                    </x-link-arrow>
                </p>

                @if($email_send->recipient)
                    <p class="text-sm">
                        {{ $email_send->recipient->title }} {{ $email_send->recipient->first_name }} {{ $email_send->recipient->last_name }}
                    </p>
                @endif

            </x-admin.tile-card>

            <!-- Meta -->
            <x-admin.tile-card
                title="Delivery"
                description="When and how this email was sent."
                :micro="['title' => 'Details']"
                icon="heroicon-o-paper-airplane"
            >
            <x-admin.status-pill status="neutral">{{ ucfirst($email_send->status) }}</x-admin.status-pill>

                <p class="text-xs">
                    <span class="text-xs font-semibold">At </span>
                    {{ $email_send->sent_at?->format('d/m/Y H:i') ?? '—' }}
                </p>

                <p class="text-xs">
                    <span class="text-xs font-semibold">By </span>
                    @if($email_send->broadcast?->sender)
                        {{ $email_send->broadcast->sender->first_name }} {{ $email_send->broadcast->sender->last_name }}
                    @else
                        System
                    @endif
                </p>

            </x-admin.tile-card>

        </div>
    </div>

    <!-- Content -->
    <div class="px-6 space-y-4">

        <x-admin.section-title title="Email content" />

        <x-admin.tile-card hover="false" class="p-6 space-y-4"
            title="subject"
            :description="$email_send->subject"
            icon="heroicon-o-pencil-square"
        >
        <x-admin.section-title-icon title="Email content" icon="hero-o-code-bracket-square" />
            <div class="prose max-w-none">
                <x-admin.email-preview-iframe :id="$email_send->id" />
            </div>

        </x-admin.tile-card>

    </div>

</div>

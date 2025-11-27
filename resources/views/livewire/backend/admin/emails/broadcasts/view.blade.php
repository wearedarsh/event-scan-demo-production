<div>
    <div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
        <h2 class="fs-4 text-brand-dark p-0 m-0">{{ $email_send->subject }}</h2>
    </div>
    
    @if($errors->any())
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info" role="alert">
                    <span class="font-m">{{ $errors->first() }}</span>           
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success" role="alert">
                    <span class="font-m">{{ session('success') }}</span>           
                </div>
            </div>
        </div>
    @endif

    <div class="flex-row d-flex flex-1 bg-white rounded-2 p-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb d-flex flex-row align-items-center">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.emails.broadcasts.index', $event->id) }}">Email Broadcasts</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$email_send->subject}}</li>
            </ol>
        </nav>
    </div>

    <!-- DETAILS -->
    <div class="flex-column d-flex bg-white text-brand-dark rounded-2 p-3 mt-3">
        <div class="row">
            <div class="col-sm-6 mb-3">
                <h5 class="mb-3">Recipient details</h5>
                <p class="font-m"><strong>Email:</strong> <a href="mailto:{{ $email_send->email_address }}">{{ $email_send->email_address }}</a></p>
                @if($email_send->recipient)
                    <p class="font-m"><strong>Name:</strong> {{ $email_send->recipient->title }} {{ $email_send->recipient->first_name }} {{ $email_send->recipient->last_name }}</p>
                @endif
            </div>
            <div class="col-sm-6 mb-3">
                <h5 class="mb-3">Send details</h5>
                <p class="font-m"><strong>Status:</strong> {{ $email_send->status }}</p>
                <p class="font-m"><strong>Sent at:</strong> {{ $email_send->sent_at->format('j M Y, H:i') }}</p>
                @if($email_send->broadcast->sent_by)
                    <p class="font-m"><strong>Sent by:</strong> {{ $email_send->broadcast->sender->first_name }} {{ $email_send->broadcast->sender->last_name }}</p>
                @else
                    <p class="font-m"><strong>Sent by:</strong> Email was sent via the system or does not have a sender</p>
                @endif
            </div>
        </div>   
    </div>

    <!-- BROADCAST DETAILS -->
    <div class="flex-column d-flex bg-white text-brand-dark rounded-2 p-3 mt-3">
        <div class="row">
            <div class="col-sm-6 mb-3">
                <h5 class="mb-3">Broadcast details</h5>
                <p class="font-m"><strong>Type:</strong> {{ $email_send->broadcast->type }}</p>
                <p class="font-m"><strong>Name:</strong> {{ $email_send->broadcast->friendly_name }}</p>
                @if($email_send->broadcast->event)
                    <p class="font-m"><strong>Event:</strong> {{ $email_send->broadcast->event->title }}</p>
                @endif
            </div>
            <div class="col-sm-6 mb-3">
                <h5 class="mb-3">Interactions</h5>
                <p class="font-m"><strong>Opened:</strong> {{ $email_send->opens_count }} @if( $email_send->opens_count != 1) times @else time @endif</p>
                <p class="font-m"><strong>Clicked:</strong> {{ $email_send->clicks_count }} @if( $email_send->clicks_count != 1) times @else time @endif</p>
            </div>
        </div>   
    </div>

    <!-- CONTENT -->
    <div class="flex-column d-flex bg-white text-brand-dark rounded-2 p-3 mt-3">
        <div class="row">
            <div class="col-12 mb-3">
                <h5 class="mb-3">Email content</h5>
                <p class="font-m"><strong>Subject:</strong> {{ $email_send->subject }}</p>
                {!! $email_send->html_content !!}
            </div>
        </div>   
    </div>
</div>
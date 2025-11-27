<div>
    <div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
        <h2 class="fs-4 text-brand-dark p-0 m-0">
            Email broadcasts<br>
            <span class="font-m">{{ $event->title }}</span>
        </h2>
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
                <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Events</a></li>
                <li class="breadcrumb-item active" aria-current="page">Email broadcasts</li>
            </ol>
        </nav>
    </div>

    <div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
        <div class="row mb-3">
            <div class="col-sm-9">
                <h3>Email broadcasts</h3>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6 mb-2">
                <input wire:model.live.debounce.300ms="search" type="text" class="form-control"
                       placeholder="Search by email, last name or subject">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle font-s" style="margin-bottom:150px;">
                <thead class="table-light">
                    <tr>
                        <th>Type</th>
                        <th>Recipient</th>
                        <th>Subject</th>
                        <th>Sent at</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($email_sends as $email_send)
                        <tr>
                            <td>{{ optional($email_send->broadcast)->type ?? '—' }}</td>
                            <td>
                                @if($email_send->recipient)
                                    <strong>
                                        {{ optional($email_send->recipient)->title }}
                                        {{ optional($email_send->recipient)->first_name }}
                                        {{ optional($email_send->recipient)->last_name }}
                                    </strong><br>
                                @endif
                                <a href="mailto:{{ $email_send->email_address }}" target="_blank">
                                    {{ $email_send->email_address }}
                                </a>
                            </td>
                            <td>{{ $email_send->subject }}</td>
                            <td>{{ $email_send->sent_at?->diffForHumans() ?? '—' }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn bg-brand-secondary dropdown-toggle" type="button"
                                            data-coreui-toggle="dropdown" aria-expanded="false">
                                        Action
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item font-m"
                                               href="{{ route('admin.emails.broadcasts.view', ['email_send' => $email_send->id, 'event' => $event->id]) }}">
                                                View details
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No broadcasts found for this event.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $email_sends->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

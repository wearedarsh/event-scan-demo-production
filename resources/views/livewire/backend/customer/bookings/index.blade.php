<div>
    <div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
        <h2 class="fs-4 text-brand-dark p-0 m-0">Attendees</h2>
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

    <div class="flex-row d-flex flex-1 bg-white rounded-2 p-3 mb-3 overflow-auto">
        <nav aria-label="breadcrumb" class="w-max">
            <ol class="breadcrumb d-flex flex-nowrap align-items-center">
                <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Bookings</li>
            </ol>
        </nav>
    </div>

    <div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
        <div class="row mb-3">
            <div class="col-sm-9">
                <h3>Bookings</h3>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle font-m" style="margin-bottom:150px;">
                <thead class="table-light">
                    <tr>
                        <th>Event</th>
                        <th>Payment</th>
                        <th>Badge</th>
                        <th>Certificate of attendance</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($user->registrations as $booking)
                        @php
                            $activeForms = $booking->event->feedbackFormsActive;
                            $completedSubmission = null;
                            foreach ($activeForms as $ff) {
                                $sub = $user->feedbackFormSubmissions->firstWhere('feedback_form_id', $ff->id);
                                if ($sub && $sub->status === 'complete') { $completedSubmission = $sub; break; }
                            }
                            $firstActiveForm = $activeForms->first();
                        @endphp

                        <tr>
                            <td>{{ $booking->event->title }}</td>

                            <td>
                                <span class="badge text-bg-info font-s fw-normal">
                                    <span class="text-brand-light">{{ $booking->eventPaymentMethod->name }}</span>
                                </span><br>
                                <strong>{{ $currency_symbol }}{{ $booking->registration_total }}</strong><br>
                                <span class="font-s">{{ $booking->formatted_paid_date }}</span>
                            </td>

                            <td>
                                <a class="btn bg-brand-secondary d-inline-flex align-items-center"
                                       href="{{ route('customer.bookings.single-badge.export', ['event' => $booking->event->id, 'attendee' => $booking->id]) }}"
                                       target="_parent">
                                        <span class="cil-cloud-download me-2"></span>
                                        <span class="text-brand-light">Digital badge</span>
                                    </a>
                            </td>

                            <!-- NEW CERT COLUMN CELL -->
                            <td>
                                @if($completedSubmission)
                                    <a class="btn bg-brand-secondary d-inline-flex align-items-center"
                                       href="{{ route('customer.event-completed-certificate.download', $booking->id) }}"
                                       target="_parent">
                                        <span class="cil-cloud-download me-2"></span>
                                        <span class="text-brand-light">Download</span>
                                    </a>
                                @elseif($firstActiveForm)
                                    <a class="btn bg-brand-secondary d-inline-flex align-items-center"
                                       href="{{ route('customer.feedback.form', ['event' => $booking->event_id, 'feedback_form' => $firstActiveForm->id]) }}"
                                       target="_parent">
                                        <span class="cil-arrow-right me-2"></span>
                                        <span class="text-brand-light">Complete feedback form</span>
                                    </a>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            <td>
                                <div class="dropdown">
                                    <button class="btn bg-brand-secondary dropdown-toggle" type="button" data-coreui-toggle="dropdown" aria-expanded="false">
                                        Action
                                    </button>
                                    <ul class="dropdown-menu">
                                        @foreach($activeForms as $feedback_form)
                                            @php
                                                $submission = $user->feedbackFormSubmissions
                                                    ->firstWhere('feedback_form_id', $feedback_form->id);
                                            @endphp

                                            @if($submission && $submission->status === 'complete')
                                                <li>
                                                    <span class="dropdown-item font-m text-muted">
                                                        {{ $feedback_form->title }} (Completed)
                                                    </span>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item font-m"
                                                       href="{{ route('customer.event-completed-certificate.download', $booking->id) }}"
                                                       target="_parent">
                                                        Download certificate of attendance
                                                    </a>
                                                </li>
                                            @else
                                                <li>
                                                    <a class="dropdown-item font-m"
                                                       href="{{ route('customer.feedback.form', ['event' => $booking->event_id, 'feedback_form' => $feedback_form->id]) }}">
                                                        {{ $feedback_form->title }}
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach

                                        <li>
                                            <a class="dropdown-item font-m"
                                               href="{{ route('customer.bookings.manage', ['user' => $user->id, 'registration' => $booking->id]) }}">
                                                Manage
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3" style="margin-top:-130px!important;"></div>
    </div>
</div>

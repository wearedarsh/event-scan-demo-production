<div>
    <div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
        <h2 class="fs-4 text-brand-dark p-0 m-0">{{$registration->event->title}}</h2>
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
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('customer.bookings.index', ['user' => $user->id]) }}">Bookings</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$registration->event->title}}</li>
            </ol>
        </nav>
    </div>

    <!-- PERSONAL AND PROFESSIONAL -->
    <div class="flex-column d-flex bg-white rounded-2 p-3 mt-3">
        <div class="row">
            <div class="col-sm-6 mb-3">
                <h5 class="mb-3">Your details</h5>
                <p class="font-m"><span class="fw-medium">Name:</span> {{$registration->title . ' ' . $registration->first_name . ' ' . $registration->last_name}} <span class="badge text-bg-light cursor-pointer font-s ms-2 px-2 py-1 rounded-5" data-coreui-toggle="tooltip" data-coreui-placement="top" title="If you wish to update your name please do this within your profile"><span class="text-brand-dark">more info</span></span>
                </p>
                <p class="font-m"><span class="fw-medium">Email:</span> <a href="mailto:{{$registration->user->email}}">{{$registration->user->email}}</a> <span class="badge text-bg-light cursor-pointer font-s ms-2 px-2 py-1 rounded-5" data-coreui-toggle="tooltip" data-coreui-placement="top" title="If you wish to update your email address please do this within your profile"><span class="text-brand-dark">more info</span></p>
                <p class="font-m"><span class="fw-medium">Mobile:</span> {{$registration->mobile_country_code}}{{$registration->mobile_number}}</p>
                <p class="font-m"><span class="fw-medium">First line address:</span> {{$registration->address_line_one}}</p>
                <p class="font-m"><span class="fw-medium">Town:</span> {{$registration->town}}</p>
                <p class="font-m"><span class="fw-medium">Country:</span> {{$registration->country->name}}</p>
                <p class="font-m"><span class="fw-medium">Postcode:</span> {{$registration->postcode}}</p>
            </div>
            <div class="col-sm-6 mb-3">
                <h5 class="mb-3">Professional details</h5>
                <p class="font-m"><span class="fw-medium">Medical position:</span> {{$registration->currently_held_position}}</p>
                <p class="font-m"><span class="fw-medium">Medical attendeeType:</span> {{$registration->AttendeeType->name}}</p>
            </div>
        </div>  

        <div class="row">
            <div class="col-12">
                <h5>Actions</h5>
                <div class="row p-2">
                    <a class="btn bg-brand-secondary align-items-center mb-2 w-auto" href="{{route('customer.bookings.edit', ['registration' => $registration->id, 'user' => $user->id])}}"><span class="cil-arrow-right me-2"></span><span class="text-brand-right">Update your personal details</span></a>
                </div>
            </div>
        </div>
    </div>


    <!-- BOOKING -->
    <div class="flex-column d-flex bg-white rounded-2 p-3 mt-3">
        
        <div class="row">
            <div class="col-sm-6 mb-3">
                <h5>Your booking</h5>
                <span class="font-m">
                    <span class="badge text-bg-info"><span class="text-brand-light font-m">{{$registration->eventPaymentMethod->name}}</span></span><br>
                    <span class="fw-bold"> Booking reference: {{$registration->booking_reference}}</span><br>
                    {{$registration->formatted_paid_date}}<br>
                    {{$currency_symbol}}{{$registration->registration_total}}<br>
                </span>
            </div>

            <div class="col-sm-6">
                <h5>Payment detail</h5>
                <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 20px; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 1px solid #EDEFF2;">
                            <th align="left" style="padding-bottom: 8px; font-size: 12px; color: #22BC66;">Description</th>
                            <th align="right" style="padding-bottom: 8px; font-size: 12px; color: #22BC66;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($registration->registrationTickets as $ticket)
                            <tr>
                                <td style="padding: 8px 0; font-size: 15px;">
                                    {{ $ticket->quantity }} × {{ $ticket->ticket->name }} (inc. VAT)
                                </td>
                                <td align="right" style="padding: 8px 0; font-size: 15px;">
                                    {{ $currency_symbol }}{{ number_format($ticket->price_at_purchase * $ticket->quantity, 2) }}
                                </td>
                            </tr>
                        @endforeach

                        <tr style="border-top: 1px solid #EDEFF2;">
                            <td align="right" style="padding-top: 15px; font-weight: bold;font-size:15px;">Total</td>
                            <td align="right" style="padding-top: 15px; font-weight: bold;font-size:15px;">
                                {{ $currency_symbol }}{{ number_format($registration->registrationTickets->sum(fn($t) => $t->price_at_purchase * $t->quantity), 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        @if($registration->registrationDocuments->isNotEmpty())
        <div class="row">
            <div class="col-12 mt-3">
                <h5>Uploads</h5>
                @foreach($registration->registrationDocuments as $document)
                    <span class="font-m mb-2">Upload for {{ $document->ticket->name }} ticket</span><br>
                    <a class="btn bg-brand-secondary align-items-center mb-2 mt-2 w-auto" href="{{ route('admin.registration-documents.download', $document) }}"><span class="cil-cloud-download me-2"></span><span>View upload</span></a>
                @endforeach
            </div>
        </div>
        @endif
    
    </div>

    <!-- MARKETING -->
    <div class="flex-column d-flex bg-white rounded-2 p-3 mt-3">
        <div class="row">
            <div class="col-sm-6">
                @foreach($registration->optInResponses as $opt_in_response)
                    <h5>{{ $opt_in_response->eventOptInCheck->friendly_name }}</h5>
                    <span class="font-m">@if($opt_in_response->value) Opted in @else Opted out @endif</span><br>
                    <a class="btn bg-brand-secondary align-items-center mb-2 w-auto mt-2" wire:click="updateOptIn({{$opt_in_response->id}})"><span class="cil-arrow-right me-2"></span><span class="text-brand-right">@if($opt_in_response->value) Opt out @else Opt in @endif</span></a>
                @endforeach
            </div>
        </div>

    </div>


    
    
</div>
    

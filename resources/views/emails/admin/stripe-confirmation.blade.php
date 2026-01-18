<h1>There has been a new registration for <strong>{{ $registration->event->title }}</strong></h1>

<p>The attendee paid by Stripe and the payment was successful.</p>

<p>Registration total: {{ $currency_symbol }}{{ $registration_total }}<br>
Name: {{ $registration->title }} {{ $registration->last_name }}<br>
Email: <a href="{{ $registration->user->email }}">{{ $registration->user->email }}</a></p>

<p><strong>Booking reference:</strong> {{ $registration->booking_reference }}</p>
<p><strong>Stripe payment link:</strong> <a href="{{ client_settings('payment.admin.stripe.payments_url') }}{{$registration_payment->provider_reference}}">{{$registration_payment->provider_reference}}</a>

<p>Here are the booking details</p>

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
                    {{ $currency_symbol }}{{ $ticket->calculated_total }}
                </td>
            </tr>
        @endforeach

        <tr style="border-top: 1px solid #EDEFF2;">
            <td align="right" style="padding-top: 15px; font-weight: bold;font-size:15px;">Total</td>
            <td align="right" style="padding-top: 15px; font-weight: bold;font-size:15px;">
                {{ $currency_symbol }}{{ $registration->calculated_total }}
            </td>
        </tr>
    </tbody>
</table>

<p style="margin-top: 30px;">
    Login to check the booking <a href="{{ route('admin.events.attendees.manage', ['event' => $registration->event_id, 'attendee' => $registration->id]) }}">here</a>.
</p>

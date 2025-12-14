<h1>Dear {{ $registration->title }} {{ $registration->last_name }},</h1>

<p>Thank you for your registration. Your payment was successful.</p>

<p>
    Below is your booking confirmation for the <strong>{{ $registration->event->title }}</strong> on 
    <strong>{{ $registration->event->date_start->isoformat('Do') }} to {{ $registration->event->date_end->isoformat('Do MMMM YYYY') }}</strong> in 
    <strong>{{ $registration->event->location }}</strong>.
</p>

@if ($registration->booking_reference)
    <p><strong>Booking Reference:</strong> {{ $registration->booking_reference }}</p>
@endif

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

<p style="margin-top: 30px;">
    If you have any questions, feel free to <a href="mailto:">email us</a>.
</p>
{!! email_signature !!}

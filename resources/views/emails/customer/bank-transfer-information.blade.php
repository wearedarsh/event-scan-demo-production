@extends('emails.layouts.main')

@section('content')

<p>Dear {{ $registration->title }} {{ $registration->last_name }},</p>

<p>Thank you for registering for <strong>{{ $registration->event->title }}</strong> taking place on <strong>{{ $registration->event->date_start->isoformat('Do') }} to {{ $registration->event->date_end->isoformat('Do MMMM YYYY') }}</strong> in <strong>{{ $registration->event->location }}</strong>.</p>

<p>Please make your bank transfer using the following details:</p>

<p>
    <strong>Amount:</strong> {{ $currency_symbol }}{{ number_format($registration_total, 2) }}<br>
    <strong>Bank:</strong> Barclays<br>
    <strong>Address:</strong> 53 The Broadway, Ealing, London W5 5JS<br>
    <strong>Account Name:</strong> European Venous Forum Ltd<br>
    <strong>Account No:</strong> 65205666<br>
    <strong>Sort Code:</strong> 202749<br>
    <strong>IBAN:</strong> GB89 BUKB 2027 4965 2056 66<br>
    <strong>SWIFT/BIC:</strong> BUKBGB22
</p>

<p>Here are your booking details:</p>

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

<p>If you have any questions, feel free to <a href="mailto:admin@europeanvenousforum.org">email us</a>.</p>

<p>Kind regards,<br>
The Medical Foundry Team</p>

@endsection

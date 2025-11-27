@extends('emails.layouts.main')

@section('content')

<p>A registration has opted to pay by bank transfer</p>

<p>Registration total: {{ $currency_symbol }}{{ number_format($registration_total, 2) }}<br>
Name: {{ $registration->title }} {{ $registration->last_name }}<br>
Email: <a href="{{ $registration->user->email }}">{{ $registration->user->email }}</a></p>

<p><strong>Here are the booking details</strong></p>

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

<p>You can view this registration <a href="{{ route('admin.events.registrations.manage', ['event' => $registration->event_id, 'attendee' => $registration->id]) }}">here</a></p>

@endsection

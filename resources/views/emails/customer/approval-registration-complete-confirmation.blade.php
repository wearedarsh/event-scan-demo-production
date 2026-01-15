<h1>Dear {{ $registration->title }} {{ $registration->last_name }},</h1>

<p>
    Thank you for your application to join us at <strong>{{ $registration->event->title }}</strong> on 
    <strong>{{ $registration->event->date_start->isoformat('Do') }} to {{ $registration->event->date_end->isoformat('Do MMMM YYYY') }}</strong> in 
    <strong>{{ $registration->event->location }}</strong>.
</p>

<p>A member of our team has received your application and you'll be notified of wether you have been successful or not within 3-5 working days.

<p style="margin-top: 30px;">
    In the mean time if you have any questions, feel free to <a href="mailto:">email us</a>.
</p>
{!! $email_signature !!}

@extends('emails.layouts.main')

@section('content')
<h1>Dear {{ $user->title }} {{ $user->last_name }},</h1>

<p>Thank you for completing {{ $evaluation_form_title }} for {{ $event_title }}</p>

<p>
    If you haven't done so already, you are able to download your certificate of attendance from within the bookings section of your account   
</p>

<p style="text-align: center; margin: 30px 0;">
    <a href="{{ $url }}" style="padding: 12px 24px; background-color: #0D4261; color: #fff; text-decoration: none; border-radius: 6px;">Download your certificate</a>
</p>

<p style="margin-top: 30px;">
    If you have any questions, feel free to <a href="mailto:{{config('customer.contact_details.booking_website_support_email)}}">email us</a>.
</p>
{!! config('customer.email.transactional_email_signature') !!}
@endsection

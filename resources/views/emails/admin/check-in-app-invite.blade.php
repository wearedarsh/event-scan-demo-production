@extends('emails.layouts.main')

@section('content')

<h1>Dear {{ $user->first_name }},</h1>
<p>You have been invited to use the {{ config('check-in-app.friendly_name') }} app, please follow the instructions below on your phone.</p>
<br><br>

<p><strong>Step 1. Set your account password</strong></p>
<p>An account has been created for you using this email address - <strong>{{ $user->email }}</strong> with a temporary password.<br><br>
You are required to set your password before logging in.</p>
<p style="margin: 30px 0;">
    <a href="{{ $reset_url }}"
       style="padding: 12px 24px; background-color: #0D4261; color: #fff; text-decoration: none; border-radius: 6px;">
        Set password
    </a>
</p>
<p>This link will expire in 24 hours</p>

<p><strong>Step 2. Log in </strong></p>
<p>Use your email address and new password to log in to the admin system.</p>
<p>Here you will find instuctions on how to install and initialise the app on your phone.</p>
<p style="margin: 30px 0;">
    <a href="{{ config('app.url') }}/login" style="padding: 12px 24px; background-color: #0D4261; color: #fff; text-decoration: none; border-radius: 6px;">Log in</a>
</p>
<p style="margin-top: 30px;">
    If you have any questions, feel free to <a href="mailto:{{config('customer.contact_details.booking_website_support_email}}">email us</a>.
</p>
{!! config('customer.email.transaction_email_signature') !!}

@endsection


@section('content')
    <p>You recently requested to reset your password for your {{client_setting('general.customer_friendly_name')}} account. Click the button below to reset it:</p>

    <p style="text-align: center; margin: 30px 0;">
        <a href="{{ $url }}" style="padding: 12px 24px; background-color: #0D4261; color: #fff; text-decoration: none; border-radius: 6px;">Reset Password</a>
    </p>

    <p>If you didn’t request a password reset, please ignore this email. This link will expire in 60 minutes.</p>

    {!! email_signature !!}
@endsection
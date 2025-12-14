<h1>Dear {{ $user->first_name }},</h1>
<p>Here are your instructions for installing and initialising the {{ config('check-in-app.friendly_name') }} app.<br><br>
Simply follow these instructions on your phone.</p>
<br><br>

<p><strong>Step 1. Install the app</strong></p>
<p>Select your phone type below.<br><br>
You will be directed to the appropriate app store where you can download and install the app on your phone.</p>
<p style="margin: 30px 0;">
    <a href="{{ config('check-in-app.apple_download_url') }}" style="padding: 12px 24px; background-color: #0D4261; color: #fff; text-decoration: none; border-radius: 6px; margin-right:20px;">Apple</a> 
    <a href="{{ config('check-in-app.android_download_url') }}" style="padding: 12px 24px; background-color: #0D4261; color: #fff; text-decoration: none; border-radius: 6px;">Android</a>
</p>
<br><br>
<p><strong>Step 2. Initialise the app</strong></p>
<p>Once the app is installed you are required to click the link below to securely initialise the app for use on your phone - <strong>This only needs to be done once</strong>.</p>
<p style="margin: 30px 0;">
    <a href="{{ $initialise_link }}" style="padding: 12px 24px; background-color: #0D4261; color: #fff; text-decoration: none; border-radius: 6px;">Initialise app securely</a>
</p>
<br><br>
<p><strong>Step 3. Log in and use the app</strong></p>
<p>Using your management platform credentials you'll now be able to log in and use the app.</p>


@endsection

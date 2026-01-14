<h1>There has been a new registration for  <strong>{{ $registration->event->title }}</strong></h1>

<p>The registration is pending approval.</p>

<p>
    Name: {{ $registration->title }} {{ $registration->last_name }}<br>
    Email: <a href="{{ $registration->user->email }}">{{ $registration->user->email }}</a>
</p>

<p style="margin-top: 30px;">
    Login to check the booking <a href="{{ route('admin.events.registrations.manage', ['event' => $registration->event_id, 'registration' => $registration->id]) }}">here</a>.
</p>
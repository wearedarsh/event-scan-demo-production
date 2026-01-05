@extends('livewire.frontend.layouts.app')

@section('content')

@include('livewire.frontend.partials.nav')

<!-- ===== Hero ===== -->
<section class="relative flex items-center justify-center pt-40 pb-16 text-center overflow-hidden">
  <!-- Background -->
  <div class="absolute inset-0 bg-cover bg-center" 
       style="background-image:url('{{ asset('images/frontend/header-bg.jpg') }}');">
  </div>

  <!-- Content -->
  <div class="relative max-w-3xl mx-auto px-6 text-white z-10">
    <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ client_setting('check_in_app.friendly_name') }} privacy policy</h1>
    <p class="text-lg text-white/90 mb-10">
      Your privacy and data security are important to us.
    </p>
  </div>
</section>

<!-- ===== Content ===== -->
<section class="bg-[var(--color-bg)] py-16">
  <div class="text-sm text-left max-w-3xl mx-auto px-6 text-[var(--color-text)] leading-relaxed space-y-8">

    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">Overview</h2>
    <p>
      The <strong>{{ client_setting('check_in_app.friendly_name') }}</strong> application and platform are provided by 
      <strong>{{client_setting('general.customer_friendly_name')}}</strong> 
      to manage event registrations, attendee check-ins, and related communications.
      We are committed to <strong>protecting your personal information</strong> and handling it responsibly.
    </p>

    <hr class="border-[var(--color-border)]">

    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">Information We Collect</h2>
    <ul class="list-disc list-inside space-y-1">
      <li>Attendee and registration details you provide during event signup</li>
      <li>Badge or QR code data used for event check-in and attendance tracking</li>
      <li>Basic login credentials (email and password)</li>
      <li>Device permissions (e.g. camera) when using our mobile or check-in applications</li>
    </ul>

    <hr class="border-[var(--color-border)]">

    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">How We Use Your Information</h2>
    <p>
      Your information is used solely to <strong>facilitate your event participation</strong> — including registration, attendance management, ticketing, and essential event communications.
      We do <strong>not sell, rent, or share</strong> your personal information with third parties, except where required to deliver event services securely.
    </p>

    <hr class="border-[var(--color-border)]">

    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">Data Storage & Security</h2>
    <p>
      All personal data is stored securely in accordance with <strong>UK GDPR</strong> and relevant data protection legislation.
      We apply <strong>encryption</strong> and <strong>restricted access controls</strong> to safeguard your information.
    </p>

    <hr class="border-[var(--color-border)]">

    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">Device Permissions</h2>
    <p>
      When using our check-in tools, the app may request access to your device’s camera to scan attendee QR codes.
      These permissions are used <strong>only for that purpose</strong> and are <strong>not stored or transmitted</strong> elsewhere.
    </p>

    <hr class="border-[var(--color-border)]">

    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">Your Rights</h2>
    <p>
      You have the right to <strong>access, correct, or request deletion</strong> of your data at any time.
      If you wish to make such a request, please contact us using the details below.
    </p>

    <hr class="border-[var(--color-border)]">

    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">Contact</h2>
    <p>
      For questions about this policy or to exercise your data rights, please contact our data team at:
      <br>
      <strong>{{ $privacy_email }}</strong>
    </p>

  </div>
</section>
@endsection

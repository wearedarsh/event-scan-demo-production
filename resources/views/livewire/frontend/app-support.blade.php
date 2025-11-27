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
    <h1 class="text-4xl md:text-5xl font-bold mb-4">{{config('check-in-app.friendly_name')}} support</h1>
    <p class="text-lg text-white/90 mb-10">
      Technical assistance and information for authorised {{config('check-in-app.friendly_name')}} app users.
    </p>
  </div>
</section>


<!-- Content -->
<section class="bg-[var(--color-bg)] py-16">
  <div class="text-sm text-left max-w-3xl mx-auto px-6 text-[var(--color-text)] leading-relaxed space-y-8">

    <p>
      The <strong>{{ config('check-in-app.friendly_name') }}</strong> app is designed exclusively for authorised {{config('customer.contact_details.booking_website_company_name')}} account holders to manage
      secure badge scanning and attendance tracking during events.
      It is <strong>not intended for public use</strong> — access requires a valid {{config('customer.contact_details.booking_website_company_name')}} account and a provisioning link.
    </p>

    <hr class="border-[var(--color-border)]">

    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">Contact Support</h2>
    <p>
      For any technical issues, setup questions, or assistance using the app, please contact our support team:
      <br>
        {{ config('check-in-app.support_email') }}
    </p>

    <hr class="border-[var(--color-border)]">

    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">Important Notes</h2>
    <ul class="list-disc list-inside space-y-1">
      <li>This app is <strong>not for public use</strong>.</li>
      <li>Access requires a valid {{config('customer.contact_details.booking_website_company_name')}} account and provisioning link.</li>
      <li>Use is restricted to authorised event staff and organisers.</li>
    </ul>

    <hr class="border-[var(--color-border)]">

    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">About the App</h2>
    <p>
      The <strong>{{ config('check-in-app.friendly_name') }}</strong> app is built for <strong>fast, secure, and reliable badge scanning</strong>,
      seamlessly integrated with the {{config('customer.contact_details.booking_website_company_name')}} platform.
      It offers:
    </p>
    <ul class="list-disc list-inside space-y-1">
      <li>Ultra-fast QR badge scanning with <strong>offline capability</strong></li>
      <li>Event and session selection for check-in management</li>
      <li>Secure login for authorised {{config('customer.contact_details.booking_website_company_name')}} users</li>
      <li>Fully encrypted data transmission</li>
    </ul>

    <hr class="border-[var(--color-border)]">

    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">Review Mode (For App Reviewers Only)</h2>
    <ol class="list-decimal list-inside space-y-2">
      <li>On the initial provisioning screen, tap <strong>“Access Review Mode.”</strong><br>
        <em>This mode displays a clear banner across all screens indicating Review Mode.</em>
      </li>
      <li>The login screen is pre-filled with test credentials (fields are locked). Tap <strong>Login</strong> to continue.</li>
      <li>Choose any of the sample event or session items to reach the scan screen.</li>
    </ol>
    <p><em>Review Mode contains only dummy data and no personal information.</em></p>

  </div>
</section>
@endsection

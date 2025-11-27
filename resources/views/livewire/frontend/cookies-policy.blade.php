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
    <h1 class="text-4xl md:text-5xl font-bold mb-4">Cookies Policy</h1>
    <p class="text-lg text-white/90 mb-10">
      We take cookies and your privacy seriously.
    </p>
  </div>
</section>

<!-- ===== Content ===== -->
<section class="bg-[var(--color-bg)] py-16">
  <div class="text-sm text-left max-w-3xl mx-auto px-6 text-[var(--color-text)] leading-relaxed space-y-8">

    <p class="text-[var(--color-text-light)]">Last updated: <strong>November 2025</strong></p>

    <p>
      This Cookies Policy explains how <strong>{{ config('customer.contact_details.booking_website_company_name') }}</strong> 
      (“we”, “our”, or “us”) uses cookies and similar technologies on our website 
      (<a href="https://eventscan.co.uk" class="text-[var(--color-accent)] hover:text-[var(--color-text-muted)] transition">eventscan.co.uk</a>).
    </p>

    <hr class="border-[var(--color-border)]">

    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">1. What Are Cookies?</h2>
    <p>
      Cookies are small text files stored on your device by your browser when you visit a website.
      They help us provide a <strong>better and more secure experience</strong> by remembering preferences,
      improving performance, and collecting analytics data.
    </p>

    <hr class="border-[var(--color-border)]">

    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">2. Types of Cookies We Use</h2>
    <ul class="list-disc list-inside space-y-2">
      <li><strong>Essential Cookies</strong> — required for the site to function properly (e.g. session management, security).</li>
      <li><strong>Analytics Cookies</strong> — help us understand how visitors use our site so we can improve it (e.g. Google Analytics).</li>
      <li><strong>Preference Cookies</strong> — remember your settings or preferences, such as cookie consent.</li>
    </ul>

    <hr class="border-[var(--color-border)]">

    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">3. Managing Cookies</h2>
    <p>
      You can accept or reject non-essential cookies via our on-site cookie banner.
      Most browsers also let you control cookies through their settings.
      You can block or delete cookies if you wish, but this may affect some parts of our website.
    </p>
    <p>
      To learn more about managing cookies, visit:
      <a href="https://www.allaboutcookies.org/" target="_blank" 
         class="text-[var(--color-accent)] hover:text-[var(--color-text-muted)] transition">
         www.allaboutcookies.org
      </a>.
    </p>

    <hr class="border-[var(--color-border)]">

    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">4. Updates to This Policy</h2>
    <p>
      We may update this policy periodically. Any changes will be posted on this page
      with a new <strong>“last updated”</strong> date shown above.
    </p>

    <hr class="border-[var(--color-border)]">

    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">5. Contact</h2>
    <p>
      For questions about this policy or how we use cookies, please contact:
    </p>
    <p>
      <strong>{{ config('customer.contact_details.booking_website_company_name') }}</strong>
      Email: <strong>{{ config('customer.contact_details.booking_website_support_email') }}</strong>
    </p>

  </div>
</section>
@endsection

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
    <h1 class="text-4xl md:text-5xl font-bold mb-4">Privacy Policy</h1>
    <p class="text-lg text-white/90 mb-10">
      Your privacy and data security are important to us.
    </p>
  </div>
</section>

<section class="bg-[var(--color-bg)] py-16">
  <div class="text-sm text-left max-w-3xl mx-auto px-6 text-[var(--color-text)] leading-relaxed space-y-8">

    <p class="text-[var(--color-text-light)]">Last updated: <strong>November 2025</strong></p>

    <p>
      <strong>{{ client_setting('general.customer_friendly_name') }}</strong> (“we”, “our”, or “us”) respects your privacy and is committed to protecting your personal data. 
      This policy outlines how we collect, use, and protect information when you use our website and related services.
    </p>

    <hr class="border-[var(--color-border)]">

    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">1. Information We Collect</h2>
    <ul class="list-disc list-inside space-y-2">
      <li><strong>Contact details</strong> — such as name, email, or phone number, when you contact us or book a demo.</li>
      <li><strong>Usage data</strong> — including pages visited, actions taken, and general website interaction data collected via analytics tools.</li>
      <li><strong>Cookies</strong> — small text files used to enhance your experience (see our <a href="{{ route('cookies-policy') }}" class="text-[var(--color-accent)] hover:text-[var(--color-text-muted)] transition">Cookies Policy</a>).</li>
    </ul>

    <hr class="border-[var(--color-border)]">

    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">2. How We Use Your Information</h2>
    <ul class="list-disc list-inside space-y-2">
      <li>To respond to your enquiries or demo requests.</li>
      <li>To operate, maintain, and improve our website and services.</li>
      <li>To send relevant updates or information — only with your consent.</li>
    </ul>

    <hr class="border-[var(--color-border)]">

    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">3. Data Security</h2>
    <p>
      We use <strong>secure systems</strong> and follow <strong>best practices</strong> to protect your personal information.
      However, please note that no online transmission is completely secure, and you share data at your own risk.
    </p>

    <hr class="border-[var(--color-border)]">

    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">4. Your Rights</h2>
    <p>
      Under the <strong>UK GDPR</strong>, you have the right to access, correct, or request deletion of your personal data.
      To exercise these rights, contact us at:
    </p>
    <p><strong>Email:</strong> {{ client_setting('general.support_email') }}</p>

    <hr class="border-[var(--color-border)]">

    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">5. Contact</h2>
    <p>
      For any questions regarding this policy, please contact:
    </p>
    <p>
      <strong>{{ client_setting('general.customer_friendly_name') }}</strong><br>
      Registered in England & Wales<br>
      Email: <strong>{{ client_setting('general.support_email') }}</strong>
    </p>

  </div>
</section>
@endsection

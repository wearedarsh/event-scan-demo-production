<footer id="footer" class="bg-[var(--color-surface)] border-t border-[var(--color-border)] mt-20">
  <div class="max-w-6xl mx-auto px-6 py-16 grid grid-cols-1 md:grid-cols-3 gap-10 text-[var(--color-text-light)] text-sm">

    <!-- Secure Payments -->
    <div class="text-center md:text-left">
      <h3 class="text-[var(--color-text)] font-semibold mb-3">Secure Payments</h3>
      <img src="{{ asset('images/frontend/stripe.png') }}" alt="Stripe Secure Payments" class="h-8 inline-block opacity-80">
      <p class="mt-3 leading-relaxed">
        We accept all major cards via Stripe - your transactions are encrypted and protected.
      </p>
    </div>

    <!-- Questions / Contact -->
    <div class="text-center">
      <h3 class="text-[var(--color-text)] font-semibold mb-3">Questions?</h3>
      <p class="mb-2">Feel free to get in touch with any queries.</p>
      <p>
        <a href="mailto:{{ config('mail.contact_details.booking_website_support_email') }}" class="text-[var(--color-primary)] hover:underline font-medium">
          {{config('customer.contact_details.booking_website_support_email')}}
        </a>
      </p>
      <p class="mt-1 opacity-80">{{config('customer.contact_details.booking_website_phone_number')}}</p>
    </div>

    <!-- Company Info -->
    <div class="text-center md:text-right">
      <h3 class="text-[var(--color-text)] font-semibold mb-3">Company</h3>
      <p>{{config('customer.contact_details.booking_website_company_name')}}</p>
      {!! config('customer.contact_details.booking_website_company_details') !!}
    </div>
  </div>

  <!-- ===== Copyright Strip ===== -->
  <div class="border-t border-[var(--color-border)] bg-[var(--color-bg)]">
    <div class="max-w-6xl mx-auto px-6 py-4 flex flex-col md:flex-row items-center justify-between text-xs text-[var(--color-text-light)]">
      <p class="mb-2 md:mb-0">© {{config('customer.contact_details.booking_website_company_name')}} {{ date('Y') }}. All rights reserved.</p>

      <div class="flex items-center gap-6">
        <a href="{{route('privacy-policy')}}" class="hover:text-[var(--color-primary)] transition">Privacy Policy</a>
        <a href="{{route('cookies-policy')}}" class="hover:text-[var(--color-primary)] transition">Cookies</a>
      </div>
    </div>
  </div>
</footer>

<!-- Cookie banner -->
<div id="cookie-banner" class="fixed bottom-4 left-4 right-4 bg-[var(--color-surface)] border border-[var(--color-border)] rounded-xl p-4 flex flex-col md:flex-row items-center justify-between gap-4 shadow hidden z-50">
  <p class="text-[var(--color-text-light)] text-sm">We use cookies to improve your experience. See our <a href="/cookies.php" class="text-[var(--color-primary)] underline">Cookies Policy</a>.</p>
  <div class="flex gap-3">
    <button id="accept-cookies" class="px-4 py-2 rounded-lg text-white text-sm" style="background:var(--color-primary);">Accept</button>
    <a href="{{ route('cookies-policy')}}" class="px-4 py-2 rounded-lg border border-[var(--color-border)] text-sm text-[var(--color-text)]">Manage</a>
  </div>
</div>

<script>
  (function cookieBanner(){
    const banner = document.getElementById('cookie-banner');
    const acceptBtn = document.getElementById('accept-cookies');
    if (!banner || !acceptBtn) return;
    if (localStorage.getItem('cookiesAccepted')) return;
    banner.classList.remove('hidden');
    acceptBtn.addEventListener('click', function(){
      localStorage.setItem('cookiesAccepted', 'true');
      banner.classList.add('hidden');
    });
  })();
</script>


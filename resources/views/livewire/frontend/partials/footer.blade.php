<footer id="footer" class="bg-[var(--color-surface)] border-t border-[var(--color-border)] mt-20">
  <div class="max-w-6xl mx-auto px-6 py-16 grid grid-cols-1 md:grid-cols-3 gap-10 text-[var(--color-text-light)] text-sm">

    <div class="text-center md:text-left">
      {!! client_setting('booking.footer.right_column_html') !!}
    </div>

    <div class="text-center">
      {!! client_setting('booking.footer.middle_column_html') !!}
    </div>

    <div class="text-center md:text-right">
      {!! client_setting('booking.footer.right_column_html') !!}
    </div>
  </div>

  <div class="border-t border-[var(--color-border)] bg-[var(--color-bg)]">
    <div class="max-w-6xl mx-auto px-6 py-4 flex flex-col md:flex-row items-center justify-between text-xs text-[var(--color-text-light)]">
      <p class="mb-2 md:mb-0">&copy; {!! client_setting('general.customer_friendly_name') !!} {{ date('Y') }}. All rights reserved.</p>

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


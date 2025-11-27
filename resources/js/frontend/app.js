



// --- Google Analytics CTA tracking ---
function attachCtaTracking() {
  document.addEventListener('click', (e) => {
    if (typeof gtag === 'undefined') return;

    const el = e.target.closest('[data-cta]');
    if (!el) return;

    const label = el.getAttribute('data-cta');
    gtag('event', 'cta_click', {
      event_category: 'CTA',
      event_label: label,
      value: 1,
    });
  });
}

document.addEventListener('DOMContentLoaded', attachCtaTracking);
document.addEventListener('livewire:navigated', attachCtaTracking);


// --- Smooth Scrolling for anchor links ---
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const targetId = this.getAttribute('href').substring(1);
      const target = document.getElementById(targetId);
      if (target) {
        e.preventDefault();
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });
});




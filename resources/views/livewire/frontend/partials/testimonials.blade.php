<section id="testimonials"
  x-data="{ showAll: false }"
  class="relative py-20 bg-[var(--color-bg)]"
>
  <div class="max-w-6xl mx-auto px-6 text-center mb-12">
    {!! client_setting('booking.testimonial.header_html') !!}
  </div>

  @if($testimonials->isNotEmpty())
    <div class="max-w-6xl mx-auto grid gap-8 md:grid-cols-2 lg:grid-cols-3 px-6">
      @foreach($testimonials as $index => $testimonial)
        <div 
          x-show="showAll || {{ $index }} < 3"
          class="bg-[var(--color-surface)] rounded-2xl shadow-sm hover:shadow-md transition p-8 flex flex-col justify-between border border-[var(--color-border)]"
        >
          <div>
            <p class="text-[var(--color-text-light)] italic mb-6 leading-relaxed">
              “{{ Str::limit(strip_tags($testimonial->content), 400) }}”
            </p>
          </div>

          <div>
            <div class="flex justify-center mb-3">
              @for ($i = 1; $i <= 5; $i++)
                @if ($i <= $testimonial->star_rating)
                  <span class="text-[var(--color-accent)] text-xl">★</span>
                @else
                  <span class="text-[var(--color-border)] text-xl">★</span>
                @endif
              @endfor
            </div>
            <p class="font-semibold text-[var(--color-text)]">{{ $testimonial->title }}</p>
            @if($testimonial->sub_title)
              <p class="text-sm text-[var(--color-text-light)]">{{ $testimonial->sub_title }}</p>
            @endif
          </div>
        </div>
      @endforeach
    </div>

    {{-- View More link --}}
    @if($testimonials->count() > 3)
      <div class="mt-10 text-sm text-center">
        <button 
          @click="showAll = !showAll"
          class="font-semibold text-[var(--color-primary)] hover:underline focus:outline-none"
        >
          <span x-text="showAll ? 'View Less' : 'View More'"></span>
        </button>
      </div>
    @endif
  @else
    <div class="text-center text-sm text-[var(--color-text-light)] mt-16">
      No testimonials available yet.
    </div>
  @endif
</section>

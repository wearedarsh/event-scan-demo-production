<div>
  @include('livewire.frontend.partials.registration-nav')
  <!-- ===== Page Container ===== -->
  <main id="top" class="max-w-3xl mx-auto px-6 pt-16 md:pt-24 space-y-6">
      <!-- Alpine hydration bridge -->
      <div x-data="{
            init(){
                const registration_id = localStorage.getItem('registration_id');
                const user_id = localStorage.getItem('user_id');
 
                if(registration_id){
                    Livewire.dispatch('hydrateRegistration', {registration_id});
                }else{
                    Livewire.dispatch('initialiseRegistrationModel');
                }

                if(user_id){
                    Livewire.dispatch('hydrateUser', {user_id});
                }

            }
        }"
        x-init="init()"></div>

      <!-- ===== Event Summary / Toggle Panel ===== -->
      <div x-data="{ open: false }" class="mt-6 bg-[var(--color-surface)] border border-[var(--color-border)] rounded-xl shadow-sm p-4 md:p-6">
        <div class="flex items-center justify-between cursor-pointer" @click="open = !open">
          <h2 class="text-lg md:text-lg text-left font-bold text-[var(--color-secondary)]">{{ $event->title }}</h2>
          <button class="text-[var(--color-primary)] font-semibold text-xs ">
            <span x-text="open ? 'Hide details' : 'Show details'"></span>
          </button>
        </div>
        <div x-show="open" x-transition class="mt-2 text-sm text-left text-[var(--color-text-light)] space-y-1">
          <p>{{ $event->formatted_start_date }} – {{ $event->formatted_end_date }}</p>
          <p>{{ $event->location }}</p>
          <p>{{ $spaces_remaining }} spaces remaining</p>
        </div>
      </div>

      <!-- Steps -->
      <div wire:key="step-{{ $step }}">
        @include("livewire.frontend.steps.$step")
      </div>

  </main>
</div>


@extends('livewire.frontend.layouts.app')

@section('content')

@include('livewire.frontend.partials.nav')

<section class="relative flex items-center justify-center pt-40 pb-16 text-center overflow-hidden">
  <div class="absolute inset-0 bg-cover bg-center" 
       style="background-image:url('{{ asset('images/frontend/header-bg.jpg') }}');">
  </div>

  <div class="relative max-w-3xl mx-auto px-6 text-white z-10">
    {!! client_setting('legal.cookies.header_html') !!}
  </div>
</section>

<section class="bg-[var(--color-bg)] py-16">
  <div class="text-sm text-left max-w-3xl mx-auto px-6 text-[var(--color-text)] leading-relaxed space-y-8">

    {!! client_setting('legal.cookies.content_html') !!}
  </div>
</section>
@endsection

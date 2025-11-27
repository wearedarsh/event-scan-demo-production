<!doctype html>
<html lang="en">
    <head>
        @include('livewire.backend.customer.partials.head')
        <title>{{ $page_title ?? ''}}</title>
    </head>
    <style>
        html, body {
            max-width: 100%;
            overflow-x: hidden;
        }
    </style>
<body>

@include('livewire.backend.customer.partials.sidebar')

<div class="wrapper flex-grow-1 bg-brand-light-grey">
    
    @include('livewire.backend.customer.partials.header')
    
    <div class="d-flex flex-column min-vh-100 p-2">
        {{$slot}}
    </div>
    
</div>

@livewireScripts

<script>
  const toggleBtn = document.getElementById('sidebar-toggle');
  const htmlEl = document.documentElement;
  toggleBtn?.addEventListener('click', () => {
    htmlEl.classList.toggle('sidebar-collapsed');
  });
</script>



</body>
</html>

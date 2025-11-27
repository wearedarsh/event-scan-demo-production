<!doctype html>
<html lang="en">
    <head>
        @include('livewire.backend.admin.partials.head')
        <title>{{ $page_title ?? ''}}</title>
    </head>
    <style>
        html, body {
            max-width: 100%;
            overflow-x: hidden;
        }
    </style>
<body>

<div class="wrapper flex-grow-1 bg-brand-light-grey">
    
    <div class="d-flex flex-column min-vh-100 p-2">
        {{$slot}}
    </div>
    
</div>




</body>
</html>

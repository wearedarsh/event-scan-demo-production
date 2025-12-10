<!doctype html>
<html lang="en">

<head>
    @include('livewire.backend.admin.partials.head')
    <title>{{ $page_title ?? ''}}</title>
</head>
<style>
    html,
    body {
        max-width: 100%;
        overflow-x: hidden;
    }
</style>

<body>
    <div id="layout" class="min-h-screen flex relative">

        @include('livewire.backend.admin.partials.sidebar')

        <x-admin.overlay id="sidebar-backdrop" class="z-30" />

        <div id="main-content"
             class="flex-1 min-h-screen flex flex-col transition-all duration-300 overflow-x-hidden">

            @include('livewire.backend.admin.partials.header')

            <div class="flex flex-col min-h-screen p-2">
                {{ $slot }}
            </div>

        </div>

    </div>

    @livewireScripts
</body>


</html>
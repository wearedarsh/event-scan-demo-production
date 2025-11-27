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

@include('livewire.backend.admin.partials.sidebar')

<div id="main-content" class="flex-1 min-h-screen flex flex-col transition-all duration-300 ease-in-out">

    
    @include('livewire.backend.admin.partials.header')
    
    <div class="d-flex flex-column min-vh-100 p-2">
        {{$slot}}
    </div>
    
</div>

@livewireScripts

<script>
document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.getElementById("sidebar");
    const toggle = document.getElementById("sidebar-toggle");
    const main = document.getElementById("main-content");

    if (!sidebar || !toggle || !main) return;



    function updateInitialState() {
        if (window.innerWidth < 768) {
            // Mobile: sidebar closed by default
            sidebar.classList.add("-translate-x-64");
            sidebar.classList.remove("translate-x-0");

            main.classList.add("ml-0");
            main.classList.remove("ml-64");
        } else {
            // Desktop: only set the defaults IF user hasn't toggled it
            if (!sidebar.classList.contains("manual-toggle")) {
                sidebar.classList.remove("-translate-x-64");
                sidebar.classList.add("translate-x-0");

                main.classList.add("ml-64");
                main.classList.remove("ml-0");
            }
        }
    }

    // Initial load
    updateInitialState();

    toggle.addEventListener("click", () => {
        const isOpen = !sidebar.classList.contains("-translate-x-64");

        if (window.innerWidth < 768) {
            // MOBILE behaviour
            if (isOpen) {
                // close
                sidebar.classList.add("-translate-x-64");
                sidebar.classList.remove("translate-x-0");

                main.classList.remove("translate-x-64");
            } else {
                // open
                sidebar.classList.remove("-translate-x-64");
                sidebar.classList.add("translate-x-0");

                main.classList.add("translate-x-64"); // shift content right
            }

        } else {
            // DESKTOP behaviour
            sidebar.classList.toggle("-translate-x-64");
            sidebar.classList.toggle("translate-x-0");

            main.classList.toggle("ml-64");
            main.classList.toggle("ml-0");
        }
    });

    // Keep everything correct when resizing
    window.addEventListener("resize", updateInitialState);
});
</script>



</body>
</html>

document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.getElementById("sidebar");
    const backdrop = document.getElementById("sidebar-backdrop");
    const openBtn = document.getElementById("sidebar-toggle-open");
    const closeBtn = document.getElementById("sidebar-toggle-close");

    function openMobileSidebar() {
        sidebar.classList.remove("-translate-x-full");
        backdrop.classList.remove("opacity-0", "pointer-events-none");
    }

    function closeMobileSidebar() {
        sidebar.classList.add("-translate-x-full");
        backdrop.classList.add("opacity-0", "pointer-events-none");
    }

    openBtn?.addEventListener("click", openMobileSidebar);
    closeBtn?.addEventListener("click", closeMobileSidebar);
    backdrop?.addEventListener("click", closeMobileSidebar);
});

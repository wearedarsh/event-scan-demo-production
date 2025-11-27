<header class="header header-sticky">
        <div class="d-flex row w-100 m-0">
            <div class="col-6">
                <button class="header-toggler" type="button" id="sidebar-toggle">
                    <span class="header-toggler-icon d-flex flex-row align-items-center">
                        <span class="cil-menu me-2 text-brand-dark"></span>
                        <span class="fs-6 text-brand-dark"> Menu</span>
                    </span>
                </button>
            </div>
            <div class="d-flex col-6 justify-content-end">
                <a class="btn bg-brand-secondary w-auto" href="{{ route('logout') }}" target="_self">
                    <span class="d-flex align-items-center">
                        <span class="cil-account-logout me-2 text-brand-light"></span>
                        <span class="text-brand-light">Logout</span>
                    </span>
                </a>
            </div>
        </div>
</header>
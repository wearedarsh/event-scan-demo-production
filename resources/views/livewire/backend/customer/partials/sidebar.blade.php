<div class="sidebar sidebar-fixed sidebar-self-hiding-md bg-brand-primary" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-brand">
            <p class="text-brand-light">EVF HOW</p>
        </div>
    </div>
    <ul class="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('customer.dashboard') }}">
                <i class="nav-icon cil-home text-brand-light"></i> Dashboard
            </a>
        </li>
        <li class="nav-title">BOOKINGS</li>
        <li class="nav-item nav-group show">
            <a class="nav-link" href="{{ route('customer.bookings.index', ['user' => auth()->user()->id]) }}">
                <i class="nav-icon cil-tags text-brand-light"></i> Bookings
            </a>
        </li>


        <li class="nav-title">PROFILE</li>
        <li class="nav-item nav-group show">
            <a class="nav-link" href="{{ route('customer.profile.edit', ['user' => auth()->user()->id ]) }}">
                <i class="nav-icon cil-people text-brand-light"></i> Your profile
            </a>
        </li>


        <li class="nav-title">MARKETING</li>
        <li class="nav-item nav-group show">
            <a class="nav-link" href="{{ route('customer.profile.marketing.edit', ['user' => auth()->user()->id]) }}">
                <i class="nav-icon cil-bullhorn text-brand-light"></i> Your settings
            </a>
        </li>
    </ul>
</div>
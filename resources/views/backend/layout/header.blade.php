<header class="header">
    <div class="page-brand">
        <a class="link" href="{{ route('admin.dashboard') }}">
            <span class="brand">News
                <span class="brand-tip">App</span>
            </span>
            <span class="brand-mini">NA</span>
        </a>
    </div>
    <div class="flexbox flex-1">
        <ul class="nav navbar-toolbar">
            <li>
                <a class="nav-link sidebar-toggler js-sidebar-toggler"><i class="ti-menu"></i></a>
            </li>
        </ul>

        <ul class="nav navbar-toolbar">
            <li class="dropdown dropdown-user">
                <a class="nav-link dropdown-toggle link" data-toggle="dropdown">
                    <img src="{{ _user_profile() }}" alt="{{ _site_name() }}" height="30px" width="30px" />
                    <span></span>{{ auth()->user()->firstname.' '.auth()->user()->lastname }}<i class="fa fa-angle-down m-l-5"></i></a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="fa fa-user"></i>Profile</a>
                    <a class="dropdown-item" href="{{ route('admin.profile.change.password') }}"><i class="fa fa-cog"></i>Settings</a>
                    <li class="dropdown-divider"></li>
                    <a class="dropdown-item" href="{{ route('admin.logout') }}"><i class="fa fa-power-off"></i>Logout</a>
                </ul>
            </li>
        </ul>
    </div>
</header>

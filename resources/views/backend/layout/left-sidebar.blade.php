<nav class="page-sidebar" id="sidebar">
    <div id="sidebar-collapse">
        <div class="admin-block d-flex">
            <div>
                <img src="{{ asset('backend/img/admin-avatar.png') }}" width="45px" />
            </div>
            <div class="admin-info">
                <div class="font-strong">{{ auth()->user()->firstname.' '.auth()->user()->lastname }}</div><small>{{ _get_role_name() }}</small>
            </div>
        </div>
        <ul class="side-menu metismenu">
            @canany(['role-create', 'role-edit', 'role-view', 'role-delete', 'permission-create', 'permission-edit', 'permission-view', 'permission-delete'])
                <li class="{{ Request::is('dashboard*') ? 'active' : '' }}">
                    <a class="active" href="{{ route('admin.dashboard') }}"><i class="sidebar-item-icon fa fa-th-large"></i>
                        <span class="nav-label">Dashboard</span>
                    </a>
                </li>
                <li class="{{ (Request::is('role*') || Request::is('permission*')) ? 'active' : '' }}">
                    <a href="javascript:;"><i class="sidebar-item-icon fa fa-universal-access"></i>
                        <span class="nav-label">Access Control</span><i class="fa fa-angle-left arrow"></i>
                    </a>
                    <ul class="nav-2-level collapse">
                        @canany(['role-create', 'role-edit', 'role-view', 'role-delete'])
                            <li>
                                <a class="{{ Request::is('role*') ? 'active' : '' }}" href="{{ route('admin.role') }}"><i class="sidebar-item-icon fa fa-male"></i>
                                    <span class="nav-label">Roles</span>
                                </a>
                            </li>
                        @endcanany
                        @canany(['permission-create', 'permission-edit', 'permission-view', 'permission-delete'])
                            <li>
                                <a class="{{ Request::is('permission*') ? 'active' : '' }}" href="{{ route('admin.permission') }}"><i class="sidebar-item-icon fa fa-asterisk"></i>
                                    <span class="nav-label">Permissions</span>
                                </a>
                            </li>
                        @endcanany
                    </ul>
                </li>
            @endcanany

            @canany(['country-create', 'country-edit', 'country-view', 'country-delete', 'state-create', 'state-edit', 'state-view', 'state-delete', 'city-create', 'city-edit', 'city-view', 'city-delete'])
                <li class="{{ (Request::is('country*') || Request::is('state*') || Request::is('city*')) ? 'active' : '' }}">
                    <a href="javascript:;"><i class="sidebar-item-icon fa fa-globe"></i>
                        <span class="nav-label">Region</span><i class="fa fa-angle-left arrow"></i>
                    </a>
                    <ul class="nav-2-level collapse">
                        @canany(['country-create', 'country-edit', 'country-view', 'country-delete'])
                            <li>
                                <a class="{{ Request::is('country*') ? 'active' : '' }}" href="{{ route('admin.country') }}">
                                    <i class="sidebar-item-icon fa fa-globe"></i>
                                    <span class="nav-label">Country</span>
                                </a>
                            </li>
                        @endcanany
                        @canany(['country-create', 'country-edit', 'country-view', 'country-delete', 'state-create', 'state-edit', 'state-view', 'state-delete'])
                            <li>
                                <a class="{{ Request::is('state*') ? 'active' : '' }}" href="{{ route('admin.state') }}">
                                    <i class="sidebar-item-icon fa fa-globe"></i>
                                    <span class="nav-label">State</span>
                                </a>
                            </li>
                        @endcanany
                        @canany(['city-create', 'city-edit', 'city-view', 'city-delete'])
                            <li>
                                <a class="{{ Request::is('city*') ? 'active' : '' }}" href="{{ route('admin.city') }}">
                                    <i class="sidebar-item-icon fa fa-globe"></i>
                                    <span class="nav-label">City</span>
                                </a>
                            </li>
                        @endcanany
                    </ul>
                </li>
            @endcanany

            @canany(['reporter-create', 'reporter-edit', 'reporter-view', 'reporter-delete'])
                <li>
                    <a class="{{ Request::is('reporter*') ? 'active' : '' }}" href="{{ route('admin.reporter') }}">
                        <i class="sidebar-item-icon fa fa-user"></i>
                        <span class="nav-label">Reporter</span>
                    </a>
                </li>
            @endcanany
        </ul>
    </div>
</nav>

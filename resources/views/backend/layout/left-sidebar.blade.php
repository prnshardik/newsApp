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
            <li class="{{ Request::is('dashboard*') ? 'active' : '' }}">
                <a class="active" href="{{ route('admin.dashboard') }}"><i class="sidebar-item-icon fa fa-th-large"></i>
                    <span class="nav-label">Dashboard</span>
                </a>
            </li>
            <li class="heading">Access Control</li>
            <li class="{{ (Request::is('role*') || Request::is('permission*')) ? 'active' : '' }}">
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-universal-access"></i>
                    <span class="nav-label">Access Control</span><i class="fa fa-angle-left arrow"></i>
                </a>
                <ul class="nav-2-level collapse">
                    <li class="{{ Request::is('role*') ? 'active' : '' }}">
                        <a class="active" href="{{ route('admin.role') }}"><i class="sidebar-item-icon fa fa-male"></i>
                            <span class="nav-label">Roles</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('permission*') ? 'active' : '' }}">
                        <a class="active" href="{{ route('admin.permission') }}"><i class="sidebar-item-icon fa fa-asterisk"></i>
                            <span class="nav-label">Permissions</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{ Request::is('country*') ? 'active' : '' }}">
                <a class="active" href="{{ route('admin.country') }}"><i class="sidebar-item-icon fa fa-building"></i>
                    <span class="nav-label">Country</span>
                </a>
            </li>
            <li class="{{ Request::is('state*') ? 'active' : '' }}">
                <a class="active" href="{{ route('admin.state') }}"><i class="sidebar-item-icon fa fa-university"></i>
                    <span class="nav-label">State</span>
                </a>
            </li>
            <li class="{{ Request::is('city*') ? 'active' : '' }}">
                <a class="active" href="{{ route('admin.city') }}"><i class="sidebar-item-icon fa fa-home"></i>
                    <span class="nav-label">City</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

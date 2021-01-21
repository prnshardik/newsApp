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
            <li>
                <a class="active" href="{{ route('admin.dashboard') }}"><i class="sidebar-item-icon fa fa-th-large"></i>
                    <span class="nav-label">Dashboard</span>
                </a>
            </li>
            <li class="heading">FEATURES</li>
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-bookmark"></i>
                    <span class="nav-label">Basic UI</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="javascript:;">Colors</a>
                    </li>
                    <li>
                        <a href="javascript:;">Typography</a>
                    </li>
                    <li>
                        <a href="javascript:;">Panels</a>
                    </li>
                    <li>
                        <a href="javascript:;">Buttons</a>
                    </li>
                    <li>
                        <a href="javascript:;">Tabs</a>
                    </li>
                    <li>
                        <a href="javascript:;">Alerts &amp; Tooltips</a>
                    </li>
                    <li>
                        <a href="javascript:;">Badges &amp; Progress</a>
                    </li>
                    <li>
                        <a href="javascript:;">List</a>
                    </li>
                    <li>
                        <a href="javascript:;">Card</a>
                    </li>
                </ul>
            </li>
            {{-- <li>
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-edit"></i>
                    <span class="nav-label">Forms</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="javascript:;">Basic Forms</a>
                    </li>
                    <li>
                        <a href="javascript:;">Advanced Plugins</a>
                    </li>
                    <li>
                        <a href="javascript:;">Form input masks</a>
                    </li>
                    <li>
                        <a href="javascript:;">Form Validation</a>
                    </li>
                    <li>
                        <a href="javascript:;">Text Editors</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-table"></i>
                    <span class="nav-label">Tables</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="javascript:;">Basic Tables</a>
                    </li>
                    <li>
                        <a href="javascript:;">Datatables</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-bar-chart"></i>
                    <span class="nav-label">Charts</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="javascript:;">Flot Charts</a>
                    </li>
                    <li>
                        <a href="javascript:;">Morris Charts</a>
                    </li>
                    <li>
                        <a href="javascript:;">Chart.js</a>
                    </li>
                    <li>
                        <a href="javascript:;">Sparkline Charts</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-map"></i>
                    <span class="nav-label">Maps</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="javascript:;">Vector maps</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-smile-o"></i>
                    <span class="nav-label">Icons</span>
                </a>
            </li>
            <li class="heading">PAGES</li>
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-envelope"></i>
                    <span class="nav-label">Mailbox</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="javascript:;">Inbox</a>
                    </li>
                    <li>
                        <a href="javascript:;">Mail view</a>
                    </li>
                    <li>
                        <a href="javascript:;">Compose mail</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-calendar"></i>
                    <span class="nav-label">Calendar</span>
                </a>
            </li>
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-file-text"></i>
                    <span class="nav-label">Pages</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="javascript:;">Invoice</a>
                    </li>
                    <li>
                        <a href="javascript:;">Profile</a>
                    </li>
                    <li>
                        <a href="javascript:;">Login</a>
                    </li>
                    <li>
                        <a href="javascript:;">Register</a>
                    </li>
                    <li>
                        <a href="javascript:;">Lockscreen</a>
                    </li>
                    <li>
                        <a href="javascript:;">Forgot password</a>
                    </li>
                    <li>
                        <a href="javascript:;">404 error</a>
                    </li>
                    <li>
                        <a href="javascript:;">500 error</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-sitemap"></i>
                    <span class="nav-label">Menu Levels</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="javascript:;">Level 2</a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <span class="nav-label">Level 2</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-3-level collapse">
                            <li>
                                <a href="javascript:;">Level 3</a>
                            </li>
                            <li>
                                <a href="javascript:;">Level 3</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li> --}}
        </ul>
    </div>
</nav>

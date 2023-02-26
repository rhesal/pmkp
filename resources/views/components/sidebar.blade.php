<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ route('home') }}">Stisla</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">St</a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
        <li class="nav-item dropdown {{ $type_menu === 'dashboard' ? 'active' : '' }}">
            <a href="#"
                class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            <ul class="dropdown-menu">
                <li class='{{ Request::is('dashboard-general-dashboard') ? 'active' : '' }}'>
                    <a class="nav-link"
                        href="{{ url('dashboard-general-dashboard') }}">General Dashboard</a>
                </li>
                <li class="{{ Request::is('dashboard-ecommerce-dashboard') ? 'active' : '' }}">
                    <a class="nav-link"
                        href="{{ url('dashboard-ecommerce-dashboard') }}">Ecommerce Dashboard</a>
                </li>
            </ul>
        </li>
        @can('index-user')
            <li class="nav-item dropdown {{ $type_menu === 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('user.index') }}" class="nav-link"><i class="fas fa-users"></i><span>User List</span></a>
            </li>
        @endcan 
        <li class="menu-header">Starter</li>
        <li class="nav-item dropdown {{ $type_menu === 'layout' ? 'active' : '' }}">
            <a href="#"
                class="nav-link has-dropdown"
                data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Layout</span></a>
            <ul class="dropdown-menu">
                <li class="{{ Request::is('layout-default-layout') ? 'active' : '' }}">
                    <a class="nav-link"
                        href="{{ url('layout-default-layout') }}">Default Layout</a>
                </li>
                <li class="{{ Request::is('transparent-sidebar') ? 'active' : '' }}">
                    <a class="nav-link"
                        href="{{ url('transparent-sidebar') }}">Transparent Sidebar</a>
                </li>
                <li class="{{ Request::is('layout-top-navigation') ? 'active' : '' }}">
                    <a class="nav-link"
                        href="{{ url('layout-top-navigation') }}">Top Navigation</a>
                </li>
            </ul>
        </li>
    </ul>

    <div class="hide-sidebar-mini mt-4 mb-4 p-3">
        <a href="https://getstisla.com/docs"
            class="btn btn-primary btn-lg btn-block btn-icon-split">
            <i class="fas fa-rocket"></i> Documentation
        </a>
    </div>
</aside>

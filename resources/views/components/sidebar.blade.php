<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        {{-- <a href="{{ route('home') }}">SI-IMUT</a> --}}
        <img src="{{ asset('img/Logo_SIIMUT_V2(no_bg).png') }}"
        alt="logo"
        width="100"
        class="shadow-light rounded-circle">
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">SI</a>
    </div>
    <ul class="sidebar-menu">
        @can('home')
        <li class="menu-header">Dashboard</li>
        <li class="nav-item dropdown {{ $type_menu === 'dashboard' ? 'active' : '' }}">
            <a href="#"
                class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            <ul class="dropdown-menu">
                <li class='{{ Request::is('dashboard') ? 'active' : '' }}'>
                    <a class="nav-link" href="{{ route('dashboard') }}">General Dashboard</a>
                </li>
                <li class="{{ Request::is('home') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('home') }}"">Progres Penilaian</a>
                </li>
            </ul>
        </li>
        @endcan
        @can('indikators')
        <li class="menu-header">Data Master</li>
        <li class="{{ Request::is('indikator') ? 'active' : '' }}">
            <a href="{{ route('indikator.index') }}" class="nav-link"><i class="fas fa-clipboard-list"></i><span>Rekap Indikator</span></a>
        </li>
        @endcan
        @can('units')
        <li class="{{ Request::is('unit') ? 'active' : '' }}">
            <a href="{{ route('unit.index') }}" class="nav-link"><i class="fas fa-boxes-stacked"></i><span>Units</span></a>
        </li>
        @endcan
        @can('users')
        <li class="{{ Request::is('user') ? 'active' : '' }}">
            <a href="{{ route('user.index') }}" class="nav-link"><i class="fas fa-users"></i><span>User List</span></a>
        </li>
        @endcan
    </ul>
</aside>

<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ route('home') }}">PMKP</a>
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
        <li class="">
            <a href="" class="nav-link"><i class="fas fa-clipboard-check"></i> <span>Indikator Mutu</span></a> 
        </li>
        @can('index-user')
        <li class="menu-header">Data Master</li>       
        <li class="{{ Request::route('indikator.index') ? 'active' : '' }}">
            <a href="{{ route('indikator.index') }}" class="nav-link"><i class="fas fa-clipboard-list"></i> <span>Indikator</span></a> 
        </li>
        <li class="nav-item">
            <a href="{{ route('unit.index') }}" class="nav-link"><i class="fas fa-boxes-stacked"></i> <span>Units</span></a>                 
        </li>
        <li class="nav-item">
            <a href="{{ route('user.index') }}" class="nav-link"><i class="fas fa-users"></i><span>User List</span></a>
        </li>
        @endcan 
    </ul>
</aside>

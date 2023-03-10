<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ route('home') }}">SI-IMUT</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">SI</a>
    </div>
    <ul class="sidebar-menu">
        @can('pages')         
        <li class="menu-header">Dashboard</li>
        <li class="nav-item dropdown {{ $type_menu === 'dashboard' ? 'active' : '' }}">
            <a href="{{ route('home') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
        </li>
        @endcan
        <li class="">
            <a href="{{ route('penilaian.index') }}" class="nav-link"><i class="fas fa-clipboard-check"></i> <span>Penilaian Mutu</span></a> 
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

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
        <li class="menu-header" style="font-size: 12px">Dashboard</li>
        <li class="nav-item dropdown {{ $type_menu === 'dashboard' ? 'active' : '' }}">
            <a href="{{ route('home') }}" class="nav-link"><i class="fas fa-fire"></i><span style="font-size: 18px">Dashboard</span></a>
        </li>
        @endcan
        @can('home')
        <li class="">
            <a href="{{ route('penilaian.index') }}" class="nav-link"><i class="fas fa-clipboard-check"></i><span style="font-size: 18px">Penilaian Mutu</span></a>
        </li>
        @endcan
        @can('indikators')
        <li class="menu-header" style="font-size: 12px">Data Master</li>
        <li class="{{ Request::route('indikator.index') ? 'active' : '' }}">
            <a href="{{ route('indikator.index') }}" class="nav-link"><i class="fas fa-clipboard-list"></i><span style="font-size: 18px">Rekap Indikator</span></a>
        </li>
        @endcan
        @can('units')
        <li class="nav-item">
            <a href="{{ route('unit.index') }}" class="nav-link"><i class="fas fa-boxes-stacked"></i><span style="font-size: 18px">Units</span></a>
        </li>
        @endcan
        @can('users')
        <li class="nav-item">
            <a href="{{ route('user.index') }}" class="nav-link"><i class="fas fa-users"></i><span style="font-size: 18px">User List</span></a>
        </li>
        @endcan
    </ul>
</aside>

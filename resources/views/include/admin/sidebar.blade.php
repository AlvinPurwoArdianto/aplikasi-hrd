<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('home') }}" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bolder ms-2">APLIKASI - HRD</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ url()->current() == route('home') ? 'active' : '' }}">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Pages</span>
        </li>
        <li
            class="menu-item {{ request()->routeIs('pegawai.*') || request()->routeIs('jabatan.*') ? 'active menu-open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tmenu-icon tf-icons bx bx-user" class="menu-item "></i>
                <div data-i18n="Authentications">Employee</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('jabatan.index') ? 'active' : '' }}">
                    <a href="{{ route('jabatan.index') }}" class="menu-link">
                        <div data-i18n="Basic">Jabatan</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('pegawai.index') ? 'active' : '' }}">
                    <a href="{{ route('pegawai.index') }}" class="menu-link">
                        <div data-i18n="Basic">Pegawai</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>

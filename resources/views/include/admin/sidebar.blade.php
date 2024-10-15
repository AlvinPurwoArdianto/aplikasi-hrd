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
                <i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text"><strong>Menu</strong></span>
        </li>
        <li
            class="menu-item {{ request()->routeIs('pegawai.*') || request()->routeIs('jabatan.*') ? 'active menu-open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tmenu-icon tf-icons bx bx-user" class="menu-item "></i>
                <div data-i18n="Authentications">Karyawan</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('jabatan.*') ? 'active' : '' }}">
                    <a href="{{ route('jabatan.index') }}" class="menu-link">
                        <div data-i18n="Basic">Jabatan</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('pegawai.*') ? 'active' : '' }}">
                    <a href="{{ route('pegawai.index') }}" class="menu-link">
                        <div data-i18n="Basic">Pegawai</div>
                    </a>
                </li>
            </ul>
        </li>
        <li
            class="menu-item {{ request()->routeIs('absensi.*') || request()->routeIs('cuti.*') ? 'active menu-open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tmenu-icon tf-icons bx bx-calendar" class="menu-item "></i>
                <div data-i18n="Authentications">Absensi</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('absensi.*') ? 'active' : '' }}">
                    <a href="{{ route('absensi.index') }}" class="menu-link">
                        <div data-i18n="Analytics">Absen</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('cuti.*') ? 'active' : '' }}">
                    <a href="{{ route('cuti.index') }}" class="menu-link">
                        <div data-i18n="Basic">Cuti</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ url()->current() == route('penggajian.index') ? 'active' : '' }}">
            <a href="{{ route('penggajian.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-wallet"></i>
                <div data-i18n="Analytics">Penggajian</div>
            </a>
        </li>
        <li class="menu-item {{ url()->current() == route('rekrutmen.index') ? 'active' : '' }}">
            <a href="{{ route('rekrutmen.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Analytics">Rekrutmen</div>
            </a>
        </li>
        <li class="menu-item"> {{-- {{ url()->current() == route('laporan.index') ? 'active' : '' }} > --}}
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-clipboard"></i>
                <div data-i18n="Analytics">Kinerja</div>
            </a>
        </li>
        <li class="menu-item"> {{-- {{ url()->current() == route('laporan.index') ? 'active' : '' }} > --}}
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Laporan</div>
            </a>
        </li>
    </ul>
</aside>

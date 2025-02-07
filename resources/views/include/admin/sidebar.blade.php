
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-dark-theme shadow-lg rounded">
    <div class="app-brand demo py-3 px-4 d-flex align-items-center justify-content-between">
        <a href="{{ route('home') }}" class="app-brand-link d-flex align-items-center">
            <i class="bx bx-buildings fs-3 text-light"></i>
            <span class="app-brand-text demo menu-text fw-bold ms-2 text-light">APLIKASI - HRD</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle text-light"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-2">
        <li class="menu-item {{ url()->current() == route('home') ? 'active' : '' }}">
            <a href="{{ route('home') }}" class="menu-link text-light">
                <i class="menu-icon tf-icons bx bx-bar-chart-alt-2 text-success"></i> <!-- Icon with green color -->
                <div>Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase text-light"><span>Menu Master</span></li>

        <li class="menu-item {{ request()->routeIs('pegawai.*') || request()->routeIs('jabatan.*') ? 'active menu-open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle text-light">
                <i class="menu-icon tf-icons bx bx-user-pin text-info"></i> <!-- Icon with blue color -->
                <div>Management Karyawan</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('pegawai.admin') ? 'active' : '' }}">
                    <a href="{{ route('pegawai.admin') }}" class="menu-link text-light">
                        <div>Akun Admin</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('jabatan.*') ? 'active' : '' }}">
                    <a href="{{ route('jabatan.index') }}" class="menu-link text-light">
                        <div>Jabatan</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('pegawai.*') && !request()->routeIs('pegawai.admin') ? 'active' : '' }}">
                    <a href="{{ route('pegawai.index') }}" class="menu-link text-light">
                        <div>Pegawai</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ url()->current() == route('penggajian.index') ? 'active' : '' }}">
            <a href="{{ route('penggajian.index') }}" class="menu-link text-light">
                <i class="menu-icon tf-icons bx bx-wallet text-primary"></i> <!-- Icon with blue color -->
                <div>Penggajian</div>
            </a>
        </li>

        <li class="menu-item {{ url()->current() == route('rekrutmen.index') ? 'active' : '' }}">
            <a href="{{ route('rekrutmen.index') }}" class="menu-link text-light">
                <i class="menu-icon tf-icons bx bx-group text-warning"></i> <!-- Icon with yellow color -->
                <div data-i18n="Analytics">Rekrutmen</div>
            </a>
        </li>

        <li class="menu-item {{ url()->current() == route('cuti.menu') ? 'active' : '' }}">
            <a href="{{ route('cuti.menu') }}" class="menu-link d-flex justify-content-between align-items-center text-light">
                <div class="d-flex align-items-center">
                    <i class="menu-icon bx bx-user-check text-danger"></i> <!-- Icon with red color -->
                    <span>Aprove Cuti</span>
                </div>
                @if (isset($cutiNotifications) && $cutiNotifications->count() > 0)
                    <span class="badge bg-danger">{{ $cutiNotifications->count() }}</span>
                @endif
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('izin.sakit') ? 'active' : '' }}">
            <a href="{{ route('izin.sakit') }}" class="menu-link d-flex justify-content-between align-items-center text-light">
                <div class="d-flex align-items-center">
                    <i class="menu-icon bx bx-plus-medical text-success"></i>
                    <span>Izin Sakit</span>
                </div>
                <span id="izin-sakit-notif" class="badge bg-danger" style="display: none;"></span>
            </a>
        </li>
        
        
        

        <li class="menu-item {{ url()->current() == route('berkas.index') ? 'active' : '' }}">
            <a href="{{ route('berkas.index') }}" class="menu-link text-light">
                <i class="menu-icon bx bx-paperclip text-purple"></i> <!-- Icon with purple color -->
                <div>Berkas Pribadi</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase text-light"><span>Data Laporan</span></li>

        <li class="menu-item {{ request()->routeIs('laporan.*') ? 'active menu-open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle text-light">
                <i class="menu-icon tf-icons bx bxs-report text-info"></i> <!-- Icon with blue color -->
                <div>Laporan</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('laporan.pegawai') ? 'active' : '' }}">
                    <a href="{{ route('laporan.pegawai') }}" class="menu-link text-light">
                        <div>Laporan Pegawai</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('laporan.absensi') ? 'active' : '' }}">
                    <a href="{{ route('laporan.absensi') }}" class="menu-link text-light">
                        <div>Laporan Absen</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('laporan.cuti') ? 'active' : '' }}">
                    <a href="{{ route('laporan.cuti') }}" class="menu-link text-light">
                        <div>Laporan Cuti</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>

<style>
    /* Dark theme styles */
    .bg-dark-theme {
        background-color: #333;
        color: #fff;
    }
    .menu-link {
        color: #fff;
    }
    .menu-item.active .menu-link,
    .menu-item:hover .menu-link {
        background-color: #444;
        color: #fff;
    }
    .menu-header {
        color: #aaa;
    }
    .menu-sub .menu-item {
        background-color: #444;
    }
    .menu-sub .menu-item.active .menu-link {
        background-color: #555;
    }
    .badge.bg-danger {
        background-color: #e74c3c;
    }
</style>



    <!-- Add AJAX Script Here -->
    <script>
        // Fungsi untuk memeriksa notifikasi baru setiap 5 detik
        function checkNotifications() {
            $.ajax({
                url: '{{ route('cuti.notifications') }}', // Route untuk mengambil jumlah notifikasi
                type: 'GET',
                success: function(response) {
                    // Update jumlah notifikasi di menu
                    if (response.count > 0) {
                        $('#notification-count').text(response.count).show();
                    } else {
                        $('#notification-count').hide();
                    }
                },
                error: function() {
                    console.log('Gagal memuat notifikasi');
                }
            });
        }

        // Memanggil fungsi setiap 5 detik
        setInterval(checkNotifications, 5000);
    </script>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
       function updateIzinSakitNotif() {
           $.ajax({
               url: '{{ route('izin.sakit.notif') }}',
               type: 'GET',
               success: function(response) {
                   let notifBadge = $('#izin-sakit-notif');
                   if (response.count > 0) {
                       notifBadge.text(response.count).show();
                   } else {
                       notifBadge.hide();
                   }
               },
               error: function() {
                   console.log('Gagal memuat notifikasi izin sakit');
               }
           });
       }
   
       // Jalankan saat halaman dimuat
       $(document).ready(function() {
           updateIzinSakitNotif();
           setInterval(updateIzinSakitNotif, 5000); // Cek setiap 5 detik
       });
   </script>
   
    
    
  {{-- <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Data Backup</span>
        </li>
        <li class="menu-item">
            <a href="{{ route('izin.sakit') }}" class="menu-link">
                <i class="menu-icon bx bx-export"></i>
                <div data-i18n="Basic">
                    Backup Database
                </div>
            </a>
        </li> --}}
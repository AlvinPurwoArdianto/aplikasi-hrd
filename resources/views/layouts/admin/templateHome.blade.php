<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Aplikasi HRD</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('admin/assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('admin/assets/vendor/js/helpers.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('admin/assets/js/config.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <!-- Toast Untuk Success -->
    @if (session('success'))
        <div class="bs-toast toast toast-placement-ex m-2 bg-success top-0 end-0 fade show toast-custom" role="alert"
            aria-live="assertive" aria-atomic="true" id="toastSuccess">
            <div class="toast-header">
                <i class="bi bi-check-circle me-2"></i>
                <div class="me-auto fw-semibold">Success</div>
                <small>Just Now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('success') }}
            </div>
        </div>
    @endif
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- BAGIAN SIDEBAR -->

            @include('include.admin.sidebar')

            <!-- / BAGIAN SIDEBAR -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- INI BAGIAN HEADER -->

                @include('include.admin.header')

                <!-- / INI BAGIAN HEADER -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="col-lg-8 mb-4 order-0">
                                <div class="card">
                                    <div class="d-flex align-items-end row">
                                        <div class="col-sm-7">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary">Welcome Back
                                                    <b>{{ Auth::user()->name }}</b> 🎉
                                                </h5>
                                                <p class="mb-4">
                                                    Ini Adalah Halaman Utama <span class="fw-bold">Aplikasi HRD.</span>
                                                    <br>
                                                    Silahkan Cek Menu Menu Disini Untuk Melihat Informasi Yang Tersedia.
                                                </p>
                                            </div>
                                        </div>
                                        <div
                                            class="col-sm-5
                                                        text-center text-sm-left">
                                            <div class="card-body pb-0 px-0 px-md-4">
                                                <img src="assets/img/illustrations/man-with-laptop-light.png"
                                                    height="140" alt="View Badge User"
                                                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 order-1">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div
                                                    class="card-title d-flex align-items-start justify-content-between">
                                                    <div class="avatar flex-shrink-0">
                                                        <small class="text-warning fw-semibold">
                                                            <i class='bx bxs-user-circle' style="font-size: 50px"></i>
                                                        </small>
                                                    </div>
                                                </div>
                                                <span>Pegawai</span>
                                                <div class="row pt-2">
                                                    <div class="col">
                                                        <h3 class="card-title text-nowrap">
                                                            {{ $totalPegawai }}
                                                        </h3>
                                                    </div>
                                                    <div class="col"><a href="{{ route('pegawai.index') }}"
                                                            class="btn btn-primary btn-sm">Lihat</a></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div
                                                    class="card-title d-flex align-items-start justify-content-between">
                                                    <div class="avatar flex-shrink-0">
                                                        <small class="text-primary fw-semibold">
                                                            <i class='bx bxs-wallet' style="font-size: 50px"></i>
                                                        </small>
                                                    </div>
                                                </div>
                                                <span>Gaji Keseluruhan</span>
                                                <h3 class="card-title text-nowrap mb-1 mt-3">
                                                    {{ $totalPenggajian }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- DIBAWAH INI ADALAH UNTUK BAHAN SELANJUTNYA --}}
                        <style>
    .chart-container {
        display: flex;
        justify-content: space-between;
    }

    .chart-box {
        width: 48%; /* Adjusts width to fit side by side */
    }

    canvas {
        max-height: 300px; /* Maintain consistent chart size */
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="compact-form-group">
                        <h5 class="card-title">Pengeluaran Perusahaan dari Penggajian ({{ $selectedYear }})</h5>
                        
                        <!-- Year Selection Dropdown -->
                        <form method="GET" action="{{ route('home') }}" style="margin-left: auto;">
                            <label for="year">Tahun:</label>
                            <select id="year" name="year" onchange="this.form.submit()">
                                @foreach($availableYears as $year)
                                    <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>

                    <div class="chart-container">
                        <!-- Expenditure Chart -->
                        <div class="chart-box">
                            <canvas id="pengeluaranChart"></canvas>
                        </div>

                        <!-- Growth Percentage Chart -->
                        <div class="chart-box">
                            <canvas id="growthChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx1 = document.getElementById('pengeluaranChart').getContext('2d');
        var ctx2 = document.getElementById('growthChart').getContext('2d');

        var labels = {!! json_encode(array_keys($allMonths)) !!}; // e.g., January, February...
        var data = {!! json_encode(array_values($allMonths)) !!}; // Pengeluaran per bulan

        // Expenditure Chart
        var pengeluaranChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Pengeluaran (Rp) - ' + '{{ $selectedYear }}',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Growth Percentage Chart
        var growthLabels = {!! json_encode(array_keys($growthData)) !!}; // e.g., Previous Year, Current Year
        var growthData = {!! json_encode(array_values($growthData)) !!}; // Growth percentages

        var growthChart = new Chart(ctx2, {
            type: 'line', // Change to line chart for growth
            data: {
                labels: growthLabels,
                datasets: [{
                    label: 'Growth (%)',
                    data: growthData,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Growth (%)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Years'
                        }
                    }
                }
            }
        });
    });
</script>


                        
``                        
                        
                        INI BUAT CHART DAN LAIN LAIN
                    </div>

                    <!-- / Content -->

                    <!-- Footer -->
                    @include('include.admin.footer')
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('admin/assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('admin/assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('admin/assets/js/dashboards-analytics.js') }}"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    {{-- UNTU TOAST 1.5 DETIK --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toastSuccess = document.getElementById('toastSuccess');
            const toastError = document.getElementById('toastError');

            if (toastSuccess) {
                setTimeout(function() {
                    toastSuccess.classList.add('toast-hide');
                }, 2000);
            }

            if (toastError) {
                setTimeout(function() {
                    toastError.classList.add('toast-hide');
                }, 2000);
            }
        });
    </script>
</body>

</html>

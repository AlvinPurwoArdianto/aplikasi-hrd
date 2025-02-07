<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('user/assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('user/assets/img/favicon.png') }}">
    <title>
        Argon Dashboard 2 by Creative Tim
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('user/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('user/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js')}}" crossorigin="anonymous"></script>
    <link href="{{ asset('user/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('user/assets/css/argon-dashboard.css?v=2.0.4') }}" rel="stylesheet" />

    {{-- calender --}}
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js'></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        .bg-primary {
            background-color: #0d6efd !important;
        }

        .text-white {
            color: #ffffff !important;
        }
    </style>


</head>

<body class="g-sidenav-show   bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>

    {{-- awal sidebar --}}
    @include('include.user.sidebar')
    {{-- akhir sidebar --}}


    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        @include('include.user.navbar')

        @yield('content')

        {{-- end calender --}}

        {{-- Footer --}}
        @include('include.user.footer')
        {{-- / Footer --}}
        </div>
    </main>

    <!--   Core JS Files   -->
    <script src="{{ asset('user/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('user/assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('user/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('user/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('user/assets/js/plugins/chartjs.min.js') }}"></script>
    <script>
        var ctx1 = document.getElementById("chart-line").getContext("2d");

        var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

        gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
        gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
        new Chart(ctx1, {
            type: "line",
            data: {
                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Mobile apps",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#5e72e4",
                    backgroundColor: gradientStroke1,
                    borderWidth: 3,
                    fill: true,
                    data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                    maxBarThickness: 6

                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#fbfbfb',
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#ccc',
                            padding: 20,
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });
    </script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('user/assets/js/argon-dashboard.min.js?v=2.0.4') }}"></script>
    <script>
        const calendar = document.getElementById('calendar');
        let currentDate = new Date();
        const today = new Date(); // Tanggal hari ini
    
        // Fungsi untuk merender kalender
        function renderCalendar(date) {
            const month = date.getMonth();
            const year = date.getFullYear();
    
            // Menentukan jumlah hari dalam bulan
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const firstDayIndex = new Date(year, month, 1).getDay();
    
            let calendarHTML = `<table class="table table-bordered text-center mb-0 table-dark">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-light">Minggu</th>
                                            <th class="text-light">Senin</th>
                                            <th class="text-light">Selasa</th>
                                            <th class="text-light">Rabu</th>
                                            <th class="text-light">Kamis</th>
                                            <th class="text-light">Jumat</th>
                                            <th class="text-light">Sabtu</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;
    
            // Membuat baris tanggal
            let day = 1;
            for (let i = 0; i < 6; i++) {
                calendarHTML += '<tr>';
                for (let j = 0; j < 7; j++) {
                    if (i === 0 && j < firstDayIndex) {
                        calendarHTML += '<td></td>';
                    } else if (day > daysInMonth) {
                        calendarHTML += '<td></td>';
                    } else {
                        // Memeriksa apakah tanggal adalah hari ini
                        const isToday = day === today.getDate() && month === today.getMonth() && year === today.getFullYear();
                        const cellClass = isToday ? 'bg-primary text-white' : 'bg-dark text-light'; // Kelas CSS untuk hari ini
                        calendarHTML += `<td class="${cellClass}">${day}</td>`;
                        day++;
                    }
                }
                calendarHTML += '</tr>';
            }
            calendarHTML += '</tbody></table>';
    
            calendar.innerHTML =
                `<h5 class="text-center mb-3 text-light">${date.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' })}</h5>` +
                calendarHTML;
        }
    
        // Fungsi untuk berpindah bulan
        document.getElementById('prevMonth').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar(currentDate);
        });
    
        document.getElementById('nextMonth').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar(currentDate);
        });
    
        // Render kalender awal
        renderCalendar(currentDate);
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
            });
        </script>
    @endif
</body>

</html>

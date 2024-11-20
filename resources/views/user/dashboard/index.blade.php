@extends('layouts.user.template')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mt-4">
            <!-- Card Selamat Datang -->
            <div class="col-lg-4 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100 shadow-sm border-0">
                    <div class="card-header pb-0 pt-4 bg-gradient-primary text-white rounded-top">
                        <h4 class="text-capitalize mb-4" style="color: white">Selamat Datang, {{ Auth::user()->nama_pegawai }}</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-5">
                            <li class="text-sm mb-2 d-flex align-items-center">
                                <i class="fas fa-info-circle me-2 text-primary"></i>
                                <span class="font-weight-bold">Status:</span>
                                <span
                                    class="ms-1">{{ Auth::user()->status_pegawai == 1 ? 'Aktif' : 'Tidak Aktif' }}</span>
                            </li>
                            <li class="text-sm mb-2 d-flex align-items-center">
                                <i class="fas fa-briefcase me-2 text-primary"></i>
                                <span class="font-weight-bold">Jabatan:</span>
                                <span class="ms-1">{{ Auth::user()->jabatan->nama_jabatan ?? 'Tidak ada jabatan' }}</span>
                            </li>
                            <li class="text-sm d-flex align-items-center">
                                <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                <span class="font-weight-bold">Tanggal Masuk:</span>
                                <span class="ms-1">{{ Auth::user()->tanggal_masuk }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>


            <!-- Kalender -->
            <div class="col-lg-8">
                <div class="card overflow-hidden h-100 p-0">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0">Kalender</h5>
                        <div class="dropdown">
                            <button id="prevMonth" class="btn btn-outline-primary btn-sm me-2">← Prev</button>
                            <button id="nextMonth" class="btn btn-outline-primary btn-sm">Next →</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="calendar" class="table-responsive">
                            <!-- Kalender akan dirender di sini oleh JavaScript -->
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    
    <script>
        const calendar = document.getElementById('calendar');
        let currentDate = new Date();
        const today = new Date(); // Tanggal hari ini
        const absensiData = @json($absensi);

        // Fungsi untuk merender kalender
        function renderCalendar(date) {
            const month = date.getMonth();
            const year = date.getFullYear();

            // Menentukan jumlah hari dalam bulan
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const firstDayIndex = new Date(year, month, 1).getDay();

            let calendarHTML = `<table class="table table-bordered text-center mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Minggu</th>
                                        <th>Senin</th>
                                        <th>Selasa</th>
                                        <th>Rabu</th>
                                        <th>Kamis</th>
                                        <th>Jumat</th>
                                        <th>Sabtu</th>
                                    </tr>
                                </thead>
                                <tbody>`;

            // Membuat baris tanggal
            let day = 1;
            for (let i = 0; i < 6; i++) {
                calendarHTML += '<tr>';
                for (let j = 0; j < 7; j++) {
                    if (i === 0 && j < firstDayIndex) {
                        calendarHTML += '<td style="background-color: white"></td>';
                    } else if (day > daysInMonth) {
                        calendarHTML += '<td style="background-color: white"></td>';
                    } else {
                        // Memeriksa apakah tanggal adalah hari ini
                        const isToday = day === today.getDate() && month === today.getMonth() && year === today.getFullYear();
                        const isFutureDate = day > today.getDate() && month === today.getMonth() && year === today.getFullYear();
                        const isPastDate = day < today.getDate() && month === today.getMonth() && year === today.getFullYear();

                        // Format tanggal untuk dibandingkan dengan data absensi
                        const formattedDate = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

                        // Cari data absensi untuk tanggal ini
                        const absensi = absensiData.find(item => item.tanggal_absen === formattedDate);

                        // Tentukan kelas berdasarkan status
                        let cellClass = '';
                        let statusText = '';

                        if (isToday) {
                            cellClass = 'bg-primary text-white';
                            statusText = 'Hari Ini';
                        } else if (absensi) {
                            if (absensi.status === 'Hadir') {
                                cellClass = 'bg-success text-white';
                                statusText = 'Hadir';
                            } else if (absensi.status === 'sakit') {
                                cellClass = 'bg-danger text-white';
                                statusText = 'Sakit';
                            }
                        } else if (isFutureDate) {
                            cellClass = 'bg-white';
                        } else if (isPastDate) {
                            cellClass = 'bg-secondary text-white';
                            statusText = 'Alfa';
                        }

                        // Tampilkan hari dengan kelas yang sesuai
                        calendarHTML += `<td class="${cellClass}">${day} <br> ${statusText}</td>`;
                        day++;
                    }
                }
                calendarHTML += '</tr>';
            }
            calendarHTML += '</tbody></table>';

            calendar.innerHTML =
                `<h5 class="text-center mb-3">${date.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' })}</h5>` +
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

@endsection

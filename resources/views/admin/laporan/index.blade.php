<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan dengan Dropdown Filter</title>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Buttons for Export -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>

    <h1>Laporan dengan Dropdown Filter</h1>

    <label for="data-type">Pilih Data:</label>
    <select id="data-type">
        <option value="pegawai">Pegawai</option>
        <option value="jabatan">Jabatan</option>
    </select>

    <!-- Tabel Pegawai -->
    <table id="table-pegawai" class="display nowrap hidden" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Umur</th>
                <th>Kota</th>
                <th>Posisi</th>
                <th>Tanggal Bergabung</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Budi</td>
                <td>25</td>
                <td>Jakarta</td>
                <td>Manager</td>
                <td>2019/01/15</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Siti</td>
                <td>30</td>
                <td>Bandung</td>
                <td>Staff</td>
                <td>2020/03/22</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Andi</td>
                <td>28</td>
                <td>Surabaya</td>
                <td>Supervisor</td>
                <td>2018/07/19</td>
            </tr>
        </tbody>
    </table>

    <!-- Tabel Jabatan -->
    <table id="table-jabatan" class="display nowrap hidden" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Jabatan</th>
                <th>Departemen</th>
                <th>Jumlah Pegawai</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Manager</td>
                <td>Keuangan</td>
                <td>10</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Staff</td>
                <td>IT</td>
                <td>15</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Supervisor</td>
                <td>Pemasaran</td>
                <td>8</td>
            </tr>
        </tbody>
    </table>

    <!-- Initialize DataTables -->
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables dengan tombol export untuk Pegawai
            var pegawaiTable = $('#table-pegawai').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            });

            // Inisialisasi DataTables dengan tombol export untuk Jabatan
            var jabatanTable = $('#table-jabatan').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            });

            // Fungsi untuk mengatur visibilitas tabel berdasarkan dropdown
            $('#data-type').on('change', function() {
                var selectedValue = $(this).val();

                if (selectedValue === 'pegawai') {
                    $('#table-pegawai').removeClass('hidden'); // Show Pegawai table
                    $('#table-jabatan').addClass('hidden'); // Hide Jabatan table
                    pegawaiTable.columns.adjust().draw(); // Redraw table to fix layout
                } else if (selectedValue === 'jabatan') {
                    $('#table-pegawai').addClass('hidden'); // Hide Pegawai table
                    $('#table-jabatan').removeClass('hidden'); // Show Jabatan table
                    jabatanTable.columns.adjust().draw(); // Redraw table to fix layout
                }
            });

            // Default behavior: show pegawai table
            $('#data-type').val('pegawai').trigger('change');
        });
    </script>

</body>

</html>

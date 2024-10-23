<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pegawai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Laporan Pegawai</h1>
    <p>Dari: {{ request('tanggal_awal') }} s/d {{ request('tanggal_akhir') }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pegawai</th>
                <th>Jabatan</th>
                <th>Tanggal Masuk</th>
                <th>Umur</th>
                <th>Email</th>
                <th>Gaji</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pegawai as $item)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $item->nama_pegawai }}</td>
                    <td>{{ $item->jabatan->nama_jabatan }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_masuk)->translatedFormat('d F Y') }}</td>
                    <td>{{ $item->umur }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ number_format($item->gaji, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

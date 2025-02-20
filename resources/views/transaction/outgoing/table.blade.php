<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Masuk</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table,
        th,
        td {
            border: 1px solid black;
            /* Menambahkan border di setiap sel tabel */
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        td {
            font-size: 14px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Mengatur lebar kolom */
        th:nth-child(1),
        td:nth-child(1) {
            width: 10%;
            text-align: center;
        }

        th:nth-child(2),
        td:nth-child(2) {
            width: 15%;
            text-align: center;
        }
    </style>
</head>

<body>
    <h3 style="text-align: center;">Rekapitulasi Surat Keluar Sekolah Tinggi Farmasi Indonesia</h3>
    <h4 style="text-align: center;">Unit Sarana Dan Prasarana</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Nomor Urut</th>
                <th>Tanggal</th>
                <th>Nomor Surat</th>
                <th>Perihal</th>
                <th>Keterangan</th>
                <th>Ditujukan</th>
                <th>Tanggal Diterima</th>
                <th>Nama Penerima</th>
                <th>Kurir Pengantar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr>
                <td style="text-align: center;">{{ $item->nomor_urut }}</td>
                <td style="text-align: center;">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                <td>{{ $item->nomor_surat }}</td>
                <td>{{ $item->perihal }}</td>
                <td>{{ $item->keterangan }}</td>
                <td>{{ $item->ditujukan }}</td>
                <td style="text-align: center;">{{ \Carbon\Carbon::parse($item->tanggal_diterima)->format('d-m-Y') }}</td>
                <td>{{ $item->nama_penerima }}</td>
                <td>{{ $item->kurir_pengantar }}</td>

                <td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
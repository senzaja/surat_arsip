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
    <h3 style="text-align: center;">Rekapitulasi Surat Masuk Sekolah Tinggi Farmasi Indonesia</h3>
    <h4 style="text-align: center;">Unit Sarana Dan Prasarana</h4>

    <table id="data-table">
        <thead>
            <tr>
                <th>Nomor Urut</th>
                <th>Nomor Disposisi</th>
                <th>Tanggal Surat Masuk</th>
                <th>Nomor Surat</th>
                <th>Tanggal Pembuatan Surat</th>
                <th>Pengirim</th>
                <th>Ditujukan</th>
                <th>Perihal</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr>
                <td style="text-align: center;">{{ $item->nomor_urut }}</td>
                <td style="text-align: center;">{{ $item->nomor_disposisi }}</td>
                <td style="text-align: center;">{{ \Carbon\Carbon::parse($item->tanggal_surat_masuk)->format('d-m-Y') }}</td>
                <td>{{ $item->nomor_surat }}</td>
                <td style="text-align: center;">{{ \Carbon\Carbon::parse($item->tanggal_pembuatan_surat)->format('d-m-Y') }}</td>
                <td>{{ $item->pengirim }}</td>
                <td>{{ $item->ditujukan }}</td>
                <td>{{ $item->perihal }}</td>
                <td>{{ $item->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
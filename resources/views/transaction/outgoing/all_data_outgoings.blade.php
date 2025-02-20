<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keluar</title>
    <style>
        /* Styling untuk tampilan PDF */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .logo {
            max-width: 80px;
            margin-right: 20px;
        }

        /* Logo lebih kecil dan ada jarak antara logo dan judul */
        .title {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin: 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table,
        .table th,
        .table td {
            border: 1px solid black;
            padding: 8px;
        }

        .table th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="header">

        <img src="{{ public_path('sneat/img/stfi.png') }}" class="logo" alt="Logo">

        <h2 class="title">Data Surat Keluar</h2>
    </div>
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
            @foreach ($outgoings as $outgoing)
            <tr>

                <td>{{ $outgoing->nomor_urut }}</td>
                <td>{{ \Carbon\Carbon::parse($outgoing->tanggal_surat_masuk)->format('d-m-Y') }}</td>
                <td>{{ $outgoing->nomor_surat }}</td>
                <td>{{ $outgoing->perihal }}</td>
                <td>{{ $outgoing->keterangan }}</td>
                <td>{{ $outgoing->ditujukan }}</td>
                <td>{{ $outgoing->tanggal_diterima }}</td>
                <td>{{ $outgoing->nama_penerima}}</td>
                <td>{{ $outgoing->kurir_pengantar}}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Masuk</title>

    <style>
        /* Styling untuk tampilan PDF */
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { display: flex; align-items: center; justify-content: center; margin-bottom: 20px; }
        .logo { max-width: 80px; margin-right: 20px; } /* Logo lebih kecil dan ada jarak antara logo dan judul */
        .title { font-size: 20px; font-weight: bold; text-align: center; margin: 0; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table, .table th, .table td { border: 1px solid black; padding: 8px; }
        .table th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        {{-- <!-- Tambahkan logo di kiri atas -->
        <img src="{{ public_path('sneat/img/stfi.png') }}" class="logo" alt="Logo"> --}}

        <!-- Judul Dokumen -->
        <h2 class="title">Data Surat Masuk</h2>
    </div>

    <table class="table">
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
            @foreach ($incomings as $incoming)
            <tr>
                <td>{{ $incoming->nomor_urut }}</td>
                <td>{{ $incoming->nomor_disposisi }}</td>
                <td>{{ \Carbon\Carbon::parse($incoming->tanggal_surat_masuk)->format('d-m-Y') }}</td>
                <td>{{ $incoming->nomor_surat }}</td>
                <td>{{ \Carbon\Carbon::parse($incoming->tanggal_pembuatan_surat)->format('d-m-Y') }}</td>
                <td>{{ $incoming->pengirim }}</td>
                <td>{{ $incoming->ditujukan }}</td>
                <td>{{ $incoming->perihal }}</td>
                <td>{{ $incoming->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>

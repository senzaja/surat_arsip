@extends('layouts.main')

@section('content')

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<style>
    .small-input {
        font-size: 15px;
        height: 30px;
        padding: 5px;
        width: 200px;
    }

    .btn-search {
        height: 30px;
        font-size: 14px;
        padding: 0 10px;
    }

    .input-group-custom {
        gap: 10px;
    }

    .table th {
        white-space: nowrap;
        text-align: center;
        vertical-align: middle;
    }

    .header-buttons .btn {
        margin-left: 10px;
    }

    .action-buttons a {
        margin: 0 5px;
    }
</style>

<!-- Filter Tanggal -->
<div class="d-flex align-items-center mb-3 input-group-custom">
    <label for="start_date">Dari Tanggal:</label>
    <input type="date" id="start_date" class="form-control small-input">

    <label for="end_date">Sampai Tanggal:</label>
    <input type="date" id="end_date" class="form-control small-input">

    <button onclick="filterData()" class="btn btn-primary btn-search">Search</button>
</div>

<div class="container">
    <div class="page-inner">
        <div class="page-header d-flex justify-content-between align-items-center">
            <h3 class="fw-bold mb-3">Daftar Laporan Masuk</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Laporan Masuk</h4>
                    <div class="header-buttons">
                        {{-- <a href="{{ url('incoming/export') }}" class="btn btn-sm btn-info">Download Excel</a>
                        <a href="{{ route('incomings.pdf') }}" class="btn btn-sm btn-danger">
                            <i class="fas fa-file-pdf"></i> Printout PDF
                        </a> --}}
                        {{-- @if (Auth::user()->role != 'admin')
                            <a href="{{ route('transaction.incoming.create') }}" class="btn btn-primary btn-sm">
                                Tambah Data
                            </a>
                        @endif --}}
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="laporanMasukTable" class="table table-striped table-hover">
                            <thead class="table-primary text-center">
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
                                    <th>Disposisi</th>
                                    <th>Status Disposisi</th>
                                    <th class="no-sort">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @if(is_iterable($data))
                                @forelse ($data as $item)
                                <tr>
                                    <td>{{ $item->nomor_urut }}</td>
                                    <td>{{ $item->nomor_disposisi }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_surat_masuk)->format('d-m-Y') }}</td>
                                    <td>{{ $item->nomor_surat }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pembuatan_surat)->format('d-m-Y') }}</td>
                                    <td>{{ $item->pengirim }}</td>
                                    <td>{{ $item->ditujukan }}</td>
                                    <td>{{ $item->perihal }}</td>

                                    <td>{{ $item->keterangan }}</td>
                                    <td>{{ $item->disposisi }}</td>
                                    <td>{{ $item->status_disposisi }}</td>
                                    <td class="action-buttons">
                                        {{-- <a href="{{ route('transaction.incoming.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a> --}}
                                        @if (Auth::user()->role == 'admin')
                                            <form action="{{ route('transaction.incoming.destroy', $item->id) }}" method="post" style="display:inline;">
                                                @method('DELETE')
                                                @csrf

                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="12" class="text-center">Tidak Ada Data</td>
                                </tr>
                                @endforelse
                                @else
                                <tr>
                                    <td colspan="12" class="text-center text-danger">SILAHKAN ISI FILTER</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer text-center">
                    <small class="text-muted">Menampilkan data surat masuk</small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function formatDate(dateString) {
        // Ubah format tanggal dari YYYY-MM-DD menjadi DD-MM-YYYY
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0'); // Bulan dimulai dari 0
        const year = date.getFullYear();
        return `${day}-${month}-${year}`;
    }

    function filterData() {
        // Ambil nilai tanggal mulai dan tanggal akhir
        let startDate = $('#start_date').val();
        let endDate = $('#end_date').val();

        // Menampilkan animasi atau indikator loading (opsional)
        $("#laporanMasukTable tbody").html('<tr><td colspan="13" class="text-center">Memuat data...</td></tr>');

        $.ajax({
            url: "{{ route('incomings.filter') }}",
            type: "GET",
            data: {
                start_date: startDate,
                end_date: endDate
            },
            success: function (data) {

                // Kosongkan konten tbody yang lama
                let rows = "";

                // Cek jika data ditemukan
                if (data.length > 0) {
                    // Loop dan isi tabel dengan data baru
                    data.forEach(item => {

                        // Format baris tabel
                        rows += `
                            <tr>
                                <td>${item.nomor_urut}</td>
                                <td>${item.nomor_disposisi}</td>
                                <td>${formatDate(item.tanggal_surat_masuk)}</td> <!-- Format tanggal -->
                                <td>${item.nomor_surat}</td>
                                <td>${formatDate(item.tanggal_pembuatan_surat)}</td> <!-- Format tanggal -->
                                <td>${item.pengirim}</td>
                                <td>${item.ditujukan}</td>
                                <td>${item.perihal}</td>

                                <td>${item.keterangan}</td>
                                <td>${item.disposisi}</td>
                                <td>${item.status_disposisi}</td>

                                <td class="action-buttons">
                                    @if (Auth::user()->role == 'admin')
                                        <form action="{{ url('transaction/incoming/delete') }}/${item.id}" method="post" style="display:inline;">
                                            @method('DELETE')
                                            @csrf

                                        </form>
                                    @endif
                                </td>
                            </tr>`;
                    });
                } else {
                    // Tampilkan pesan jika tidak ada data
                    rows = `<tr><td colspan="13" class="text-center">Tidak ada data ditemukan</td></tr>`;
                }

                // Masukkan hasil ke dalam tbody
                $("#laporanMasukTable tbody").html(rows);
            },
            error: function() {
                // Menangani jika terjadi kesalahan dalam permintaan AJAX
                $("#laporanMasukTable tbody").html('<tr><td colspan="13" class="text-center text-danger">Terjadi kesalahan, coba lagi.</td></tr>');
            }
        });
    }
</script>


@endsection

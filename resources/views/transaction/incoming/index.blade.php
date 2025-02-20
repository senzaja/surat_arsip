@extends('layouts.main')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <style>
        /* Styling khusus untuk header tabel */
        .table th {
            white-space: nowrap;
            text-align: center;
            vertical-align: middle;
        }

        /* Memberikan lebar tetap agar tabel lebih rapi */
        .table th:nth-child(1),
        .table th:nth-child(2),
        .table th:nth-child(3),
        .table th:nth-child(4),
        .table th:nth-child(5),
        .table th:nth-child(6) {
            width: 10%;
        }

        .table th:nth-child(7),
        .table th:nth-child(8) {
            width: 15%;
        }

        /* Tombol di header */
        .header-buttons .btn {
            margin-left: 10px;
        }

        /* Tombol di dalam tabel */
        .action-buttons a {
            margin: 0 5px;
        }
    </style>


    <div class="container">
        <div class="page-inner">
            <div class="page-header d-flex justify-content-between align-items-center">
                <h3 class="fw-bo ld mb-3">Data Surat Masuk</h3>
                <div class="header-buttons">
                    <div class="hear-buttons">
                        <a href="{{ url('incoming/export') }}" class="btn btn-sm btn-info">Download Excel</a>
                        <a href="{{ route('incomings.pdf') }}" class="btn btn-sm btn-danger">
                            <i class="fas fa-file-pdf"></i> Printout PDF
                        </a>
                        @if (Auth::user()->role != 'admin')
                        <a href="{{ route('transaction.incoming.create') }}" class="btn btn-primary btn-sm">
                            Tambah Data
                        </a>
                    @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Daftar Surat Masuk</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
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
                                        <th>Lampiran</th>
                                        <th>Keterangan</th>
                                        <th>Disposisi</th>
                                        <th>Status Disposisi</th>
                                        <!-- <th>Catatan</th> -->
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
                                            <td>
                                            @php
                                        $attachments = App\Models\Attachment::where('letter_id', $item->id)->distinct()->get();
                                        @endphp
                                        @if ($attachments->isNotEmpty())
                                            @php $hasPdf = false; @endphp
                                            @foreach ($attachments as $attachment)
                                                @if (\Illuminate\Support\Str::endsWith($attachment->filename, '.pdf'))
                                                    @if (!$hasPdf)
                                                        <a href="{{ Storage::url('attachments/' . $attachment->filename) }}" target="_blank" class="badge bg-primary">PDF</a>
                                                        @php $hasPdf = true; @endphp
                                                    @endif
                                                @else
                                                    <a href="{{ asset('storage/attachments/' . $attachment->filename) }}" target="_blank" class="badge bg-secondary">File</a>
                                                @endif
                                            @endforeach
                                        @else
                                            <p>Tidak ada lampiran</p>
                                        @endif
                                    </td>
                                            <td>{{ $item->keterangan }}</td>
                                            <td>{{ $item->disposisi }}</td>
                                            <td>{{ $item->status_disposisi }}</td>
                                            <td class="action-buttons">
                                                <a href="{{ route('transaction.incoming.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                @if (Auth::user()->role == 'admin')
                                                    <form action="{{ route('transaction.incoming.destroy', $item->id) }}" method="post" style="display:inline;">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Delete</button>
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
                                        <td colspan="12" class="text-center text-danger">Data tidak valid</td>
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
@endsection

<script>
    $(document).ready(function() {
        $('#form-update').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    Swal.fire('Success', 'Data berhasil diperbarui', 'success');
                },
                error: function(xhr) {
                    Swal.fire('Error', 'Terjadi kesalahan', 'error');
                }
            });
        });
    });
</script>

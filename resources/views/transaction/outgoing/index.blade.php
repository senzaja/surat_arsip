@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<style>
    /* Ensures table headers do not wrap text */
    .table th {
        white-space: nowrap;
        text-align: center;
        vertical-align: middle;
    }

    /* Sets fixed width for table columns for better alignment */
    .table th:nth-child(1),
    .table th:nth-child(2),
    .table th:nth-child(3),
    .table th:nth-child(4),
    .table th:nth-child(5) {
        width: 15%;
    }

    .table th:nth-child(6) {
        width: 20%;
    }

    /* Ensures consistent spacing for action buttons */
    .action-buttons a {
        margin: 0 5px;
    }

    /* Adjusts the layout of buttons for better spacing */
    .header-buttons .btn {
        margin: 0 5px;
    }
</style>

<div class="container">
    <div class="page-inner">
        <div class="page-header d-flex justify-content-between align-items-center">
            <h3 class="fw-bold mb-3">Data Surat Keluar</h3>
            <div class="header-buttons">
                <a href="{{ url('outgoing/export') }}" class="btn btn-info btn-sm">Download Excel</a>
                <a href="{{ route('outgoings.pdf') }}" class="btn btn-danger btn-sm">
                    <i class="fas fa-file-pdf"></i> Printout PDF
                </a>
                @if (Auth::user()->role != 'admin')
                    <a href="{{ route('transaction.outgoing.create') }}" class="btn btn-primary btn-sm">
                        Tambah Data
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Daftar Surat Keluar</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th>Nomor Urut</th>
                                    <th>Tanggal Pembuatan</th>
                                    <th>Nomor Surat</th>
                                    <th>Perihal</th>
                                    <th>Keterangan</th>
                                    <th>Ditujukan</th>
                                    <th>Tanggal Diterima</th>
                                    <th>Nama Penerima</th>
                                   
                                    <th>Lampiran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse ($data as $item)
                                <tr>
                                    <td>{{ $item->nomor_urut }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pembuatan)->format('d-m-Y') }}</td>
                                    <td>{{ $item->nomor_surat }}</td>
                                    <td>{{ $item->perihal }}</td>
                                    <td>{{ $item->keterangan }}</td>
                                    <td>{{ $item->ditujukan }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_diterima)->format('d-m-Y') }}</td>
                                    <td>{{ $item->nama_penerima }}</td>

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
                                    <td class="action-buttons">
                                        @if (Auth::user()->role == 'staff')
                                            <a href="{{ route('transaction.outgoing.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        @endif
                                        @if (Auth::user()->role == 'admin')
                                            <form action="{{ route('transaction.outgoing.destroy', $item->id) }}" method="post" style="display:inline;">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text center">Tidak Ada Data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <small class="text-muted">Menampilkan data surat keluar</small>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
    $(document).ready(function() {
        $('.table').DataTable({
            order: [[1, 'asc']], // Kolom ke-2 (Tanggal Surat Masuk) diurutkan ASC
            columnDefs: [{
                targets: 'no-sort',
                orderable: false
            }] // Hindari sorting di kolom tertentu
        });
    });
</script>

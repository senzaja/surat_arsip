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
            <h3 class="fw-bold mb-3">Daftar Laporan Keluar</h3>
            <div class="header-buttons">
                {{-- <a href="{{ url('outgoing/export') }}" class="btn btn-info btn-sm">Download Excel</a>
                <a href="{{ route('outgoings.pdf') }}" class="btn btn-danger btn-sm">
                    <i class="fas fa-file-pdf"></i> Printout PDF
                </a> --}}
                {{-- @if (Auth::user()->role != 'admin')
                    <a href="{{ route('transaction.outgoing.create') }}" class="btn btn-primary btn-sm">
                        Tambah Data
                    </a>
                @endif --}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Laporan Surat Keluar</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="laporanKeluarTable" class="table table-striped table-hover">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th>Nomor Urut</th>
                                    <th>Tanggal pembuatan</th>
                                    <th>Nomor Surat</th>
                                    <th>Perihal</th>
                                    <th>Keterangan</th>
                                    <th>Ditujukan</th>
                                    <th>Tanggal Diterima</th>
                                    <th>Nama Penerima</th>


                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @if(is_iterable($data))
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

                                    <td class="action-buttons">

                                        @if (Auth::user()->role == 'admin')
                                            <form action="{{ route('transaction.outgoing.destroy', $item->id) }}" method="post" style="display:inline;">
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
                    <small class="text-muted">Menampilkan data surat keluar</small>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
<script>
    function formatDate(dateString) {
      if (!dateString) return "-";
      const date = new Date(dateString);
      const day = String(date.getDate()).padStart(2, '0');
      const month = String(date.getMonth() + 1).padStart(2, '0');
      const year = date.getFullYear();
      return `${day}-${month}-${year}`;
  }

  function filterData() {
      let startDate = $('#start_date').val();
      let endDate = $('#end_date').val();

      if (!startDate || !endDate) {
          alert("Silakan pilih rentang tanggal terlebih dahulu.");
          return;
      }

      $("#laporanKeluarTable tbody").html('<tr><td colspan="9" class="text-center">Memuat data...</td></tr>');

      $.ajax({
          url: "{{ route('outgoings.filter') }}",  // Pastikan route ini benar di web.php
          type: "GET",
          data: {
              start_date: startDate,
              end_date: endDate
          },
          success: function (response) {
              let rows = "";

              if (response.length > 0) {
                  response.forEach(item => {
                      rows += `
                          <tr>
                              <td>${item.nomor_urut}</td>
                              <td>${formatDate(item.tanggal_pembuatan)}</td>
                              <td>${item.nomor_surat}</td>
                              <td>${item.perihal}</td>
                              <td>${item.keterangan}</td>
                              <td>${item.ditujukan}</td>
                              <td>${formatDate(item.tanggal_diterima)}</td>
                              <td>${item.nama_penerima}</td>
                              <td class="action-buttons">

                                  @if (Auth::user()->role == 'admin')
                                      <form action="{{ url('transaction/outgoing/delete') }}/${item.id}" method="post" style="display:inline;">
                                          @method('DELETE')
                                          @csrf
                                          <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                      </form>
                                  @endif
                              </td>
                          </tr>`;
                  });
              } else {
                  rows = `<tr><td colspan="9" class="text-center">Tidak ada data ditemukan</td></tr>`;
              }

              $("#laporanKeluarTable tbody").html(rows);
          },
          error: function(xhr, status, error) {
              console.error("Error:", error);
              $("#laporanKeluarTable tbody").html('<tr><td colspan="9" class="text-center text-danger">Terjadi kesalahan saat mengambil data.</td></tr>');
          }
      });
  }
  </script>


@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">tambahkan Data Surat Keluar</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('transaction.outgoing.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row mt-2 gy-4">

                                 <!-- nomor urut -->
                                <div class="col-md-12">
                                        <div class="form-floating form-floating-outline">
                                            <input id="nomor_urut" type="text"
                                                class="form-control @error('nomor_urut') is-invalid @enderror"
                                                name="nomor_urut" value="{{ old('nomor_urut') }}" required
                                                placeholder="Masukkan nomor urut">
                                            <label for="nomor_urut">Nomor Urut</label>

                                            @error('nomor_urut')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Tanggal pembuatan -->
                                    <div class="col-md-12">
                                        <div class="form-floating form-floating-outline">
                                            <input id="tanggal_pembuatan" type="date"
                                                class="form-control @error('tanggal_pembuatan') is-invalid @enderror" name="tanggal_pembuatan"
                                                value="{{ old('tanggal_pembuatan') }}" required>
                                            <label for="tanggal_pembuatan">Tanggal pembuatan</label>
                                            @error('tanggal_pembuatan')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Nomor Surat -->
                                    <div class="col-md-12">
                                        <div class="form-floating form-floating-outline">
                                            <input id="nomor_surat" type="text"
                                                class="form-control @error('nomor_surat') is-invalid @enderror"
                                                name="nomor_surat" value="{{ old('nomor_surat') }}" required
                                                placeholder="Masukkan nomor surat">
                                            <label for="nomor_surat">Nomor Surat</label>
                                            <small>harap masukan nomor surat dengan nomor yang berbeda</small>
                                            @error('nomor_surat')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Perihal -->
                                    <div class="col-md-12">
                                        <div class="form-floating form-floating-outline">
                                            <input id="perihal" type="text"
                                                class="form-control @error('perihal') is-invalid @enderror" name="perihal"
                                                value="{{ old('perihal') }}" required placeholder="Masukkan perihal">
                                            <label for="perihal">Perihal</label>
                                            @error('perihal')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- {{-- keterangan --}} -->
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline">
                                        <input id="keterangan" type="text"
                                            class="form-control @error('keterangan') is-invalid @enderror" name="keterangan"
                                            value="{{ old('keterangan') }}" required placeholder="Masukkan keterangan">
                                        <label for="keterangan">keterangan</label>
                                        @error('keterangan')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                    <!-- Ditujukan -->
                                    <div class="col-md-12">
                                        <div class="form-floating form-floating-outline">
                                            <input id="ditujukan" type="text"
                                                class="form-control @error('ditujukan') is-invalid @enderror"
                                                name="ditujukan" value="{{ old('ditujukan') }}" required>
                                            <label for="ditujukan">Ditujukan</label>
                                            @error('ditujukan')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                <!-- Tanggal Penerima -->
                                <div class="col-md-12">
                                        <div class="form-floating form-floating-outline">
                                            <input id="tanggal_diterima" type="date"
                                                class="form-control @error('tanggal_diterima') is-invalid @enderror" name="tanggal_diterima"
                                                value="{{ old('tanggal_diterima') }}" required>
                                            <label for="tanggal_diterima">Tanggal diterima</label>
                                            @error('tanggal_diterima')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                     <!-- Nama Penerima -->
                                     <div class="col-md-12">
                                        <div class="form-floating form-floating-outline">
                                            <input id="nama_penerima" type="text"
                                                class="form-control @error('nama_penerima') is-invalid @enderror"
                                                name="nama_penerima" value="{{ old('nama_penerima') }}" required>
                                            <label for="nama_penerima">Nama Penerima</label>
                                            @error('nama_penerima')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Lampiran -->
                                    <div class="mb-3">
                                        <label class="form-label">Lampiran (File)</label>
                                        <input type="file" class="form-control @error('lampiran') is-invalid @enderror"
                                            name="lampiran">

                                        @error('lampiran')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                    <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

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
                        <h4 class="card-title">Tambahkan Data Surat Masuk</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('transaction.incoming.store') }}" enctype="multipart/form-data">
                            @csrf <!-- Add CS RF token for security -->
                            <div class="row mt-2 gy-4">
                                <!-- Nomor Urut -->
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline">
                                        <input id="nomor_urut" type="text" class="form-control @error('nomor_urut') is-invalid @enderror" name="nomor_urut" value="{{ old('nomor_urut') }}" required placeholder="Masukkan nomor urut">
                                        <label for="nomor_urut">No urut</label>
                                        @error('nomor_urut')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- NOMOR DISPOSISI -->
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline">
                                        <input id="nomor_disposisi" type="text" class="form-control @error('nomor_disposisi') is-invalid @enderror" name="nomor_disposisi" value="{{ old('nomor_disposisi') }}" required placeholder="Masukkan nomor disposisi">
                                        <label for="nomor_disposisi">Nomor disposisi</label>
                                        @error('nomor_disposisi')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                 <!-- Tanggal Surat Masuk -->
                                 <div class="col-md-12">
                                    <div class="form-floating form-floating-outline">
                                        <input id="tanggal_surat_masuk" type="date" class="form-control @error('tanggal_surat_masuk') is-invalid @enderror" name="tanggal_surat_masuk" value="{{ old('tanggal_surat_masuk') }}" required>
                                        <label for="tanggal_surat_masuk">Tanggal Surat Masuk</label>
                                        @error('tanggal_surat_masuk')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Nomor Surat -->
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline">
                                        <input id="nomor_surat" type="text" class="form-control @error('nomor_surat') is-invalid @enderror" name="nomor_surat" value="{{ old('nomor_surat') }}" required placeholder="Masukkan nomor surat">
                                        <label for="nomor_surat">Nomor Surat</label>
                                        <small> pengisian no surat harus seperti ini 00/xx/xx/xx/0000 </small>
                                        @error('nomor_surat')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                 <!-- Tanggal Pembuatan Surat -->
                                 <div class="col-md-12">
                                    <div class="form-floating form-floating-outline">
                                        <input id="tanggal_pembuatan_surat" type="date" class="form-control @error('tanggal_pembuatan_surat') is-invalid @enderror" name="tanggal_pembuatan_surat" value="{{ old('tanggal_pembuatan_surat') }}" required>
                                        <label for="tanggal_pembuatan_surat">Tanggal Pembuatan Surat</label>
                                        @error('tanggal_pembuatan_surat')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Pengirim -->
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline">
                                        <input id="pengirim" type="text" class="form-control @error('pengirim') is-invalid @enderror" name="pengirim" value="{{ old('pengirim') }}" required>
                                        <label for="pengirim">Pengirim</label>
                                        @error('pengirim')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Ditujukan -->
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline">
                                        <input id="ditujukan" type="text" class="form-control @error('ditujukan') is-invalid @enderror" name="ditujukan" value="{{ old('ditujukan') }}" required>
                                        <label for="ditujukan">Ditujukan</label>
                                        @error('ditujukan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Perihal -->
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline">
                                        <input id="perihal" type="text" class="form-control @error('perihal') is-invalid @enderror" name="perihal" value="{{ old('perihal') }}" required placeholder="Masukkan perihal">
                                        <label for="perihal">Perihal</label>
                                        @error('perihal')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Lampiran -->
                                <div class="mb-3">
                                    <label class="form-label">Lampiran (File)</label>
                                    <input type="file" class="form-control @error('lampiran') is-invalid @enderror" name="lampiran">
                        
                                    @error('lampiran')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                 <!-- keterangan -->
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline">
                                        <input id="keterangan" type="text" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" value="{{ old('keterangan') }}" required placeholder="Masukkan keterangan">
                                        <label for="keterangan">Keterangan</label>
                                        @error('keterangan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Hidden Status Disposisi -->
                                <input type="hidden" name="status_disposisi" value="-"> <!-- Set default value as - or null -->
                                <input type="hidden" name="disposisi" value="-"> 
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

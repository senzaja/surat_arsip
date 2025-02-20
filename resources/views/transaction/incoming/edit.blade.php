@extends('layouts.main')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Edit Surat Masuk</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Data Surat Masuk</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('transaction.incoming.update', $incoming->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Menggunakan metode PUT untuk pembaruan data -->
                            @if(Auth::user()->role === 'staff')
                            <div class="row mt-2 gy-4">
                                <!-- Nomor Urut -->
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline">
                                        <input id="nomor_urut" type="text"
                                            class="form-control @error('nomor_urut') is-invalid @enderror"
                                            name="nomor_urut" value="{{ old('nomor_urut', $incoming->nomor_urut) }}"
                                            required placeholder="Masukkan nomor urut">
                                        <label for="nomor_urut">No urut</label>
                                        @error('nomor_urut')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Nomor Disposisi -->
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline">
                                        <input id="nomor_disposisi" type="text"
                                            class="form-control @error('nomor_disposisi') is-invalid @enderror"
                                            name="nomor_disposisi"
                                            value="{{ old('nomor_disposisi', $incoming->nomor_disposisi) }}" required
                                            placeholder="Masukkan nomor disposisi">
                                        <label for="nomor_disposisi">Nomor Disposisi</label>
                                        @error('nomor_disposisi')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Nomor Surat -->
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline">
                                        <input id="nomor_surat" type="text"
                                            class="form-control @error('nomor_surat') is-invalid @enderror"
                                            name="nomor_surat" value="{{ old('nomor_surat', $incoming->nomor_surat) }}"
                                            required placeholder="Masukkan nomor surat">
                                        <label for="nomor_surat">Nomor Surat</label>
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
                                            value="{{ old('perihal', $incoming->perihal) }}" required
                                            placeholder="Masukkan perihal">
                                        <label for="perihal">Perihal</label>
                                        @error('perihal')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Tanggal Surat Masuk -->
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline">
                                        <input id="tanggal_surat_masuk" type="date"
                                            class="form-control @error('tanggal_surat_masuk') is-invalid @enderror"
                                            name="tanggal_surat_masuk"
                                            value="{{ old('tanggal_surat_masuk', $incoming->tanggal_surat_masuk) }}"
                                            required>
                                        <label for="tanggal_surat_masuk">Tanggal Surat Masuk</label>
                                        @error('tanggal_surat_masuk')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Tanggal Pembuatan Surat -->
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline">
                                        <input id="tanggal_pembuatan_surat" type="date"
                                            class="form-control @error('tanggal_pembuatan_surat') is-invalid @enderror"
                                            name="tanggal_pembuatan_surat"
                                            value="{{ old('tanggal_pembuatan_surat', $incoming->tanggal_pembuatan_surat) }}"
                                            required>
                                        <label for="tanggal_pembuatan_surat">Tanggal Pembuatan Surat</label>
                                        @error('tanggal_pembuatan_surat')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Pengirim -->
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline">
                                        <input id="pengirim" type="text"
                                            class="form-control @error('pengirim') is-invalid @enderror" name="pengirim"
                                            value="{{ old('pengirim', $incoming->pengirim) }}" required>
                                        <label for="pengirim">Pengirim</label>
                                        @error('pengirim')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Ditujukan -->
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline">
                                        <input id="ditujukan" type="text"
                                            class="form-control @error('ditujukan') is-invalid @enderror"
                                            name="ditujukan" value="{{ old('ditujukan', $incoming->ditujukan) }}"
                                            required>
                                        <label for="ditujukan">Ditujukan</label>
                                        @error('ditujukan')
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

                                <!-- Keterangan -->
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline">
                                        <input id="keterangan" type="text"
                                            class="form-control @error('keterangan') is-invalid @enderror"
                                            name="keterangan" value="{{ old('keterangan', $incoming->keterangan) }}"
                                            required placeholder="Masukkan keterangan">
                                        <label for="keterangan">Keterangan</label>
                                        @error('keterangan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <button type="reset" class="btn btn-outline-secondary">Reset</button>
                            </div>
                            </div>

                            @elseif(Auth::user()->role === 'admin')
                            <form method="POST" action="{{ route('transaction.incoming.UpdateStatus', $incoming->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')


                                <!-- <div class="col-md-12">
                                    <div class="form-floating form-floating-outline">
                                        <input id="catatan" type="text"
                                            class="form-control @error('catatan') is-invalid @enderror"
                                            name="catatan" value="{{ old('catatan', $incoming->catatan) }}"
                                            required placeholder="Masukkan catatan">
                                        <label for="catatan">catatan</label>
                                        @error('catatan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div> -->

                                <div class="form-group">
                                    <label for="disposisi">Disposisi</label>
                                    <select name="disposisi" id="disposisi" class="form-control">
                                        <option value="Ketua"
                                            {{ $incoming->disposisi == 'Ketua' ? 'selected' : '' }}>Ketua</option>
                                        <option value="Wakil Ketua 1"
                                            {{ $incoming->disposisi == 'Wakil Ketua 1' ? 'selected' : '' }}>Wakil Ketua 1</option>
                                        <option value="Wakil Ketua 2"
                                            {{ $incoming->disposisi == 'Wakil Ketua 2' ? 'selected' : '' }}>Wakil Ketua 2</option>
                                        <option value="Wakil Ketua 3"
                                            {{ $incoming->disposisi == 'Wakil Ketua 3' ? 'selected' : '' }}>Wakil Ketua 3</option>
                                        <option value="Ketua Program Studi Sarjana Farmasi"
                                            {{ $incoming->disposisi == 'Ketua Program Studi Sarjana Farmasi' ? 'selected' : '' }}>Ketua Program Studi Sarjana Farmasi</option>
                                        <option value="Ketua Program Studi Profesi Apoteker"
                                            {{ $incoming->disposisi == 'Ketua Program Studi Profesi Apoteker' ? 'selected' : '' }}>Ketua Program Studi Profesi Apoteker</option>
                                        <option value="Unit Kerja"
                                            {{ $incoming->disposisi == 'Unit Kerja' ? 'selected' : '' }}>Unit Kerja</option>
                                    </select>
                                </div>
                                        <br>
                                        <br>
                                <div class="form-group">
                                    <label for="status_disposisi">Status Disposisi</label>
                                    <select name="status_disposisi" id="status_disposisi" class="form-control">
                                       
                                        <option value="OKE"
                                            {{ $incoming->status_disposisi == 'OKE' ? 'selected' : '' }}>OKE</option>
                                        <option value="Follow Up"
                                            {{ $incoming->status_disposisi == 'Follow Up' ? 'selected' : '' }}>Follow Up</option>
                                        <option value="To Be Discused"
                                            {{ $incoming->status_disposisi == 'To Be Discused' ? 'selected' : '' }}>To Be Discused</option>
                                        <option value="Ditolak"
                                            {{ $incoming->status_disposisi == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </div>
                                <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <button type="reset" class="btn btn-outline-secondary">Reset</button>
                            </div>
                            </form>
                            @endif

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

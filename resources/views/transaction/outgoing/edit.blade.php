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
                        <h4 class="card-title">Edit Data Surat Keluar</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('transaction.outgoing.update', $outgoing->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- Specify method as PUT for update -->


                            <!-- Nomor Urut -->
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline">
                                    <input id="nomor_urut" type="text"
                                        class="form-control @error('nomor_urut') is-invalid @enderror"
                                        name="nomor_urut"
                                        value="{{ old('nomor_urut', $outgoing->nomor_urut) }}" required
                                        placeholder="Masukkan nomor urut">
                                    <label for="nomor_urut">Nomor Urut</label>
                                    @error('nomor_urut')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-2 gy-4">

                                <!-- Tanggal Pembuatan -->
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline">
                                        <input id="tanggal_pembuatan" type="date"
                                            class="form-control @error('tanggal_pembuatan') is-invalid @enderror" name="tanggal_pembuatan"
                                            value="{{ old('tanggal_pembuatan', $outgoing->tanggal_pembuatan) }}" required>
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
                                            name="nomor_surat"
                                            value="{{ old('nomor_surat', $outgoing->nomor_surat) }}" required
                                            placeholder="Masukkan nomor surat">
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
                                            value="{{ old('perihal', $outgoing->perihal) }}" required
                                            placeholder="Masukkan perihal">
                                        <label for="perihal">Perihal</label>
                                        @error('perihal')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Keterangan -->
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline">
                                        <input id="keterangan" type="text"
                                            class="form-control @error('keterangan') is-invalid @enderror" name="keterangan"
                                            value="{{ old('keterangan', $outgoing->keterangan) }}" required
                                            placeholder="Masukkan keterangan">
                                        <label for="keterangan">Keterangan</label>
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
                                            name="ditujukan" value="{{ old('ditujukan', $outgoing->ditujukan) }}"
                                            required>
                                        <label for="ditujukan">Ditujukan</label>
                                        @error('ditujukan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Tanggal Diterima -->
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline">
                                        <input id="tanggal_diterima" type="date"
                                            class="form-control @error('tanggal_diterima') is-invalid @enderror" name="tanggal_diterima"
                                            value="{{ old('tanggal_diterima', $outgoing->tanggal_diterima) }}" required>
                                        <label for="tanggal_diterima">Tanggal diterima</label>
                                        @error('tanggal_diterima')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Nama Penerima -->
                                <div class="col-md-12 mb-3"> <!-- Tambahkan kelas mb-3 untuk margin bawah -->
                                    <div class="form-floating form-floating-outline">
                                        <input id="nama_penerima" type="text"
                                            class="form-control @error('nama_penerima') is-invalid @enderror"
                                            name="nama_penerima" value="{{ old('nama_penerima', $outgoing->nama_penerima) }}"
                                            required>
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
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah lampiran.</small>
                                    @error('lampiran')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>




                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('transaction.outgoing.index') }}"
                                    class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

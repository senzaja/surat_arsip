<!-- resources/views/transaction/incoming/print.blade.php -->
@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Cetak Lampiran Surat Masuk</h1>
    <div class="text-center">
        <h3>Berikut adalah lampiran yang akan dicetak:</h3>
        <a href="{{ asset('storage/incoming/' . $incoming->lampiran) }}" target="_blank" class="btn btn-primary">
            Lihat / Download Lampiran
        </a>
    </div>
</div>

<script>
    window.onload = function() {
        window.print(); // Otomatis membuka dialog print saat halaman dimuat
    };
</script>
@endsection

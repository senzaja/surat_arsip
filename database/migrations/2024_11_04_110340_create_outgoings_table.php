<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outgoings', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_urut');
            $table->date('tanggal_pembuatan');
            $table->string('nomor_surat');
            $table->text('perihal');
            $table->text('keterangan');
            $table->string('ditujukan');
            $table->date('tanggal_diterima');
            $table->string('nama_penerima');

            $table->text('lampiran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outgoings');
    }
};

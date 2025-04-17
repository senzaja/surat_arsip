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
        Schema::create('incomings', function (Blueprint $table) {
            $table->id();
          
            $table->string('nomor_urut');
            $table->string('nomor_disposisi');
            $table->date('tanggal_surat_masuk');
            $table->string('nomor_surat');
            $table->date('tanggal_pembuatan_surat');
            $table->string('pengirim');
            $table->string('ditujukan');
            $table->text('perihal');
            $table->text('keterangan');
            $table->text('disposisi')->nullable();
            $table->text('status_disposisi')->nullable();
            // $table->text('catatan')->nullable();
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
        Schema::dropIfExists('incomings');
    }
};

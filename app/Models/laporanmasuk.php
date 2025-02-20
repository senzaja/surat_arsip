<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class laporanmasuk extends Model
{
    use HasFactory;
    protected $fillable = ['nomor_urut','nomor_disposisi', 'tanggal_surat_masuk', 'nomor_surat', 'tanggal_pembuatan_surat', 'pengirim', 'ditujukan', 'perihal', 'keterangan','disposisi', 'lampiran', 'status_disposisi'];
    protected $visible = ['nomor_urut','nomor_disposisi', 'tanggal_surat_masuk', 'nomor_surat', 'tanggal_pembuatan_surat', 'pengirim', 'ditujukan', 'perihal', 'keterangan', 'disposisi','lampiran', 'status_disposisi'];
}

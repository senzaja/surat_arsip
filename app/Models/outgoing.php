<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class outgoing extends Model
{
    use HasFactory;
    protected $fillable = ['nomor_urut','tanggal_pembuatan','nomor_surat','perihal','keterangan','ditujukan','tanggal_diterima','nama_penerima','lampiran'];
    protected $visible = ['nomor_urut','tanggal_pembuatan','nomor_surat','perihal','keterangan','ditujukan','tanggal_diterima','nama_penerima','lampiran'];

}

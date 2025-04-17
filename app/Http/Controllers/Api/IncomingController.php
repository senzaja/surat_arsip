<?php

namespace App\Http\Controllers\Api;

use App\Models\Incoming;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class IncomingController extends Controller
{
    // Menampilkan semua Surat masuk
    public function index(): JsonResponse
    {
        $Incoming = Incoming::all();
        return response()->json([
            'success' => true,
            'message' => 'Daftar Incoming',
            'incoming' => $Incoming,
        ], 200);
    }

    // Menyimpan data Surat masuk baru
    public function store(Request $request): JsonResponse
    {
        $request->validate([
           'nomor_urut' => 'required|min:1|unique:incomings,nomor_urut',
            'nomor_disposisi' => 'required|min:1 ',
            'tanggal_surat_masuk' => 'required|date',
            'nomor_surat' => 'required|min:2|unique:incomings,nomor_surat',
            'tanggal_pembuatan_surat' => 'required|date',
            'pengirim' => 'required|min:2',
            'ditujukan' => 'required|min:2',
            'perihal' => 'required|min:2',
            'keterangan' => 'required|min:2',
            'disposisi' => 'required|min:1',
            'status_disposisi' => 'required|min:1',

            'lampiran' => 'required|file|mimes:pdf,doc,docx,jpeg,jpg,png|max:20480',
        ], [

            'nomor_surat.unique' => 'Nomor Surat Sudah Di Gunakan.',
            'nomor_disposisi.unique' => 'Nomor Surat Sudah Di Gunakan.',
            'nomor_urut.unique' => 'Nomor Surat Sudah Di Gunakan.',
        ]);

        $Incoming = Incoming::create([
            'nomor_urut' => $request->nomor_urut,
                'nomor_disposisi' => $request->nomor_disposisi,
                'tanggal_surat_masuk' => $request->tanggal_surat_masuk,
                'nomor_surat' => $request->nomor_surat,
                'tanggal_pembuatan_surat' => $request->tanggal_pembuatan_surat,
                'pengirim' => $request->pengirim,
                'ditujukan' => $request->ditujukan,
                'perihal' => $request->perihal,
                'keterangan' => $request->keterangan,
                'disposisi' => $request->disposisi,
                'status_disposisi' => $request->status_disposisi,

                'lampiran' => $request->lampiran,  // Menyimpan nama file yang telah disimpan
        ]);

        return response()->json([
            'success' => true,
            'message' => 'surat masuk berhasil ditambahkan',
            'incoming' => $Incoming,
        ], 201);
    }

    // Menampilkan Surat masuk berdasarkan ID
    public function show($id): JsonResponse
    {
        $Incoming = Incoming::find($id);

        if (!$Incoming) {
            return response()->json([
                'success' => false,
                'message' => 'Surat masuk tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'incoming' => $Incoming,
        ], 200);
    }

    // Memperbarui data Surat masuk
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
           'nomor_urut' => 'required|min:1|unique:incomings,nomor_urut',
            'nomor_disposisi' => 'required|min:1 ',
            'tanggal_surat_masuk' => 'required|date',
            'nomor_surat' => 'required|min:2|unique:incomings,nomor_surat',
            'tanggal_pembuatan_surat' => 'required|date',
            'pengirim' => 'required|min:2',
            'ditujukan' => 'required|min:2',
            'perihal' => 'required|min:2',
            'keterangan' => 'required|min:2',
            'disposisi' => 'required|min:1',
            'status_disposisi' => 'required|min:1',

            'lampiran' => 'required|file|mimes:pdf,doc,docx,jpeg,jpg,png|max:20480',
        ], [

            'nomor_surat.unique' => 'Nomor Surat Sudah Di Gunakan.',
            'nomor_disposisi.unique' => 'Nomor Surat Sudah Di Gunakan.',
            'nomor_urut.unique' => 'Nomor Surat Sudah Di Gunakan.',
        ]);

        $Incoming = Incoming::find($id);
        if (!$Incoming) {
            return response()->json([
                'success' => false,
                'message' => 'Surat masuk tidak ditemukan',
            ], 404);
        }

        $Incoming->update([
            'nomor_urut' => 'required|min:1|unique:incomings,nomor_urut',
            'nomor_disposisi' => 'required|min:1 ',
            'tanggal_surat_masuk' => 'required|date',
            'nomor_surat' => 'required|min:2|unique:incomings,nomor_surat',
            'tanggal_pembuatan_surat' => 'required|date',
            'pengirim' => 'required|min:2',
            'ditujukan' => 'required|min:2',
            'perihal' => 'required|min:2',
            'keterangan' => 'required|min:2',
            'disposisi' => 'required|min:1',
            'status_disposisi' => 'required|min:1',

            'lampiran' => 'required|file|mimes:pdf,doc,docx,jpeg,jpg,png|max:20480',
        ], [

            'nomor_surat.unique' => 'Nomor Surat Sudah Di Gunakan.',
            'nomor_disposisi.unique' => 'Nomor Surat Sudah Di Gunakan.',
            'nomor_urut.unique' => 'Nomor Surat Sudah Di Gunakan.',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Surat masuk berhasil diperbarui',
            'incoming' => $Incoming,
        ], 200);
    }

    // Menghapus Surat masuk
    public function destroy($id): JsonResponse
    {
        $Incoming = Incoming::find($id);
        if (!$Incoming) {
            return response()->json([
                'success' => false,
                'message' => 'Incoming tidak ditemukan',
            ], 404);
        }

        $Incoming->delete();

        return response()->json([
            'success' => true,
            'message' => 'Incoming berhasil dihapus',
        ], 200);
    }
}

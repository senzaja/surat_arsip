<?php

namespace App\Http\Controllers;

use App\Exports\OutgoingExport;
use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;
use App\Models\Outgoing;
use App\Models\Letter;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use FontLib\Glyph\Outline;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LaporanKeluarController extends Controller
{
    // Menampilkan semua data surat keluar dengan filter
    public function index(Request $request)
    {
        $query = Outgoing::query();

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('tanggal_pembuatan', 'like', '%' . $searchTerm . '%')
                    ->orWhere('nomor_surat', 'like', '%' . $searchTerm . '%')
                    ->orWhere('nomor_urut', 'like', '%' . $searchTerm . '%')
                    ->orWhere('perihal', 'like', '%' . $searchTerm . '%')
                    ->orWhere('ditujukan', 'like', '%' . $searchTerm . '%');
            });
        }

        $outgoing = $query->orderBy('tanggal_pembuatan', 'asc')->get();

        return view('transaction.outgoing.index', [
            'data' => $outgoing,
            'search' => $request->search,
        ]);
    }

    // Menampilkan form untuk membuat surat keluar baru
    public function create()
    {
        return view('transaction.outgoing.create');
    }

    // Menyimpan data surat keluar baru
    public function store(Request $request)
    {
        // Validasi input
        $this->validate($request, [
            'nomor_urut' => 'required|min:1|unique:outgoings,nomor_urut',
            'tanggal_pembuatan' => 'required|date',
            'nomor_surat' => 'required|min:2|unique:outgoings,nomor_surat',
            'perihal' => 'required|min:2',
            'keterangan' => 'required|min:2',
            'ditujukan' => 'required|min:2',
            'tanggal_diterima' => 'required|date',
            'nama_penerima' => 'required|min:2',

            'lampiran' => 'required|file|mimes:pdf,doc,docx,jpeg,jpg,png|max:20480',
        ], [
            'nomor_surat.unique' => 'Nomor Surat Sudah Di Gunakan.',
            'nomor_urut.unique' => 'Nomor Surat Sudah Di Gunakan.',
        ]);

        $lampiran = $request->file('lampiran'); // Definisikan lampiran di sini

        // Ambil empat karakter pertama dari nomor surat yang diinput
        $prefixNomorSurat = substr($request->nomor_surat, 0, 5);
        $existingSurat = Outgoing::where('nomor_surat', 'like', $prefixNomorSurat . '%')->exists();

        if ($existingSurat) {
            Alert::error('Kesalahan', 'Nomor surat sudah ada dengan awalan yang mirip. Harap gunakan nomor surat yang berbeda.')->autoClose(5000);
            return back()->withInput();
        }

        try {
            DB::beginTransaction();

            // Simpan file lampiran
            $filename = time() . '-' . str_replace(' ', '-', $lampiran->getClientOriginalName());
            $lampiran->storeAs('public/outgoing', $filename);

            // Simpan data ke tabel outgoing
            $outgoing = Outgoing::create([
                'nomor_urut' => $request->nomor_urut,
                'tanggal_pembuatan' => $request->tanggal_pembuatan,
                'nomor_surat' => $request->nomor_surat,
                'perihal' => $request->perihal,
                'keterangan' => $request->keterangan,
                'ditujukan' => $request->ditujukan,
                'tanggal_diterima' => $request->tanggal_diterima,
                'nama_penerima' => $request->nama_penerima,

                'lampiran' => $filename,  // Menyimpan nama file yang telah disimpan
            ]);

            // Simpan ke tabel letters
            $letter = Letter::create([
                'reference_number' => $outgoing->nomor_surat,
                'letter_date' => $outgoing->tanggal,
                'description' => $outgoing->perihal,
                'to' => $outgoing->ditujukan,
                'type' => 'outgoing',
                'classification_code' => 'ADM',
                'user_id' => auth()->user()->id,
            ]);

            // Simpan ke tabel attachments
            Attachment::create([
                'filename' => $filename,
                'extension' => $lampiran->getClientOriginalExtension(),
                'user_id' => auth()->user()->id,
                'letter_id' => $letter->id,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Surat keluar berhasil ditambahkan.')->autoClose(5000);
            return redirect()->route('transaction.outgoing.index');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage()); // Debug error message here
            return back()->with('error', 'Terjadi kesalahan, surat tidak tersimpan.');
        }
    }

    // Menampilkan detail surat keluar
    public function show($id)
    {
        $outgoing = Outgoing::findOrFail($id);
        return view('transaction.outgoing.show', compact('outgoing'));
    }

    // Menampilkan form untuk mengedit surat keluar
    public function edit($id)
    {
        $outgoing = Outgoing::findOrFail($id);
        return view('transaction.outgoing.edit', compact('outgoing'));
    }

    // Memperbarui data surat keluar
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nomor_urut' => 'required|min:1|unique:outgoings,nomor_urut,' . $id,
            'tanggal_pembuatan' => 'required|date',
            'nomor_surat' => 'required|min:2|unique:outgoings,nomor_surat,' . $id,
            'perihal' => 'required|min:2',
            'keterangan' => 'required|min:2',
            'ditujukan' => 'required|min:2',
            'tanggal_diterima' => 'required|date',
            'nama_penerima' => 'required|min:2',

            'lampiran' => 'file|mimes:pdf,doc,docx,jpeg,jpg,png|max:20480',
        ], [
            'nomor_surat.unique' => 'Nomor Surat Sudah Di Gunakan.',
        ]);

        // Ambil empat karakter pertama dari nomor surat yang diinput
        $prefixNomorSurat = substr($request->nomor_surat, 0, 5);

        // Periksa apakah ada nomor surat yang memiliki awalan yang sama kecuali surat yang sedang diupdate
        $existingSurat = Outgoing::where('nomor_surat', 'like', $prefixNomorSurat . '%')
            ->where('id', '!=', $id)
            ->exists();

        if ($existingSurat) {
            Alert::error('Kesalahan', 'Nomor surat sudah ada dengan awalan yang mirip. Harap gunakan nomor surat yang berbeda.')->autoClose(5000);
            return back()->withInput();
        }

        $outgoing = Outgoing::findOrFail($id);

        $outgoing->nomor_urut = $request->nomor_urut;
        $outgoing->tanggal_pembuatan = $request->tanggal_pembuatan;
        $outgoing->nomor_surat = $request->nomor_surat;
        $outgoing->perihal = $request->perihal;
        $outgoing->keterangan = $request->keterangan;
        $outgoing->ditujukan = $request->ditujukan;
        $outgoing->tanggal_diterima = $request->tanggal_diterima;
        $outgoing->nama_penerima = $request->nama_penerima;


        if ($request->hasFile('lampiran')) {
            // Menghapus file yang lama jika ada
            if ($outgoing->lampiran) {
                Storage::delete('public/outgoing/' . $outgoing->lampiran);
            }
            $lampiranPath = $request->file('lampiran')->store('public/outgoing');
            $outgoing->lampiran = basename($lampiranPath);
        }

        $outgoing->save();

        Alert::success('Berhasil', 'Surat keluar berhasil diperbarui.')->autoClose(5000);
        return redirect()->route('transaction.outgoing.index');
    }

    // Menghapus surat keluar
    public function destroy($id)
    {
        $outgoing = Outgoing::findOrFail($id);

        // Menghapus file lampiran dari storage
        if ($outgoing->lampiran) {
            Storage::delete('public/outgoing/' . $outgoing->lampiran);
        }

        $outgoing->delete();

        Alert::success('Berhasil', 'Surat keluar berhasil dihapus.')->autoClose(5000);
        return redirect()->route('transaction.outgoing.index');
    }

    // Mengunduh data surat keluar dalam format PDF
    public function generateAllPdf()
    {
        $outgoings = Outgoing::all();

        $pdf = PDF::loadView('transaction.outgoing.all_data_outgoings', compact('outgoings'));

        return $pdf->stream('surat_keluar.pdf');

    }

    // Mengunduh data surat keluar dalam format Excel
    public function OutgoingExport()
    {
        return Excel::download(new OutgoingExport, "surat keluar.xlsx");
    }


    public function filter(Request $request)
    {
        $query = Outgoing::query();

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tanggal_pembuatan', [$request->start_date, $request->end_date]);
        }

        return response()->json($query->get());
    }
}

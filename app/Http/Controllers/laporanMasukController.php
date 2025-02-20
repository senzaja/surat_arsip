<?php

namespace App\Http\Controllers;

use App\Exports\IncomingExport;
use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;
use App\Models\Incoming;
use App\Models\Letter;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class  LaporanMasukController extends Controller
{
    // Menampilkan semua data surat masuk dengan filter
    public function index(Request $request)
    {
        $query = Incoming::query(); // Anda bisa langsung menggunakan Incoming::query() atau Incoming::where()
        $data = Incoming::all(); // Mengambil semua data dari tabel Incoming
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;

            $query->where(function ($q) use ($searchTerm) {
                $q->where('nomor_urut', 'like', '%' . $searchTerm . '%')
                    ->orWhere('nomor_surat', 'like', '%' . $searchTerm . '%')
                    ->orWhere('perihal', 'like', '%' . $searchTerm . '%')
                    ->orWhere('tanggal_surat_masuk', 'like', '%' . $searchTerm . '%')
                    ->orWhere('tanggal_pembuatan_surat', 'like', '%' . $searchTerm . '%')
                    ->orWhere('pengirim', 'like', '%' . $searchTerm . '%')
                    ->orWhere('ditujukan', 'like', '%' . $searchTerm . '%');
            });
        }

        // Mendapatkan data yang telah difilter dan diurutkan berdasarkan 'tanggal_surat_masuk'
        $incoming = $query->orderBy('tanggal_surat_masuk', 'asc')->get();

        return view('pages.transaction.laporanmasuk.laporanmasuk', compact('data'));
    }



    public function create()
    {
        return view('transaction.incoming.create');
    }

    public function store(Request $request)
    {

        // dd($request->all());
        $this->validate($request, [
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

        $lampiran = $request->file('lampiran'); // Definisikan lampiran di sini

        try {
            // Mulai transaksi database
            DB::beginTransaction();
 // Simpan file lampiran
 $filename = time() . '-' . str_replace(' ', '-', $lampiran->getClientOriginalName());
 $lampiran->storeAs('public/incoming', $filename);

            // Simpan ke tabel `incoming`
            $incoming = Incoming::create([
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

                'lampiran' => $filename,  // Menyimpan nama file yang telah disimpan
            ]);

            // Simpan ke tabel `letters`
            $letter = Letter::create([
                'reference_number' => $incoming->nomor_surat,
                'agenda_number' => $incoming->nomor_urut,
                'from' => $incoming->pengirim,
                'to' => $incoming->ditujukan,
                'letter_date' => $incoming->tanggal_pembuatan_surat,
                'received_date' => $incoming->tanggal_surat_masuk,
                'description' => $incoming->perihal,
                'disposition' => $incoming->disposisi,
                'status' => $incoming->status_disposisi,
                'note' => null,
                'type' => 'incoming',
                'classification_code' => 'ADM',
                'user_id' => auth()->user()->id,
            ]);

            // Simpan ke tabel `attachments`
            $filename = time() . '-' . $lampiran->getClientOriginalName();
            $filename = str_replace(' ', '-', $filename);
            $lampiran->storeAs('public/attachments', $filename);
            Attachment::create([
                'filename' => $filename,
                'extension' => $lampiran->getClientOriginalExtension(),
                'user_id' => auth()->user()->id,
                'letter_id' => $letter->id,
            ]);

            // Commit transaksi jika semua operasi berhasil
            DB::commit();

            Alert::success('Berhasil', 'Surat masuk berhasil ditambahkan.')->autoClose(5000);
            return redirect()->route('transaction.incoming.index');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan, surat tidak tersimpan.');
        }
    }

    public function edit($id)
    {
        $incoming = Incoming::findOrFail($id);
        return view('transaction.incoming.edit', compact('incoming'));
    }

    public function update(Request $request, $id)
    {
        try {
            $incoming = Incoming::findOrFail($id);

            // Validasi data
            $request->validate([
                'nomor_urut' => 'nullable|string',
                'nomor_disposisi' => 'nullable|string',
                'nomor_surat' => 'nullable|string',
                'perihal' => 'nullable|string',
                'tanggal_surat_masuk' => 'nullable|date',
                'tanggal_pembuatan_surat' => 'nullable|date',
                'pengirim' => 'nullable|string',
                'ditujukan' => 'nullable|string',
                'lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:20480',
                'keterangan' => 'nullable|string',
            ]);

            // Proses lampiran baru jika ada
            if ($request->hasFile('lampiran')) {
                // Hapus file lama jika ada
                if ($incoming->lampiran) {
                    Storage::delete('public/incoming/' . $incoming->lampiran);
                }

                // Simpan file baru
                $lampiran = $request->file('lampiran');
                $lampiranPath = $lampiran->store('public/incoming');
                $incoming->lampiran = basename($lampiranPath);
            }

            // Update data lain
            $incoming->update($request->only([
                'nomor_urut', 'nomor_disposisi', 'nomor_surat', 'perihal',
                'tanggal_surat_masuk', 'tanggal_pembuatan_surat', 'pengirim',
                'ditujukan', 'keterangan', 'status_disposisi','disposisi',
            ]));

            return redirect()->route('transaction.incoming.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating incoming:', ['message' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function UpdateStatus(Request $request, $id)
    {
        $incoming = Incoming::findOrFail($id);

        $request->validate([
            'status_disposisi' => 'required|string',
            'disposisi' => 'required|string',

        ]);

        $incoming->update([
            'status_disposisi' => $request->status_disposisi,
            'disposisi' => $request->disposisi,

        ]);

        return redirect()->route('transaction.incoming.index')->with('success', 'Status berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $incoming = Incoming::findOrFail($id);

        if ($incoming->lampiran) {
            Storage::delete('public/incoming/' . $incoming->lampiran);
        }

        $incoming->delete();

        Alert::success('Success', 'Surat masuk berhasil dihapus.')->autoClose(5000);
        return redirect()->route('transaction.incoming.index');
    }

    public function print($id)
    {
        $incoming = Incoming::findOrFail($id);

        if (!$incoming->lampiran) {
            Alert::error('Error', 'Lampiran tidak ditemukan.')->autoClose(5000);
            return redirect()->route('transaction.incoming.index');
        }

        return view('transaction.incoming.print', compact('incoming'));
    }

    public function generateAllPdf()
    {
        $incomings = Incoming::all();
        $pdf = FacadePdf::loadView('transaction.incoming.all_data_incomings', compact('incomings'));
        return $pdf->stream('surat_masuk.pdf');
    }

    public function IncomingExport()
    {
        return Excel::download(new IncomingExport, "surat masuk.xlsx");
    }

    public function laporanMasuk(Request $request)
    {
        $query = Incoming::query();

        if ($request->has('tanggal_surat_masuk') && $request->has('tanggal_pembuatan_surat')) {
            $tanggal_surat_masuk = $request->input('tanggal_surat_masuk');
            $tanggal_pembuatan_surat = $request->input('tanggal_pembuatan_surat');

            // Pastikan format tanggal sesuai dengan database (YYYY-MM-DD)
            $query->whereBetween('tanggal_pembuatan_surat', [$tanggal_surat_masuk, $tanggal_pembuatan_surat]);
        }

        $data = $query->get(); // Ambil data

        return view('transaction.incoming.index', compact('data'));

}
public function filter(Request $request)
    {
        $query = Incoming::query();

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tanggal_surat_masuk', [$request->start_date, $request->end_date]);
        }

        return response()->json($query->get());
    }
}

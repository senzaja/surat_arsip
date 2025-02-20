<?php
namespace App\Http\Controllers;

use App\Models\Incoming;
use App\Models\Outgoing;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {


    
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $year = $request->get('year', $currentYear);
        $month = $request->get('month', $currentMonth);

        // Ambil jumlah surat masuk berdasarkan tahun dan bulan yang dipilih
        $monthlyIncoming = Incoming::whereYear('tanggal_surat_masuk', $year)
            ->when($month, function ($query) use ($month) {
                return $query->whereMonth('tanggal_surat_masuk', $month);
            })
            ->count();

        // Ambil jumlah surat keluar berdasarkan tahun dan bulan yang dipilih
        $monthlyOutgoing = Outgoing::whereYear('tanggal_surat_keluar', $year)
            ->when($month, function ($query) use ($month) {
                return $query->whereMonth('tanggal_surat_keluar', $month);
            })
            ->count();

        // Mengambil jumlah surat masuk, surat keluar, dan pengguna aktif terbaru
        $incomingCount = Incoming::count(); // Jumlah surat masuk
        $outgoingCount = Outgoing::count(); // Jumlah surat keluar
        $activeUserCount = User::where('active', 1)->count(); // Jumlah pengguna aktif

        // Kirim data ke tampilan dashboard
        return view('dashboard', [
            'incomingCount' => $incomingCount,
            'outgoingCount' => $outgoingCount,
            'activeUserCount' => $activeUserCount,
            'monthlyIncoming' => $monthlyIncoming,
            'monthlyOutgoing' => $monthlyOutgoing,
            'year' => $year,
            'month' => $month,
        ]);
    }
}

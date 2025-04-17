<?php

namespace App\Http\Controllers;

use App\Enums\LetterType;
use App\Helpers\GeneralHelper;
use App\Http\Requests\UpdateConfigRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Attachment;
use App\Models\Config;
use App\Models\Disposition;
use App\Models\Letter;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\NoReturn;

class PageController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        // Ambil jumlah total surat masuk dan keluar (tidak reset setiap hari)
        $totalIncomingLetter = Letter::incoming()->count();
        $totalOutgoingLetter = Letter::outgoing()->count();
        $totalDispositionLetter = Disposition::count();
        $totalLetterTransaction = $totalIncomingLetter + $totalOutgoingLetter + $totalDispositionLetter;

        // Ambil data hari ini
        $todayIncomingLetter = Letter::incoming()->today()->count();
        $todayOutgoingLetter = Letter::outgoing()->today()->count();
        $todayDispositionLetter = Disposition::today()->count();
        $todayLetterTransaction = $todayIncomingLetter + $todayOutgoingLetter + $todayDispositionLetter;

        $yesterdayIncomingLetter = Letter::incoming()->yesterday()->count();
        $yesterdayOutgoingLetter = Letter::outgoing()->yesterday()->count();
        $yesterdayDispositionLetter = Disposition::yesterday()->count();
        $yesterdayLetterTransaction = $yesterdayIncomingLetter + $yesterdayOutgoingLetter + $yesterdayDispositionLetter;

        // Tambahkan greeting dan tanggal saat ini
        $greeting = GeneralHelper::greeting();
        $currentDate = Carbon::now()->isoFormat('dddd, D MMMM YYYY');

        // // Data transaksi per bulan (bisa diambil dari database)
        // $monthlyIncomingLetters = [10, 20, 15, 30, 25, 40, 35, 50, 45, 60, 55, 70];
        // $monthlyOutgoingLetters = [5, 15, 10, 25, 20, 30, 25, 35, 30, 45, 40, 60];

        $monthlyIncomingLetters = Letter::incoming()
    ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
    ->groupBy('month')
    ->orderBy('month')
    ->pluck('total', 'month')
    ->toArray();

$monthlyOutgoingLetters = Letter::outgoing()
    ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
    ->groupBy('month')
    ->orderBy('month')
    ->pluck('total', 'month')
    ->toArray();

// Pastikan array memiliki 12 bulan (Jan - Des)
$monthlyIncomingLetters = array_replace(array_fill(1, 12, 0), $monthlyIncomingLetters);
$monthlyOutgoingLetters = array_replace(array_fill(1, 12, 0), $monthlyOutgoingLetters);

        return view('pages.dashboard', [
          'greeting' => $greeting,
    'currentDate' => $currentDate,
    'totalIncomingLetter' => $totalIncomingLetter,
    'totalOutgoingLetter' => $totalOutgoingLetter,
    'todayIncomingLetter' => $todayIncomingLetter,
    'todayOutgoingLetter' => $todayOutgoingLetter,
    'todayDispositionLetter' => $todayDispositionLetter,
    'todayLetterTransaction' => $todayLetterTransaction,
    'totalLetterTransaction' => $totalLetterTransaction,
    'activeUser' => User::active()->count(),
    'percentageIncomingLetter' => GeneralHelper::calculateChangePercentage($yesterdayIncomingLetter, $todayIncomingLetter),
    'percentageOutgoingLetter' => GeneralHelper::calculateChangePercentage($yesterdayOutgoingLetter, $todayOutgoingLetter),
    'percentageDispositionLetter' => GeneralHelper::calculateChangePercentage($yesterdayDispositionLetter, $todayDispositionLetter),
    'percentageLetterTransaction' => GeneralHelper::calculateChangePercentage($yesterdayLetterTransaction, $todayLetterTransaction),
    'monthlyIncomingLetters' => array_values($monthlyIncomingLetters),
    'monthlyOutgoingLetters' => array_values($monthlyOutgoingLetters),


        ]);
    }

    public function profile(): View
    {
        // Ambil data user yang sedang login
        $user = Auth::user();

        return view('pages.profile', [
            'user' => $user,
            'currentDate' => Carbon::now()->isoFormat('dddd, D MMMM YYYY')
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->validate([
            // ... validasi lainnya
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            // Hapus gambar lama jika ada
            if (auth()->user()->profile_picture) {
                Storage::delete(auth()->user()->profile_picture);
            }

            // Simpan gambar baru
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user['profile_picture'] = $path;
        }

        auth()->user()->update($user);

        return back()->with('success', 'Profile updated');
    }

}

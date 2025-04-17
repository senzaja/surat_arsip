<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\IncomingController;
use App\Http\Controllers\LaporanMasukController;
use App\Http\Controllers\LaporanKeluarController;
use App\Http\Controllers\OutgoingController;
use App\Models\incoming;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Routes excel
Route::get('/incoming/export', [IncomingController::class, 'IncomingExport']);
Route::get('/outgoing/export', [OutgoingController::class, 'OutgoingExport']);

// Reset Password Routes
Route::get('/forgot-password', [LoginController::class, 'forgot_password'])->name('forgot-password')->middleware('guest');
Route::post('/forgot-password-act', [LoginController::class, 'forgot_password_act'])->name('forgot-password-act')->middleware('guest');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink($request->only('email'));

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/validasi-forgot-password/{token}', [LoginController::class, 'validasi_forgot_password'])->name('validasi-forgot-password')->middleware('guest');
Route::post('/validasi-forgot-password-act', [LoginController::class, 'validasi_forgot_password_act'])->name('validasi-forgot-password_act')->middleware('guest');

// // Register Routes
// Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
// Route::post('/register', [RegisterController::class, 'register'])->name('register');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', [\App\Http\Controllers\PageController::class, 'index'])->name('home');

    // all pdf
    Route::get('/incomings/pdf', [IncomingController::class, 'generateAllPdf'])->name('incomings.pdf');
    Route::get('/outgoings/pdf', [OutgoingController::class, 'generateAllPdf'])->name('outgoings.pdf');

    // User Management Routes (Admin Only)
    Route::resource('user', \App\Http\Controllers\UserController::class)
        ->except(['show', 'edit', 'create'])
        ->middleware(['role:admin']);

    // Profile Routes
    Route::get('profile', [\App\Http\Controllers\PageController::class, 'profile'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\PageController::class, 'updateProfile'])->name('profile.update');
    Route::put('profile/deactivate', [\App\Http\Controllers\PageController::class, 'deactivate'])->name('profile.deactivate')->middleware(['role:staff']);

    // Settings Routes (Admin Only)
    Route::get('settings', [\App\Http\Controllers\PageController::class, 'settings'])->name('settings.show')->middleware(['role:admin']);
    Route::put('settings', [\App\Http\Controllers\PageController::class, 'settingsUpdate'])->name('settings.update')->middleware(['role:admin']);

    // Attachment Deletion Route
    Route::delete('attachment', [\App\Http\Controllers\PageController::class, 'removeAttachment'])->name('attachment.destroy');

    // Transaction Routes
    Route::prefix('transaction')->as('transaction.')->group(function () {
        Route::resource('incoming', \App\Http\Controllers\IncomingController::class);
        Route::get('incoming/edit/{id}', [IncomingController::class, 'UpdateStatus'])->name('incoming.UpdateStatus');
        Route::resource('outgoing', \App\Http\Controllers\OutgoingController::class);

        // Print Routes for Incoming and Outgoing Letters
        Route::put('transaction/incoming/{id}', [IncomingController::class, 'update'])->name('transaction.incoming.update');
        Route::get('transaction/incoming/print/{id}', [IncomingController::class, 'print'])->name('incoming.print');
        Route::get('trasaction/outgoing/print', [\App\Http\Controllers\OutgoingController::class, 'print'])->name('outgoing.print');
    });

    // Gallery Routes
    Route::prefix('gallery')->as('gallery.')->group(function () {
        Route::get('incoming', [\App\Http\Controllers\LetterGalleryController::class, 'incoming'])->name('incoming');
        Route::get('outgoing', [\App\Http\Controllers\LetterGalleryController::class, 'outgoing'])->name('outgoing');
    });

    // Reference Routes (Admin Only)
    Route::prefix('reference')->as('reference.')->middleware(['role:admin'])->group(function () {
        Route::resource('classification', \App\Http\Controllers\ClassificationController::class)->except(['show', 'create', 'edit']);
        Route::resource('status', \App\Http\Controllers\LetterStatusController::class)->except(['show', 'create', 'edit']);
    });

    Route::get('/incoming/filter', [IncomingController::class, 'filter'])->name('incoming.filter');
});

Route::put('incoming/{id}', [IncomingController::class, 'update'])->name('transaction.incoming.update');
Route::get('/incomings/filter', [LaporanMasukController::class, 'filter'])->name('incomings.filter');
Route::get('/outgoings/filter', [LaporanKeluarController::class, 'filter'])->name('outgoings.filter');
// Authentication Routes
Auth::routes();

// Dashboard Route
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
Route::get('/laporan-masuk', function () {
    $data = incoming::all()->count();
    return view('pages.transaction.laporanmasuk.laporanmasuk', compact('data'));
})->name('laporanmasuk');
Route::get('/laporan-keluar', function () {
    $data = incoming::all()->count();
    return view('pages.transaction.laporankeluar.laporankeluar', compact('data'));
})->name('laporankeluar');

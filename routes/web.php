<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BankController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| HALAMAN LOGIN & REGISTER
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
});

Route::post('/post-login', [BankController::class, 'login']);
Route::post('/post-register', [BankController::class, 'register']);

Route::post('/logout', [BankController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| HALAMAN SETELAH LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [BankController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | KATALOG & SETOR SAMPAH
    |--------------------------------------------------------------------------
    */

    Route::get('/katalog', [BankController::class, 'katalog'])
        ->name('katalog');

    // Route utama setor sampah
    Route::post('/transaksi/store', [BankController::class, 'storeTransaksi'])
        ->name('transaksi.store');

    // Alias tambahan setor sampah
    Route::post('/setor-sampah', [BankController::class, 'storeTransaksi'])
        ->name('setor.sampah');

    /*
    |--------------------------------------------------------------------------
    | TARIK SALDO
    |--------------------------------------------------------------------------
    */

    Route::post('/tarik-saldo', [BankController::class, 'tarikSaldo'])
        ->name('tarik.saldo');

    /*
    |--------------------------------------------------------------------------
    | VALIDASI ADMIN
    |--------------------------------------------------------------------------
    */

    // Route lama tetap dipertahankan
    Route::post('/transaksi/konfirmasi/{id}', [BankController::class, 'konfirmasi'])
        ->name('transaksi.konfirmasi');

    // Route admin baru
    Route::post('/admin/konfirmasi/{id}', [BankController::class, 'konfirmasi'])
        ->name('admin.konfirmasi');

    Route::post('/admin/tolak/{id}', [BankController::class, 'tolak'])
        ->name('admin.tolak');

    /*
    |--------------------------------------------------------------------------
    | HAPUS TRANSAKSI
    |--------------------------------------------------------------------------
    */

    Route::delete('/transaksi/delete/{id}', [BankController::class, 'destroy'])
        ->name('transaksi.destroy');

    /*
    |--------------------------------------------------------------------------
    | CETAK RESI PDF
    |--------------------------------------------------------------------------
    */

    // Resi tarik tunai
    Route::get('/resi-tarik/{id}', [BankController::class, 'cetakResiTarik'])
        ->name('resi.tarik');

    // Resi transaksi setor sampah PDF
    Route::get('/resi-pdf/{id}', [BankController::class, 'cetakResi'])
        ->name('resi.pdf');

    /*
    |--------------------------------------------------------------------------
    | LAPORAN PDF
    |--------------------------------------------------------------------------
    */

    // Laporan PDF lama
    Route::get('/laporan/cetak', [BankController::class, 'cetakLaporan'])
        ->name('laporan.cetak');

    // Laporan PDF admin terbaru
    Route::get('/laporan-admin-pdf', [BankController::class, 'laporanAdminPdf'])
        ->name('admin.laporan.pdf');

    /*
    |--------------------------------------------------------------------------
    | DATA NASABAH
    |--------------------------------------------------------------------------
    */

    // Menimpa rute POST register agar tidak otomatis login
Route::post('/register', function (Illuminate\Http\Request $request) {
    // 1. Ambil controller registrasi bawaan sistem secara manual
    $controller = app()->make(App\Http\Controllers\Auth\RegisteredUserController::class);
    
    // 2. Jalankan fungsi store (untuk simpan data user)
    $response = $controller->store($request);

    // 3. PAKSA LOGOUT & HAPUS SESSION
    Auth::logout();
    Session::flush();
    Session::regenerate();

    // 4. LEMPAR KE HALAMAN LOGIN
    return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan masuk.');
    })->middleware('guest');

     
    Route::get('/dashboard', [BankController::class, 'index'])->name('nasabah.index');
    Route::get('/dashboard', [BankController::class, 'index'])->name('dashboard');

    


});

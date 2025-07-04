<?php

use App\Models\PendudukMiskinModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SKUsahaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DokumenSKTMController;
use App\Http\Controllers\DataPenggunaController;
use App\Http\Controllers\SKPerkawinanController;
use App\Http\Controllers\SKTidakMampuController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PendudukMiskinController;
use App\Http\Controllers\PetaPersebaranController;
use App\Http\Controllers\DokumenController;

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/test', function () {
    return view('test');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('/dashboard', function () {
//     return view('dashboard'); // ganti sesuai nama view
// })->middleware('auth');
// Route::get('dashboard', function () {
//     return view('dashboard');
// });
// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// routes/web.php ✅ BENAR
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
// Route::get('/dokumen/sktm/{tipe}/{filename}', [DokumenSKTMController::class, 'view'])
//     ->middleware('auth')
//     ->name('dokumen.sktm.view');

// Route::get('/sk_tidak_mampu', [SKTidakMampuController::class, 'index'])->name('sk_tidak_mampu');
Route::get('/sk_tidak_mampu', [SKTidakMampuController::class, 'index'])->name('sktm.index')->middleware('auth');
Route::post('/sktm/store', [SKTidakMampuController::class, 'store'])->name('sktm.store');
Route::get('/sktm/{id}', [SKTidakMampuController::class, 'show'])->name('sktm.show');
Route::post('/sktm/{id}/verifikasi', [SKTidakMampuController::class, 'verifikasi'])->name('sktm.verifikasi');
Route::get('/sktm/{id}/cetak', [SKTidakMampuController::class, 'cetak'])->name('sktm.cetak');
// Route::get('/sktm/cetak/{id}', [SKTidakMampuController::class, 'cetak'])->name('sktm.cetak');

Route::delete('/sktm/destroy/{id}', [SKTidakMampuController::class, 'destroy'])->name('sktm.destroy');
Route::put('/sktm/update{id}', [SKTidakMampuController::class, 'update'])->name('sktm.update');

Route::get('/sk_usaha', [SKUsahaController::class, 'index'])->name('sku.index')->middleware('auth');
Route::post('/sku/store', [SKUsahaController::class, 'store'])->name('sku.store');
Route::get('/sku/{id}', [SKUsahaController::class, 'show'])->name('sku.show');
Route::post('/sku/{id}/verifikasi', [SKUsahaController::class, 'verifikasi'])->name('sku.verifikasi');
Route::get('/sku/{id}/cetak', [SKUsahaController::class, 'cetak'])->name('sku.cetak');
Route::delete('/sku/destroy/{id}', [SKUsahaController::class, 'destroy'])->name('sku.destroy');
Route::put('/sku/update{id}', [SKUsahaController::class, 'update'])->name('sku.update');


Route::get('/sk_perkawinan', [SKPerkawinanController::class, 'index'])->name('skp.index')->middleware('auth');
Route::post('/skp/store', [SKPerkawinanController::class, 'store'])->name('skp.store');
Route::get('/skp/{id}', [SKPerkawinanController::class, 'show'])->name('skp.show');
Route::post('/skp/{id}/verifikasi', [SKPerkawinanController::class, 'verifikasi'])->name('skp.verifikasi');
Route::get('/skp/{id}/cetak', [SKPerkawinanController::class, 'cetak'])->name('skp.cetak');
Route::delete('/skp/destroy/{id}', [SKPerkawinanController::class, 'destroy'])->name('skp.destroy');
// Route::put('/skp/update{id}', [SKPerkawinanController::class, 'update'])->name('skp.update');
Route::put('/skp/{id}', [SKPerkawinanController::class, 'update'])->name('skp.update');


// Route::get('/penduduk_miskin', [PendudukMiskinController::class, 'index'])->name('pendudukMiskin.penduduk_miskin');
// Route::post('/pendudukMiskin/store', [PendudukMiskinController::class, 'store'])->name('pendudukMiskin.store');
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/penduduk_miskin', [PendudukMiskinController::class, 'index'])->name('pendudukMiskin.index');
    Route::post('/pendudukMiskin/store', [PendudukMiskinController::class, 'store'])->name('pendudukMiskin.store');
Route::get('/pendudukMiskin/{id}', [PendudukMiskinController::class, 'show'])->name('pendudukMiskin.show');
Route::delete('/pendudukMiskin/destroy/{id}', [PendudukMiskinController::class, 'destroy'])->name('pendudukMiskin.destroy');
Route::put('/pendudukMiskin/update{id}', [PendudukMiskinController::class, 'update'])->name('pendudukMiskin.update');

});

Route::middleware(['auth', 'role:Admin,Lurah,Sekretaris'])->group(function () {
    Route::get('/peta', [PetaPersebaranController::class, 'index'])->name('pendudukMiskin.peta');
});

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/data_pengguna', [DataPenggunaController::class, 'index'])->name('dataPengguna.index');
    Route::post('/data_pengguna/store', [DataPenggunaController::class, 'store'])->name('dataPengguna.store');
    Route::put('/data_pengguna/{id}', [DataPenggunaController::class, 'update'])->name('data_pengguna.update');
    Route::delete('/data_pengguna/destroy/{id}', [DataPenggunaController::class, 'destroy'])->name('data_pengguna.destroy');
});

Route::get('/dokumen/{folder}/{filename}', [DokumenController::class, 'show'])
    ->middleware('auth') // hanya untuk user login
    ->name('dokumen.show');
// Route::get('/peta_persebaran', [PetaPersebaranController::class, 'index'])->name('peta_persebaran');
// Route::get('/data_pengguna', [DataPenggunaController::class, 'index'])->name('data_pengguna');

// Route::get('/data_pengguna', [DataPenggunaController::class, 'index'])->name('dataPengguna.data_pengguna');
// Route::post('/data_pengguna/store', [DataPenggunaController::class, 'store'])->name('dataPengguna.store');
// // Route::get('/data_pengguna/{id}/edit', [DataPenggunaController::class, 'edit'])->name('data_pengguna.edit');
// Route::put('/data_pengguna/{id}', [DataPenggunaController::class, 'update'])->name('data_pengguna.update');
// Route::delete('/data_pengguna/destroy/{id}', [DataPenggunaController::class, 'destroy'])->name('data_pengguna.destroy');




// Route::get('sktm', function () {
//     return view('sk_tidak_mampu');
// });

// Route::get('sk_usaha', function () {
//     return view('sk_usaha');
// });
// Route::get('sk_perkawinan', function () {
//     return view('sk_perkawinan');
// });
// Route::get('penduduk_miskin', function () {
//     return view('penduduk_miskin');
// });
// Route::get('peta', function () {
//     return view('peta_persebaran');
// });
// Route::get('data_pengguna', function () {
//     return view('data_pengguna');
// });
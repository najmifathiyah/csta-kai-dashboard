<?php


use Illuminate\Support\Facades\Route;


use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DatasetController;
use App\Http\Controllers\LayananController;



/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/



// ==================================================
// DASHBOARD UTAMA
// ==================================================


// Halaman utama
Route::get(
    '/',
    [DashboardController::class, 'index']
)->name('dashboard.home');



// Dashboard utama
Route::get(
    '/dashboard',
    [DashboardController::class, 'index']
)->name('dashboard');





// ==================================================
// DASHBOARD / HALAMAN LAYANAN
// ==================================================
//
// BAGIAN INI DIBUAT AGAR SETIAP LAYANAN
// MEMPUNYAI HALAMAN SENDIRI.
//
// Jadi:
// Tiket KAI             -> halaman Tiket KAI
// Mitra KAI Group       -> halaman Mitra KAI Group
// Mitra Non KAI Group   -> halaman Mitra Non KAI Group
//
// TIDAK MASUK KE DASHBOARD UTAMA.
// ==================================================



// Route utama halaman layanan
Route::get(
    '/layanan/{layanan}',
    [LayananController::class, 'index']
)->name('layanan.index');





// ==================================================
// ROUTE LAMA DASHBOARD LAYANAN
// ==================================================
//
// Route ini tetap dipertahankan supaya link lama
// yang mungkin masih digunakan tidak rusak.
//
// Tetapi sekarang diarahkan ke LayananController,
// bukan lagi DashboardController.
//
// ==================================================



// ------------------------------
// Tiket KAI
// ------------------------------


Route::get(
    '/dashboard/tiket-kai',
    function () {
        return redirect()->route(
            'layanan.index',
            [
                'layanan' => 'Tiket KAI'
            ]
        );
    }
)->name('dashboard.tiket');





// ------------------------------
// Mitra KAI Group
// ------------------------------


Route::get(
    '/dashboard/mitra-kai-group',
    function () {
        return redirect()->route(
            'layanan.index',
            [
                'layanan' => 'Mitra KAI Group'
            ]
        );
    }
)->name('dashboard.mitra');





// ------------------------------
// Mitra Non KAI Group
// ------------------------------


Route::get(
    '/dashboard/mitra-non-kai-group',
    function () {
        return redirect()->route(
            'layanan.index',
            [
                'layanan' => 'Mitra Non KAI Group'
            ]
        );
    }
)->name('dashboard.mitra.non');





// ==================================================
// MASTER DIVISI
// ==================================================


Route::resource(
    'divisions',
    DivisionController::class
);





// ==================================================
// MASTER KATEGORI
// ==================================================


Route::resource(
    'categories',
    CategoryController::class
);





// ==================================================
// DATASET EXCEL
// ==================================================


// Halaman daftar dataset
Route::get(
    '/dataset',
    [DatasetController::class, 'index']
)->name('dataset.index');


// ==================================================
// KELUAR DARI DATASET
// ==================================================
//
// ROUTE INI HARUS SEBELUM /dataset/{nama_file}
// AGAR "keluar" TIDAK DIBACA SEBAGAI NAMA FILE.
// ==================================================

Route::get(
    '/dataset/keluar',
    [DatasetController::class, 'keluar']
)->name('dataset.keluar');


// Detail dataset berdasarkan nama file
Route::get(
    '/dataset/{nama_file}',
    [DatasetController::class, 'show']
)->name('dataset.show');


// Hapus dataset
Route::delete(
    '/dataset/{nama_file}',
    [DatasetController::class, 'destroy']
)->name('dataset.destroy');





// ==================================================
// DATA TRANSAKSI
// ==================================================


Route::resource(
    'transaksi',
    TransaksiController::class
);





// ==================================================
// IMPORT EXCEL
// ==================================================


// Halaman import
Route::get(
    '/import',
    [ImportController::class, 'index']
)->name('import.index');



// Proses import
Route::post(
    '/import',
    [ImportController::class, 'store']
)->name('import.store');
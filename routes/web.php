<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DatasetController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


// ================================
// DASHBOARD
// ================================

Route::get('/', [DashboardController::class, 'index']);

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');



// ================================
// MASTER DIVISI
// ================================

Route::resource('divisions', DivisionController::class);



// ================================
// MASTER KATEGORI
// ================================

Route::resource('categories', CategoryController::class);



// ================================
// DATASET EXCEL
// ================================

Route::get('/dataset',
    [DatasetController::class, 'index']
)->name('dataset.index');


Route::get('/dataset/{nama_file}',
    [DatasetController::class, 'show']
)->name('dataset.show');



// ================================
// DATA TRANSAKSI
// ================================

Route::resource('transaksi', TransaksiController::class);



// ================================
// IMPORT EXCEL
// ================================

Route::get('/import',
    [ImportController::class, 'index']
)->name('import.index');


Route::post('/import',
    [ImportController::class, 'store']
)->name('import.store');
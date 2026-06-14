<?php
 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/buku/search', [App\Http\Controllers\BukuController::class, 'search'])->name('buku.search');

// Resource route untuk Buku
Route::post('/buku/bulk-delete', [App\Http\Controllers\BukuController::class, 'bulkDelete'])->name('buku.bulk-delete');
// Route untuk Export CSV Buku
Route::get('/buku/export', [\App\Http\Controllers\BukuController::class, 'export'])->name('buku.export');

Route::resource('buku', BukuController::class);

// Custom route untuk filter kategori
Route::get('/buku/kategori/{kategori}', [BukuController::class, 'filterKategori'])
     ->name('buku.kategori');
 
// Resource route untuk Anggota (akan dibuat nanti)
Route::get('/anggota/export', [App\Http\Controllers\AnggotaController::class, 'export'])->name('anggota.export');

Route::get('/anggota/search', [App\Http\Controllers\AnggotaController::class, 'search'])->name('anggota.search');

Route::resource('anggota', AnggotaController::class)->parameters([
    'anggota' => 'anggota'
]);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
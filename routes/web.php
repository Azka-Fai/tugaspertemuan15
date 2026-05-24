<?php
 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerpustakaanController;
 
Route::get('/', function () {
    return view('welcome');
});
 
// Route menggunakan Controller
Route::get('/perpustakaan', [PerpustakaanController::class, 'index']);
Route::get('/buku/{id}', [PerpustakaanController::class, 'show']);
Route::get('/about', [PerpustakaanController::class, 'about']);

// 1. Route untuk nampilin seluruh daftar anggota
Route::get('/anggota', function () {
    $anggota_list = [
        ['id' => 1, 'kode' => 'AGT-001', 'nama' => 'Budi Santoso', 'email' => 'budi@email.com', 'telepon' => '081234567890', 'alamat' => 'Jakarta', 'status' => 'Aktif'],
        ['id' => 2, 'kode' => 'AGT-002', 'nama' => 'Siti Aminah', 'email' => 'siti@email.com', 'telepon' => '082345678901', 'alamat' => 'Bandung', 'status' => 'Aktif'],
        ['id' => 3, 'kode' => 'AGT-003', 'nama' => 'Andi Wijaya', 'email' => 'andi@email.com', 'telepon' => '083456789012', 'alamat' => 'Surabaya', 'status' => 'Non-Aktif'],
        ['id' => 4, 'kode' => 'AGT-004', 'nama' => 'Dewi Lestari', 'email' => 'dewi@email.com', 'telepon' => '084567890123', 'alamat' => 'Yogyakarta', 'status' => 'Aktif'],
        ['id' => 5, 'kode' => 'AGT-005', 'nama' => 'Rizky Pratama', 'email' => 'rizky@email.com', 'telepon' => '085678901234', 'alamat' => 'Semarang', 'status' => 'Non-Aktif'],
    ];

    return view('anggota.index', compact('anggota_list'));
});

// 2. Route untuk nampilin detail 1 anggota berdasarkan ID
Route::get('/anggota/{id}', function ($id) {
    $anggota_list = [
        ['id' => 1, 'kode' => 'AGT-001', 'nama' => 'Budi Santoso', 'email' => 'budi@email.com', 'telepon' => '081234567890', 'alamat' => 'Jakarta', 'status' => 'Aktif'],
        ['id' => 2, 'kode' => 'AGT-002', 'nama' => 'Siti Aminah', 'email' => 'siti@email.com', 'telepon' => '082345678901', 'alamat' => 'Bandung', 'status' => 'Aktif'],
        ['id' => 3, 'kode' => 'AGT-003', 'nama' => 'Andi Wijaya', 'email' => 'andi@email.com', 'telepon' => '083456789012', 'alamat' => 'Surabaya', 'status' => 'Non-Aktif'],
        ['id' => 4, 'kode' => 'AGT-004', 'nama' => 'Dewi Lestari', 'email' => 'dewi@email.com', 'telepon' => '084567890123', 'alamat' => 'Yogyakarta', 'status' => 'Aktif'],
        ['id' => 5, 'kode' => 'AGT-005', 'nama' => 'Rizky Pratama', 'email' => 'rizky@email.com', 'telepon' => '085678901234', 'alamat' => 'Semarang', 'status' => 'Non-Aktif'],
    ];

    // Mengambil satu data yang sesuai dengan {id} di URL
    $anggota = collect($anggota_list)->firstWhere('id', (int)$id);

    return view('anggota.show', compact('anggota'));
});

use App\Http\Controllers\KategoriController;

// Route Kategori (Menggunakan Named Routes untuk Bonus)
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
Route::get('/kategori/search/{keyword}', [KategoriController::class, 'search'])->name('kategori.search');
Route::get('/kategori/{id}', [KategoriController::class, 'show'])->name('kategori.show');
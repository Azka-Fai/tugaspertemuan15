<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // Fungsi bantuan untuk menyimpan data dummy kategori agar tidak diketik berulang
    private function dataKategori()
    {
        return [
            ['id' => 1, 'nama' => 'Programming', 'deskripsi' => 'Buku pemrograman dan coding', 'jumlah_buku' => 25],
            ['id' => 2, 'nama' => 'Desain Grafis', 'deskripsi' => 'Buku UI/UX dan Adobe', 'jumlah_buku' => 15],
            ['id' => 3, 'nama' => 'Jaringan', 'deskripsi' => 'Buku Networking dan Keamanan', 'jumlah_buku' => 20],
            ['id' => 4, 'nama' => 'Database', 'deskripsi' => 'Buku SQL, NoSQL dan Big Data', 'jumlah_buku' => 30],
            ['id' => 5, 'nama' => 'Sistem Operasi', 'deskripsi' => 'Buku Windows, Linux, dan MacOS', 'jumlah_buku' => 10],
        ];
    }

    public function index()
    {
        $kategori_list = $this->dataKategori();
        return view('kategori.index', compact('kategori_list'));
    }

    public function show($id)
    {
        $semua_kategori = collect($this->dataKategori());
        $kategori = $semua_kategori->firstWhere('id', (int)$id);

        // Data dummy buku dalam kategori ini
        $buku_list = [
            ['judul' => 'Belajar Laravel 10', 'pengarang' => 'Budi', 'tahun' => 2023],
            ['judul' => 'Mahir PHP dalam 7 Hari', 'pengarang' => 'Andi', 'tahun' => 2022],
        ];

        return view('kategori.show', compact('kategori', 'buku_list'));
    }

    public function search($keyword)
    {
        $semua_kategori = $this->dataKategori();
        
        // Filter kategori berdasarkan keyword (case-insensitive)
        $kategori_list = array_filter($semua_kategori, function ($item) use ($keyword) {
            return stripos($item['nama'], $keyword) !== false || stripos($item['deskripsi'], $keyword) !== false;
        });

        return view('kategori.search', compact('kategori_list', 'keyword'));
    }
}
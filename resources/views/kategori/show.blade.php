@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('kategori.index') }}">Kategori</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $kategori['nama'] }}</li>
  </ol>
</nav>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h3>Detail Kategori: {{ $kategori['nama'] }}</h3>
        <p class="text-muted">{{ $kategori['deskripsi'] }}</p>
        <p><strong>Total Koleksi:</strong> {{ $kategori['jumlah_buku'] }} Buku</p>
    </div>
</div>

<h4>Daftar Buku dalam Kategori Ini</h4>
<table class="table table-bordered table-striped mt-3">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Judul Buku</th>
            <th>Pengarang</th>
            <th>Tahun Terbit</th>
        </tr>
    </thead>
    <tbody>
        @foreach($buku_list as $index => $buku)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $buku['judul'] }}</td>
            <td>{{ $buku['pengarang'] }}</td>
            <td>{{ $buku['tahun'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('kategori.index') }}" class="btn btn-secondary mt-3">Kembali</a>
@endsection
@extends('layouts.app')

@section('content')
<h2 class="mb-4">Daftar Kategori Buku</h2>

<div class="row">
    @foreach ($kategori_list as $kategori)
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-primary">{{ $kategori['nama'] }}</h5>
                <p class="card-text text-muted">{{ $kategori['deskripsi'] }}</p>
                <p class="card-text"><strong>Jumlah Buku:</strong> <span class="badge bg-secondary">{{ $kategori['jumlah_buku'] }}</span></p>
            </div>
            <div class="card-footer bg-white border-0 pb-3">
                <a href="{{ route('kategori.show', $kategori['id']) }}" class="btn btn-outline-primary btn-sm w-100">Lihat Detail</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
@extends('layouts.app')

@section('content')
<h2 class="mb-4">Hasil Pencarian: "{{ $keyword }}"</h2>
<a href="{{ route('kategori.index') }}" class="btn btn-secondary btn-sm mb-4">Kembali ke Semua Kategori</a>

<div class="row">
    @forelse ($kategori_list as $kategori)
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm border-info">
            <div class="card-body">
                <h5 class="card-title text-primary">
                    {!! str_ireplace($keyword, "<mark><strong>$keyword</strong></mark>", $kategori['nama']) !!}
                </h5>
                <p class="card-text text-muted">
                    {!! str_ireplace($keyword, "<mark><strong>$keyword</strong></mark>", $kategori['deskripsi']) !!}
                </p>
            </div>
            <div class="card-footer bg-white border-0 pb-3">
                <a href="{{ route('kategori.show', $kategori['id']) }}" class="btn btn-outline-info btn-sm w-100">Lihat Detail</a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-warning">Kategori dengan kata kunci "<strong>{{ $keyword }}</strong>" tidak ditemukan.</div>
    </div>
    @endforelse
</div>
@endsection
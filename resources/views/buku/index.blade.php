<x-app-layout>
    <div class="container py-5">  
@section('title', 'Daftar Buku')
 
<div class="mb-4">
    <h1>
        <i class="bi bi-book"></i>
        Daftar Buku
    </h1>
</div>
 
{{-- Statistik Cards --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Buku</h6>
                        <h2 class="mb-0">{{ $totalBuku }}</h2>
                    </div>
                    <div class="text-primary">
                        <i class="bi bi-book-fill" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Buku Tersedia</h6>
                        <h2 class="mb-0">{{ $bukuTersedia }}</h2>
                    </div>
                    <div class="text-success">
                        <i class="bi bi-check-circle-fill" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Buku Habis</h6>
                        <h2 class="mb-0">{{ $bukuHabis }}</h2>
                    </div>
                    <div class="text-danger">
                        <i class="bi bi-x-circle-fill" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 
{{-- Filter Kategori --}}
<div class="card mb-4">
    <div class="card-body">
        <h6 class="card-title">
            <i class="bi bi-funnel"></i> Filter Kategori:
        </h6>
        <div class="btn-group" role="group">
            <a href="{{ route('buku.index') }}" class="btn btn-sm {{ !isset($kategori) ? 'btn-primary' : 'btn-outline-primary' }}">
                Semua
            </a>
            <a href="{{ route('buku.kategori', 'Programming') }}" class="btn btn-sm {{ isset($kategori) && $kategori == 'Programming' ? 'btn-primary' : 'btn-outline-primary' }}">
                Programming
            </a>
            <a href="{{ route('buku.kategori', 'Database') }}" class="btn btn-sm {{ isset($kategori) && $kategori == 'Database' ? 'btn-primary' : 'btn-outline-primary' }}">
                Database
            </a>
            <a href="{{ route('buku.kategori', 'Web Design') }}" class="btn btn-sm {{ isset($kategori) && $kategori == 'Web Design' ? 'btn-primary' : 'btn-outline-primary' }}">
                Web Design
            </a>
            <a href="{{ route('buku.kategori', 'Networking') }}" class="btn btn-sm {{ isset($kategori) && $kategori == 'Networking' ? 'btn-primary' : 'btn-outline-primary' }}">
                Networking
            </a>
            <a href="{{ route('buku.kategori', 'Data Science') }}" class="btn btn-sm {{ isset($kategori) && $kategori == 'Data Science' ? 'btn-primary' : 'btn-outline-primary' }}">
                Data Science
            </a>
        </div>
    </div>
</div>
 
{{-- Daftar Buku --}}

<div class="card mb-4 shadow-sm border-0">
    <div class="card-body bg-light rounded">
        <form action="{{ route('buku.search') }}" method="GET" class="row g-2 align-items-center">
            
            <div class="col-md-4">
                <input type="text" name="keyword" class="form-control" placeholder="Cari Judul, Pengarang, Penerbit..." value="{{ request('keyword') }}">
            </div>
            
            <div class="col-md-3">
                <select name="kategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    <option value="Programming" {{ request('kategori') == 'Programming' ? 'selected' : '' }}>Programming</option>
                    <option value="Database" {{ request('kategori') == 'Database' ? 'selected' : '' }}>Database</option>
                    <option value="Web Design" {{ request('kategori') == 'Web Design' ? 'selected' : '' }}>Web Design</option>
                    <option value="Networking" {{ request('kategori') == 'Networking' ? 'selected' : '' }}>Networking</option>
                    <option value="Data Science" {{ request('kategori') == 'Data Science' ? 'selected' : '' }}>Data Science</option>
                </select>
            </div>
            
            <div class="col-md-2">
                <select name="tahun" class="form-select">
                    <option value="">Semua Tahun</option>
                    @for($i = date('Y'); $i >= 2010; $i--)
                        <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            
            <div class="col-md-2">
                <select name="ketersediaan" class="form-select">
                    <option value="">Semua Ketersediaan</option>
                    <option value="tersedia" {{ request('ketersediaan') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="habis" {{ request('ketersediaan') == 'habis' ? 'selected' : '' }}>Habis</option>
                </select>
            </div>
            
            <div class="col-md-1 d-grid">
                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
            </div>
            
        </form>
    </div>
</div>

<!-- Form Bulk Delete -->
<form action="{{ route('buku.bulk-delete') }}" method="POST" id="bulk-delete-form">
    @csrf
</form>

<!-- Tombol Select All & Aksi -->
<div class="d-flex justify-content-between align-items-center mb-3 mt-4">
    <div class="form-check">
        <input type="checkbox" id="select-all" class="form-check-input border-dark">
        <label class="form-check-label fw-bold" for="select-all">Pilih Semua Buku</label>
    </div>
    
    <div class="d-flex gap-2">
        <a href="{{ route('buku.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i> Tambah Buku
        </a>
        <a href="{{ route('buku.export') }}" class="btn btn-success btn-sm">
            <i class="bi bi-download"></i> Export CSV
        </a>
        <button type="submit" form="bulk-delete-form" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus semua buku yang dipilih?')">
            <i class="bi bi-trash"></i> Hapus Terpilih
        </button>
    </div>
</div>

<!-- Looping Data Buku  -->
<div class="row">
    @forelse ($bukus as $buku)
        <div class="col-md-6 col-lg-4 mb-4 d-flex flex-column">
            <!-- Checkbox untuk tiap buku. Perhatikan tambahan form="bulk-delete-form" -->
            <div class="form-check mb-2">
                <input class="form-check-input border-dark" type="checkbox" name="buku_ids[]" value="{{ $buku->id }}" id="check-{{ $buku->id }}" form="bulk-delete-form">
                <label class="form-check-label text-muted small" for="check-{{ $buku->id }}">Tandai buku ini</label>
            </div>
            
            <!-- Card Buku bawaan -->
            <x-buku-card :buku="$buku" /> 
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Tidak ada data buku
            </div>
        </div>
    @endforelse
</div>
 
@if ($bukus->count() > 0)
    <div class="text-center mt-4">
        <p class="text-muted">
            Menampilkan {{ $bukus->count() }} buku
            @isset($kategori)
                dari kategori <strong>{{ $kategori }}</strong>
            @endisset
        </p>
    </div>
@endif


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Script Select All Checkbox
    document.getElementById('select-all').addEventListener('change', function() {
        document.querySelectorAll('input[name="buku_ids[]"]').forEach(cb => {
            cb.checked = this.checked;
        });
    });

    // SweetAlert confirmation untuk delete
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            const judul = this.getAttribute('data-judul');

            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus buku "${judul}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
</div> </x-app-layout>

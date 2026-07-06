<div class="card flex-grow-1">
    <div class="card-body">
        <h5 class="card-title text-primary mb-3">
            <i class="bi bi-book-half me-2"></i> {{ $buku->judul }}
        </h5>

        <div class="mb-3">
            {{-- Sesuaikan $buku->kategori dengan relasi di database Anda, atau ganti jika berupa string biasa --}}
            <span class="badge bg-info text-dark">{{ $buku->kategori ?? 'Umum' }}</span>
        </div>

        <p class="card-text mb-1">
            <small class="text-muted"><i class="bi bi-person me-1"></i> {{ $buku->pengarang }}</small>
        </p>
        <p class="card-text mb-2">
            <small class="text-muted"><i class="bi bi-tag me-1"></i> Rp {{ number_format($buku->harga, 0, ',', '.') }}</small>
        </p>

        <div class="mt-3">
            @if($buku->stok > 0)
                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Tersedia ({{ $buku->stok }})</span>
            @else
                <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i> Habis</span>
            @endif
        </div>
    </div>

    <div class="card-footer bg-transparent">
        <div class="d-flex justify-content-between">
            <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-sm btn-info text-white" title="Detail">
                <i class="bi bi-eye"></i> Detail
            </a>
            <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-sm btn-warning" title="Edit">
                <i class="bi bi-pencil"></i> Edit
            </a>
            {{-- Delete Button dengan SweetAlert --}}
            <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="d-inline delete-form">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-sm btn-danger btn-delete" data-judul="{{ $buku->judul }}" title="Hapus">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>
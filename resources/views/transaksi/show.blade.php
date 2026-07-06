<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Tugas 3: Warning Terlambat --}}
            @if($transaksi->status == 'Dipinjam' && $transaksi->terlambat > 0)
                <div class="alert alert-danger" role="alert">
                    <h5 class="alert-heading">
                        <i class="bi bi-exclamation-triangle-fill"></i> Peringatan Keterlambatan!
                    </h5>
                    <p class="mb-0">
                        Buku <strong>"{{ $transaksi->buku->judul }}"</strong> sudah <strong>terlambat {{ ceil($transaksi->terlambat) }} hari</strong> 
                        dari batas pengembalian ({{ $transaksi->tanggal_kembali->format('d M Y') }}).
                    </p>
                    <hr>
                    <p class="mb-0">
                        <strong>Estimasi denda saat ini:</strong> 
                        Rp {{ number_format($transaksi->denda_berjalan, 0, ',', '.') }}
                        <small class="text-muted">({{ ceil($transaksi->terlambat) }} hari × Rp 5.000)</small>
                    </p>
                </div>
            @endif

            <div class="row">
                {{-- Kolom Kiri: Detail Transaksi --}}
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">
                                <i class="bi bi-receipt"></i>
                                Detail Transaksi #{{ $transaksi->kode_transaksi }}
                            </h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th width="200">Kode Transaksi</th>
                                        <td><code>{{ $transaksi->kode_transaksi }}</code></td>
                                    </tr>
                                    <tr>
                                        <th>Anggota</th>
                                        <td>
                                            {{ $transaksi->anggota->nama }}
                                            <br>
                                            <small class="text-muted">{{ $transaksi->anggota->kode_anggota }}</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Buku</th>
                                        <td>
                                            {{ $transaksi->buku->judul }}
                                            <br>
                                            <small class="text-muted">{{ $transaksi->buku->pengarang }}</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Pinjam</th>
                                        <td>{{ $transaksi->tanggal_pinjam->format('d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Harus Kembali</th>
                                        <td>
                                            {{ $transaksi->tanggal_kembali->format('d M Y') }}
                                            @if($transaksi->status == 'Dipinjam' && $transaksi->terlambat > 0)
                                                <span class="badge bg-danger ms-2">Sudah lewat!</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Dikembalikan</th>
                                        <td>
                                            @if($transaksi->tanggal_dikembalikan)
                                                {{ $transaksi->tanggal_dikembalikan->format('d M Y') }}
                                            @else
                                                <span class="text-muted">Belum dikembalikan</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Durasi Peminjaman</th>
                                        <td>{{ ceil($transaksi->durasi_peminjaman) }} hari</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @if($transaksi->status == 'Dipinjam')
                                                <span class="badge bg-warning text-dark fs-6">Dipinjam</span>
                                            @else
                                                <span class="badge bg-success fs-6">Dikembalikan</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if($transaksi->keterangan)
                                    <tr>
                                        <th>Keterangan</th>
                                        <td>{{ $transaksi->keterangan }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Informasi Denda & Aksi --}}
                <div class="col-md-4">
                    {{-- Card Denda --}}
                    <div class="card mb-3">
                        <div class="card-header {{ $transaksi->denda > 0 ? 'bg-danger text-white' : 'bg-light' }}">
                            <h5 class="mb-0">
                                <i class="bi bi-cash-stack"></i> Informasi Denda
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($transaksi->status == 'Dikembalikan')
                                @if($transaksi->terlambat > 0)
                                    <div class="text-center">
                                        <p class="text-muted mb-1">Keterlambatan</p>
                                        <h4 class="text-danger">{{ ceil($transaksi->terlambat) }} hari</h4>
                                        <hr>
                                        <p class="text-muted mb-1">Total Denda</p>
                                        <h3 class="text-danger">Rp {{ number_format($transaksi->denda, 0, ',', '.') }}</h3>
                                        <small class="text-muted">{{ ceil($transaksi->terlambat) }} hari × Rp 5.000</small>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                                        <p class="mt-2 mb-0 text-success fw-bold">Tepat Waktu!</p>
                                        <p class="text-muted">Tidak ada denda</p>
                                    </div>
                                @endif
                            @else
                                {{-- Status masih Dipinjam --}}
                                @if($transaksi->terlambat > 0)
                                    <div class="text-center">
                                        <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 3rem;"></i>
                                        <p class="mt-2 mb-1 text-danger fw-bold">Terlambat {{ ceil($transaksi->terlambat) }} hari</p>
                                        <hr>
                                        <p class="text-muted mb-1">Estimasi Denda</p>
                                        <h3 class="text-danger">Rp {{ number_format($transaksi->denda_berjalan, 0, ',', '.') }}</h3>
                                        <small class="text-muted">Denda bertambah Rp 5.000/hari</small>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <i class="bi bi-clock text-warning" style="font-size: 3rem;"></i>
                                        <p class="mt-2 mb-0 text-warning fw-bold">Masih Dalam Batas Waktu</p>
                                        <p class="text-muted">
                                            Sisa {{ ceil(now()->diffInDays($transaksi->tanggal_kembali)) }} hari lagi
                                        </p>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>

                    {{-- Card Aksi --}}
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="bi bi-gear"></i> Aksi
                            </h5>
                        </div>
                        <div class="card-body d-grid gap-2">
                            @if($transaksi->status === 'Dipinjam')
                                <button type="button" class="btn btn-success w-100" id="btn-kembalikan">
                                    <i class="bi bi-box-arrow-in-left"></i> Kembalikan Buku
                                </button>
                             
                                <form id="form-kembalikan" action="{{ route('transaksi.kembalikan', $transaksi->id) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('PUT')
                                </form>
                            @else
                                @if($transaksi->tanggal_dikembalikan <= $transaksi->tanggal_kembali)
                                    <div class="alert alert-success">
                                        <i class="bi bi-check-circle"></i> Dikembalikan tepat waktu pada
                                        {{ $transaksi->tanggal_dikembalikan->format('d M Y') }}
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="bi bi-exclamation-triangle"></i> Terlambat dikembalikan!
                                        Denda: Rp {{ number_format($transaksi->denda, 0, ',', '.') }}
                                    </div>
                                @endif
                            @endif

                            <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </div>
            </div>


    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.getElementById('btn-kembalikan')?.addEventListener('click', function() {
        Swal.fire({
            title: 'Konfirmasi Pengembalian',
            text: 'Apakah Anda yakin ingin mengembalikan buku ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            confirmButtonText: 'Ya, Kembalikan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-kembalikan').submit();
            }
        });
    });
    </script>
    @endpush
</x-app-layout>

<x-app-layout>
    <div class="container py-5">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>
                    <i class="bi bi-file-earmark-bar-graph"></i>
                    Laporan Transaksi
                </h1>
                <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            {{-- Filter Form --}}
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-funnel"></i> Filter Laporan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('transaksi.laporan') }}" method="GET">
                        <div class="row g-3">
                            {{-- Tanggal Dari --}}
                            <div class="col-md-3">
                                <label for="tanggal_dari" class="form-label">Dari Tanggal</label>
                                <input type="date" name="tanggal_dari" id="tanggal_dari" 
                                       class="form-control"
                                       value="{{ request('tanggal_dari') }}">
                            </div>

                            {{-- Tanggal Sampai --}}
                            <div class="col-md-3">
                                <label for="tanggal_sampai" class="form-label">Sampai Tanggal</label>
                                <input type="date" name="tanggal_sampai" id="tanggal_sampai" 
                                       class="form-control"
                                       value="{{ request('tanggal_sampai') }}">
                            </div>

                            {{-- Status --}}
                            <div class="col-md-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="Semua" {{ request('status') == 'Semua' ? 'selected' : '' }}>Semua</option>
                                    <option value="Dipinjam" {{ request('status') == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                    <option value="Dikembalikan" {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                </select>
                            </div>

                            {{-- Anggota --}}
                            <div class="col-md-3">
                                <label for="anggota_id" class="form-label">Anggota</label>
                                <select name="anggota_id" id="anggota_id" class="form-select">
                                    <option value="">Semua Anggota</option>
                                    @foreach($anggotas as $anggota)
                                        <option value="{{ $anggota->id }}" {{ request('anggota_id') == $anggota->id ? 'selected' : '' }}>
                                            {{ $anggota->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i> Filter
                            </button>
                            <a href="{{ route('transaksi.laporan') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> Reset
                            </a>
                            <a href="{{ route('transaksi.laporan.pdf', request()->query()) }}" 
                               class="btn btn-danger ms-auto" target="_blank">
                                <i class="bi bi-file-earmark-pdf"></i> Export PDF
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Summary Cards --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card border-primary">
                        <div class="card-body text-center">
                            <h6 class="text-muted">Total Transaksi</h6>
                            <h2 class="text-primary">{{ $totalTransaksi }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-danger">
                        <div class="card-body text-center">
                            <h6 class="text-muted">Total Denda</h6>
                            <h2 class="text-danger">Rp {{ number_format($totalDenda, 0, ',', '.') }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabel Laporan --}}
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Anggota</th>
                                    <th>Buku</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Tgl Kembali</th>
                                    <th>Tgl Dikembalikan</th>
                                    <th>Status</th>
                                    <th>Terlambat</th>
                                    <th>Denda</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksis as $transaksi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><code>{{ $transaksi->kode_transaksi }}</code></td>
                                    <td>{{ $transaksi->anggota->nama }}</td>
                                    <td>{{ $transaksi->buku->judul }}</td>
                                    <td>{{ $transaksi->tanggal_pinjam->format('d/m/Y') }}</td>
                                    <td>{{ $transaksi->tanggal_kembali->format('d/m/Y') }}</td>
                                    <td>
                                        @if($transaksi->tanggal_dikembalikan)
                                            {{ $transaksi->tanggal_dikembalikan->format('d/m/Y') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($transaksi->status == 'Dipinjam')
                                            <span class="badge bg-warning text-dark">Dipinjam</span>
                                        @else
                                            <span class="badge bg-success">Dikembalikan</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($transaksi->terlambat > 0)
                                            <span class="text-danger fw-bold">{{ ceil($transaksi->terlambat) }} hari</span>
                                        @else
                                            <span class="text-success">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($transaksi->denda_berjalan > 0)
                                            <span class="text-danger fw-bold">Rp {{ number_format($transaksi->denda_berjalan, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-4">
                                        Tidak ada data transaksi yang ditemukan
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            @if($transaksis->count() > 0)
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="9" class="text-end">Total Denda:</th>
                                    <th class="text-danger">Rp {{ number_format($totalDenda, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>

        </div>
</x-app-layout>

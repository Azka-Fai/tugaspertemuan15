@extends('layouts.app')
@section('title', 'Dashboard')
 
@section('content')
<div class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <h2 class="mb-0">Dashboard Perpustakaan</h2>
        
        {{-- Quick Actions --}}
        <div class="d-flex gap-2">
            <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Pinjam Buku
            </a>
            <a href="{{ route('buku.create') }}" class="btn btn-success">
                <i class="bi bi-book"></i> Tambah Buku
            </a>
            <a href="{{ route('anggota.create') }}" class="btn btn-info text-white">
                <i class="bi bi-person-plus"></i> Tambah Anggota
            </a>
        </div>
    </div>
 
    {{-- Statistics Cards --}}
    <div class="row g-3 mb-4">
        @foreach([
            ['Total Buku', $stats['total_buku'], 'bi-book', 'primary'],
            ['Anggota Aktif', $stats['total_anggota'], 'bi-people', 'success'],
            ['Sedang Dipinjam', $stats['sedang_dipinjam'], 'bi-journal-arrow-up', 'info'],
            ['Terlambat', $stats['terlambat'], 'bi-exclamation-triangle', 'danger'],
            ['Transaksi Hari Ini', $stats['transaksi_hari_ini'], 'bi-calendar-check', 'warning'],
            ['Buku Tersedia', $stats['buku_tersedia'], 'bi-bookshelf', 'secondary'],
            ['Total Transaksi', $stats['total_transaksi'], 'bi-receipt', 'dark'],
            ['Denda Bulan Ini', 'Rp ' . number_format($stats['denda_bulan_ini'], 0, ',', '.'), 'bi-cash', 'danger'],
        ] as [$label, $value, $icon, $color])
        <div class="col-xl-3 col-md-6">
            <div class="card border-{{ $color }} h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="bi {{ $icon }} fs-1 text-{{ $color }} me-3"></i>
                    <div>
                        <h6 class="text-muted mb-1">{{ $label }}</h6>
                        <h4 class="mb-0">{{ $value }}</h4>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
 
    {{-- Charts --}}
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">Transaksi 6 Bulan Terakhir</div>
                <div class="card-body">
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="chartTransaksi"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">Top 5 Buku Populer</div>
                <div class="card-body">
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="chartBuku"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
    {{-- Advanced Charts --}}
    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">Kategori Buku</div>
                <div class="card-body">
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="chartKategori"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">Status Transaksi</div>
                <div class="card-body">
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="chartStatus"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
    <div class="row">
        <div class="col-lg-6 mb-4">
            {{-- Recent Transactions --}}
            <div class="card h-100">
        <div class="card-header">Transaksi Terbaru</div>
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Kode</th><th>Anggota</th><th>Buku</th>
                        <th>Tgl Pinjam</th><th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentTransaksi as $trx)
                    <tr>
                        <td>{{ $trx->kode_transaksi }}</td>
                        <td>{{ $trx->anggota->nama }}</td>
                        <td>{{ $trx->buku->judul }}</td>
                        <td>{{ $trx->tanggal_pinjam->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge bg-{{ $trx->status === 'Dipinjam' ? 'warning' : 'success' }}">
                                {{ $trx->status }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <div class="col-lg-6 mb-4">
            {{-- Buku Terlambat Widget --}}
            <div class="card h-100 border-danger">
                <div class="card-header bg-danger text-white">Peringatan: Buku Terlambat</div>
                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Kode</th><th>Anggota</th><th>Buku</th>
                                <th>Terlambat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bukuTerlambat as $trx)
                            <tr>
                                <td>{{ $trx->kode_transaksi }}</td>
                                <td>{{ $trx->anggota->nama }}</td>
                                <td>{{ $trx->buku->judul }}</td>
                                <td><span class="badge bg-danger">{{ ceil($trx->terlambat) }} hari</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted">Tidak ada buku terlambat</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
 
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Line chart — Transaksi 6 bulan terakhir
new Chart(document.getElementById('chartTransaksi'), {
    type: 'line',
    data: {
        labels: @json($chartData->pluck('bulan')),
        datasets: [
            { label: 'Peminjaman', data: @json($chartData->pluck('pinjam')),
              borderColor: '#0d6efd', tension: 0.3 },
            { label: 'Pengembalian', data: @json($chartData->pluck('kembali')),
              borderColor: '#198754', tension: 0.3 }
        ]
    },
    options: { responsive: true, maintainAspectRatio: false }
});
 
// Pie chart — Buku Populer
new Chart(document.getElementById('chartBuku'), {
    type: 'pie',
    data: {
        labels: @json($bukuPopuler->pluck('judul')),
        datasets: [{
            data: @json($bukuPopuler->pluck('transaksis_count')),
            backgroundColor: ['#0d6efd','#198754','#ffc107','#dc3545','#6f42c1']
        }]
    },
    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
});
 
// Pie chart — Kategori Buku
new Chart(document.getElementById('chartKategori'), {
    type: 'pie',
    data: {
        labels: {!! json_encode(array_keys($kategoriChart->toArray())) !!},
        datasets: [{
            data: {!! json_encode(array_values($kategoriChart->toArray())) !!},
            backgroundColor: ['#0d6efd','#198754','#ffc107','#dc3545','#6f42c1','#0dcaf0']
        }]
    },
    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
});

// Doughnut chart — Status Transaksi
new Chart(document.getElementById('chartStatus'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode(array_keys($statusChart->toArray())) !!},
        datasets: [{
            data: {!! json_encode(array_values($statusChart->toArray())) !!},
            backgroundColor: ['#ffc107', '#198754']
        }]
    },
    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
});
</script>
@endpush
@endsection
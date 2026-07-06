<?php
 
namespace App\Http\Controllers;
 
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Transaksi;
use Carbon\Carbon;
 
class DashboardController extends Controller
{
    public function index()
    {
        // Statistik utama
        $stats = [
            'total_buku'        => Buku::count(),
            'total_anggota'     => Anggota::where('status', 'Aktif')->count(),
            'total_transaksi'   => Transaksi::count(),
            'sedang_dipinjam'   => Transaksi::where('status', 'Dipinjam')->count(),
            'terlambat'         => Transaksi::where('status', 'Dipinjam')
                                            ->where('tanggal_kembali', '<', now())->count(),
            'denda_bulan_ini'   => Transaksi::whereMonth('tanggal_dikembalikan', now()->month)
                                            ->sum('denda'),
            'transaksi_hari_ini'=> Transaksi::whereDate('tanggal_pinjam', today())->count(),
            'buku_tersedia'     => Buku::where('stok', '>', 0)->count(),
        ];
 
        // Data chart: transaksi 6 bulan terakhir
        $chartData = collect(range(5, 0))->map(function ($i) {
            $date = now()->subMonths($i);
            return [
                'bulan' => $date->translatedFormat('M Y'),
                'pinjam' => Transaksi::whereMonth('tanggal_pinjam', $date->month)
                                     ->whereYear('tanggal_pinjam', $date->year)->count(),
                'kembali' => Transaksi::whereMonth('tanggal_dikembalikan', $date->month)
                                      ->whereYear('tanggal_dikembalikan', $date->year)->count(),
            ];
        });
 
        // Top 5 buku populer
        $bukuPopuler = Buku::withCount('transaksis')
                           ->orderByDesc('transaksis_count')
                           ->take(5)->get();
 
        // Top 5 anggota aktif
        $anggotaAktif = Anggota::withCount('transaksis')
                               ->orderByDesc('transaksis_count')
                               ->take(5)->get();
 
        // Transaksi terbaru
        $recentTransaksi = Transaksi::with(['anggota', 'buku'])
                                    ->latest()->take(5)->get();
 
        // Buku Terlambat (Pilihan 1)
        $bukuTerlambat = Transaksi::where('status', 'Dipinjam')
                                  ->where('tanggal_kembali', '<', now())
                                  ->with(['anggota', 'buku'])
                                  ->get();
 
        // Data chart: Kategori Buku (Pilihan 4)
        $kategoriChart = Buku::select('kategori', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                             ->groupBy('kategori')
                             ->pluck('total', 'kategori');
                             
        // Data chart: Status Transaksi (Pilihan 4)
        $statusChart = Transaksi::select('status', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                                ->groupBy('status')
                                ->pluck('total', 'status');
 
        return view('dashboard', compact(
            'stats', 'chartData', 'bukuPopuler',
            'anggotaAktif', 'recentTransaksi',
            'bukuTerlambat', 'kategoriChart', 'statusChart'
        ));
    }
}

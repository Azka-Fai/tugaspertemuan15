<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi Perpustakaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px double #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #1a56db;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
            font-size: 12px;
        }
        .summary {
            margin-bottom: 15px;
        }
        .summary table {
            width: 100%;
        }
        .summary td {
            padding: 8px 12px;
            background: #f3f4f6;
            border: 1px solid #ddd;
        }
        .summary .label {
            font-weight: bold;
            color: #555;
        }
        .summary .value {
            font-size: 14px;
            font-weight: bold;
            text-align: right;
        }
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.data th {
            background: #1a56db;
            color: white;
            padding: 8px 6px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
        }
        table.data td {
            padding: 6px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }
        table.data tr:nth-child(even) {
            background: #f9fafb;
        }
        .status-dipinjam {
            color: #d97706;
            font-weight: bold;
        }
        .status-dikembalikan {
            color: #059669;
            font-weight: bold;
        }
        .text-danger {
            color: #dc2626;
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        tfoot td {
            font-weight: bold;
            background: #e5e7eb !important;
            padding: 8px 6px;
            border-top: 2px solid #333;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN TRANSAKSI PERPUSTAKAAN</h1>
        <p>Dicetak pada: {{ date('d M Y, H:i') }} WIB</p>
    </div>

    <div class="summary">
        <table>
            <tr>
                <td class="label">Total Transaksi</td>
                <td class="value">{{ $totalTransaksi }}</td>
                <td class="label">Total Denda</td>
                <td class="value text-danger">Rp {{ number_format($totalDenda, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <table class="data">
        <thead>
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
                <td>{{ $transaksi->kode_transaksi }}</td>
                <td>{{ $transaksi->anggota->nama }}</td>
                <td>{{ $transaksi->buku->judul }}</td>
                <td>{{ $transaksi->tanggal_pinjam->format('d/m/Y') }}</td>
                <td>{{ $transaksi->tanggal_kembali->format('d/m/Y') }}</td>
                <td>
                    @if($transaksi->tanggal_dikembalikan)
                        {{ $transaksi->tanggal_dikembalikan->format('d/m/Y') }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($transaksi->status == 'Dipinjam')
                        <span class="status-dipinjam">Dipinjam</span>
                    @else
                        <span class="status-dikembalikan">Dikembalikan</span>
                    @endif
                </td>
                <td>
                    @if($transaksi->terlambat > 0)
                        <span class="text-danger">{{ ceil($transaksi->terlambat) }} hari</span>
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($transaksi->denda > 0)
                        <span class="text-danger">Rp {{ number_format($transaksi->denda, 0, ',', '.') }}</span>
                    @else
                        -
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" style="text-align: center; padding: 20px;">
                    Tidak ada data transaksi
                </td>
            </tr>
            @endforelse
        </tbody>
        @if($transaksis->count() > 0)
        <tfoot>
            <tr>
                <td colspan="9" style="text-align: right;">Total Denda:</td>
                <td class="text-danger">Rp {{ number_format($totalDenda, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh Sistem Perpustakaan</p>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Anggota Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Daftar Anggota Perpustakaan</h2>
        
        <table class="table table-bordered table-striped table-hover shadow-sm">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>No</th>
                    <th>Kode Anggota</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($anggota_list as $index => $anggota)
                <tr class="text-center">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $anggota['kode'] }}</td>
                    <td class="text-start">{{ $anggota['nama'] }}</td>
                    <td>{{ $anggota['email'] }}</td>
                    <td>
                        @if($anggota['status'] == 'Aktif')
                            <span class="badge bg-success">{{ $anggota['status'] }}</span>
                        @else
                            <span class="badge bg-danger">{{ $anggota['status'] }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ url('/anggota/'.$anggota['id']) }}" class="btn btn-primary btn-sm">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
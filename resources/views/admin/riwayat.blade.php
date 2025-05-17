<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Absensi</title>
</head>
<body>
    <h2>Riwayat Absensi</h2>

    <table border="1">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Mata Kuliah</th>
                <th>Keterangan</th>
                <th>Jam Hadir</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($riwayat as $item)
            <tr>
                <td>{{ $item->tanggal }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->jadwal->mata_kuliah ?? '-' }}</td>
                <td>{{ $item->jadwal->keterangan ?? '-' }}</td> 
                <td>{{ $item->waktu_masuk ?? '-' }}</td>
                <td>{{ ucfirst($item->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>


    <br>
    <a href="{{ route('admin.dashboard') }}">⬅ Kembali</a>
</body>
</html>

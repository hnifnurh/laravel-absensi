<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Jadwal Absensi</title>
</head>
<body>
    <h2>Tambah Jadwal Absensi</h2>
    <form method="POST" action="{{ route('admin.jadwal.store') }}">
        @csrf
        <label>Tanggal:</label><br>
        <input type="date" name="tanggal" required><br><br>

        <label>Jam Mulai:</label><br>
        <input type="time" name="jam_mulai" required><br><br>

        <label>Jam Selesai:</label><br>
        <input type="time" name="jam_selesai" required><br><br>

        <label>Mata Kuliah:</label><br>
        <input type="text" name="mata_kuliah" required><br><br>

        <label>Keterangan:</label><br>
        <input type="text" name="keterangan"><br><br>

        <button type="submit">Simpan Jadwal</button>
    </form>
    <br>
    <a href="{{ route('admin.dashboard') }}">Kembali</a>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Selamat Datang, {{ Auth::user()->name }} (Admin)</h2>

    <ul>
        <li><a href="{{ route('admin.users') }}">👤 List User</a></li>
        <li><a href="{{ route('admin.jadwal.form') }}">📅 Buat Jadwal Absensi</a></li>
        <li><a href="{{ route('admin.riwayat') }}">📊 Riwayat Absensi</a></li>
    </ul>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>

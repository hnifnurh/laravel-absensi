<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah User</title>
</head>
<body>
    <h2>Tambah User</h2>

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        <label>Nama:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Role:</label><br>
        <select name="role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select><br><br>

        <button type="submit">Simpan User</button>
    </form>

    <br>
    <a href="{{ route('admin.users') }}">⬅ Kembali</a>
</body>
</html>

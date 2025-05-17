<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List User</title>
</head>
<body>
    <h2>List User</h2>

    <a href="{{ route('admin.users.create') }}">➕ Tambah User</a>

    <table border="1">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>
    <a href="{{ route('admin.dashboard') }}">⬅ Kembali</a>
</body>
</html>

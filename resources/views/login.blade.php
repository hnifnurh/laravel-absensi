<!DOCTYPE html>
<html>
<head>
    <title>Login Absensi</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}">
</head>
<body>
    <h2>Selamat datang Di Page Absensi, Silahkan Login Dulu</h2>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
            <label>Email:</label><br />
            <input type="email" name="email" value="{{ old('email') }}" required><br /><br />

            <label>Password:</label><br />
            <input type="password" name="password" required><br /><br />

        <button type="submit">Login</button>
    </form>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Halaman Absensi</title>
</head>
<body>
    <h2>Selamat datang, {{ Auth::user()->name }}</h2>
    @if($jadwalHariIni)
        <h3>Presensi Hari Ini: {{ $jadwalHariIni->mata_kuliah }} ({{ \Carbon\Carbon::parse($jadwalHariIni->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwalHariIni->jam_selesai)->format('H:i') }})</h3>
        
        @php
            $userAbsensi = \App\Models\Absensi::where('user_id', Auth::id())
                ->where('jadwal_id', $jadwalHariIni->id)
                ->where('tanggal', \Carbon\Carbon::now()->format('Y-m-d'))
                ->first();
        @endphp
        
        @if(!$userAbsensi)
            <form method="POST" action="{{ route('absensi.submit-status') }}">
                @csrf
                <select name="status" required>
                    <option value="hadir">Hadir</option>
                    <option value="sakit">Sakit</option>
                    <option value="izin">Izin</option>
                </select>
                <button type="submit">Kirim Presensi</button>
            </form>
        @else
            <p>Anda sudah melakukan presensi dengan status: <strong>{{ ucfirst($userAbsensi->status) }}</strong></p>
        @endif
    @else
        <p><i>Belum ada jadwal absensi hari ini.</i></p>
    @endif
    
    <h3>Daftar Hadir Hari Ini</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Jam Hadir</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($hadir as $item)
                <tr>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->waktu_masuk ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="2">Belum ada yang hadir hari ini.</td></tr>
            @endforelse
        </tbody>
    </table>
    
    <h3>Telat / Alpha / Sakit / Izin</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tidak_hadir as $item)
                <tr>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ ucfirst($item->status) }}</td>
                </tr>
            @empty
                <tr><td colspan="2">Semua sudah hadir hari ini.</td></tr>
            @endforelse
        </tbody>
    </table>
    <br>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Log Out</button>
    </form>
</body>
</html>
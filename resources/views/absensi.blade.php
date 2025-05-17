<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Halaman Absensi</title>
</head>
<body>
    @php
        $hadirHariIni = $userAbsensiHariIni->filter(fn($absen) => $absen->status === 'hadir');
        $tidakHadirHariIni = $userAbsensiHariIni->filter(fn($absen) => $absen->status !== 'hadir');
    @endphp

    <h2>Selamat datang, {{ Auth::user()->name }}</h2>

    {{-- Form Presensi untuk jadwal yang belum diabsen hari ini --}}
    @foreach ($jadwalHariIni as $jadwal)
        @php
            $userAbsen = $userAbsensiHariIni->get($jadwal->id);
        @endphp

        @if (!$userAbsen)
            <div style="margin-bottom: 20px;">
                <h3>{{ $jadwal->mata_kuliah }} ({{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }})</h3>
                <form method="POST" action="{{ route('absensi.submit-status') }}">
                    @csrf
                    <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">
                    <label>Status Kehadiran:</label>
                    <select name="status" required>
                        <option value="hadir">Hadir</option>
                        <option value="sakit">Sakit</option>
                        <option value="izin">Izin</option>
                    </select>
                    <button type="submit">Kirim</button>
                </form>
            </div>
        @endif
    @endforeach

    {{-- Tabel Hadir Hari Ini --}}
    @if ($hadirHariIni->count())
        <h3>List Hadir Hari Ini</h3>
        <table border="1" cellpadding="6" cellspacing="0" style="margin-bottom: 20px;">
            <thead>
                <tr>
                    <th>Mata Kuliah</th>
                    <th>Jam</th>
                    <th>Keterangan</th>
                    <th>Waktu Masuk</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hadirHariIni as $absen)
                    <tr>
                        <td>{{ $absen->jadwal->mata_kuliah }}</td>
                        <td>{{ $absen->jadwal->jam_mulai }} - {{ $absen->jadwal->jam_selesai }}</td>
                        <td>{{ $absen->jadwal->keterangan ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($absen->waktu_masuk)->format('H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- Tabel Tidak Hadir Hari Ini --}}
    @if ($tidakHadirHariIni->count())
        <h3>Telat / Alpha / Sakit / Izin Hari Ini</h3>
        <table border="1" cellpadding="6" cellspacing="0" style="margin-bottom: 20px;">
            <thead>
                <tr>
                    <th>Mata Kuliah</th>
                    <th>Jam</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th>Waktu Masuk</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tidakHadirHariIni as $absen)
                    <tr>
                        <td>{{ $absen->jadwal->mata_kuliah }}</td>
                        <td>{{ $absen->jadwal->jam_mulai }} - {{ $absen->jadwal->jam_selesai }}</td>
                        <td>{{ $absen->jadwal->keterangan ?? '-' }}</td>
                        <td>{{ ucfirst($absen->status) }}</td>
                        <td>{{ $absen->waktu_masuk ? \Carbon\Carbon::parse($absen->waktu_masuk)->format('H:i:s') : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- Riwayat Ketidakhadiran Lama --}}
    <h3>Riwayat Ketidakhadiran Sebelumnya</h3>
    @if ($userAbsensiTidakHadirSelamanya && $userAbsensiTidakHadirSelamanya->count())
        <table border="1" cellpadding="6" cellspacing="0" style="margin-bottom: 20px;">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Mata Kuliah</th>
                    <th>Jam</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th>Waktu Masuk</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($userAbsensiTidakHadirSelamanya as $absen)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($absen->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $absen->jadwal->mata_kuliah }}</td>
                        <td>{{ $absen->jadwal->jam_mulai }} - {{ $absen->jadwal->jam_selesai }}</td>
                        <td>{{ $absen->jadwal->keterangan ?? '-' }}</td>
                        <td>{{ ucfirst($absen->status) }}</td>
                        <td>{{ $absen->waktu_masuk ? \Carbon\Carbon::parse($absen->waktu_masuk)->format('H:i:s') : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak ada riwayat ketidakhadiran.</p>
    @endif

    <br>
    <form action="{{ route('logout') }}" method="POST" style="max-width: 500px;">
        @csrf
        <button type="submit">Log Out</button>
    </form>
</body>
</html>

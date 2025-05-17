<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil jadwal hari ini
        $jadwalHariIni = Jadwal::whereDate('tanggal', now()->toDateString())->first();

        if (!$jadwalHariIni) {
            // Kalau belum ada jadwal, set data kosong untuk hadir dan tidak hadir
            $hadir = collect();
            $tidak_hadir = collect();
        } else {
            // Absensi yang hadir hari ini (status hadir)
            $hadir = Absensi::with('user')
                ->where('jadwal_id', $jadwalHariIni->id)
                ->where('tanggal', now()->toDateString())
                ->where('status', 'hadir')
                ->get();

            // Absensi yang tidak hadir (sakit, izin, alpha, telat, dll)
            $tidak_hadir = Absensi::with('user')
                ->where('jadwal_id', $jadwalHariIni->id)
                ->where('tanggal', now()->toDateString())
                ->where('status', '<>', 'hadir')
                ->get();
        }

        return view('absensi', compact('jadwalHariIni', 'hadir', 'tidak_hadir'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'status' => 'required|in:hadir,sakit,izin',
        ]);

        $user = Auth::user();

        // Ambil jadwal hari ini, wajib ada jadwal agar bisa absen
        $jadwalHariIni = Jadwal::whereDate('tanggal', now()->toDateString())->first();

        if (!$jadwalHariIni) {
            return back()->withErrors(['msg' => 'Tidak ada jadwal absensi hari ini.']);
        }

        // Cek apakah user sudah absen hari ini untuk jadwal yang sama
        $existingAbsensi = Absensi::where('user_id', $user->id)
            ->where('jadwal_id', $jadwalHariIni->id)
            ->where('tanggal', now()->toDateString())
            ->first();

        if ($existingAbsensi) {
            return back()->withErrors(['msg' => 'Anda sudah melakukan presensi hari ini.']);
        }

        // Simpan data absensi
        Absensi::create([
            'user_id' => $user->id,
            'jadwal_id' => $jadwalHariIni->id,
            'tanggal' => now()->toDateString(),
            'status' => $request->status,
            'waktu_masuk' => now(),
        ]);

        return redirect()->route('absensi.index')->with('success', 'Presensi berhasil dikirim.');
    }
}

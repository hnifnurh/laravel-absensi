<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $now = Carbon::now();

        // Ambil jadwal hari ini yang sudah lewat jam_selesai
        $jadwalLewat = Jadwal::whereDate('tanggal', today())
            ->where('jam_selesai', '<', $now->format('H:i:s'))
            ->get();

        foreach ($jadwalLewat as $jadwal) {
            $absensi = Absensi::where('user_id', $user->id)
                ->where('jadwal_id', $jadwal->id)
                ->where('tanggal', today())
                ->first();

            if (!$absensi) {
                // Buat absensi alfa jika belum ada
                Absensi::create([
                    'user_id' => $user->id,
                    'jadwal_id' => $jadwal->id,
                    'tanggal' => today(),
                    'status' => 'alfa',
                    'waktu_masuk' => null,
                ]);
            }
        }

        // Jadwal hari ini (baik yang sudah lewat maupun belum)
        $jadwalHariIni = Jadwal::whereDate('tanggal', today())->get();

        // Ambil absensi user hari ini
        $userAbsensiHariIni = Absensi::where('user_id', $user->id)
            ->whereIn('jadwal_id', $jadwalHariIni->pluck('id'))
            ->where('tanggal', today())
            ->get()
            ->keyBy('jadwal_id');

        // Ambil semua absensi user dengan status selain 'hadir', tanpa batas tanggal, order by terbaru
        $userAbsensiTidakHadirSelamanya = Absensi::with('jadwal')
            ->where('user_id', $user->id)
            ->where('status', '!=', 'hadir')
            ->orderByDesc('tanggal')
            ->orderByDesc('waktu_masuk')
            ->get();

        return view('absensi', compact(
            'user',
            'jadwalHariIni',
            'userAbsensiHariIni',
            'userAbsensiTidakHadirSelamanya'
        ));
    }



    public function submit(Request $request)
    {
        $request->validate([
            'status' => 'required|in:hadir,sakit,izin',
            'jadwal_id' => 'required|exists:jadwals,id' // pastikan jadwal_id dikirim dari form
        ]);

        $user = Auth::user();

        // Ambil jadwal sesuai ID yang dikirim, dan pastikan tanggalnya hari ini
        $jadwalHariIni = Jadwal::where('id', $request->jadwal_id)
            ->whereDate('tanggal', now()->toDateString())
            ->first();

        if (!$jadwalHariIni) {
            return back()->withErrors(['msg' => 'Jadwal absensi tidak ditemukan atau bukan untuk hari ini.']);
        }

        // Cek apakah user sudah absen untuk jadwal tersebut hari ini
        $existingAbsensi = Absensi::where('user_id', $user->id)
            ->where('jadwal_id', $jadwalHariIni->id)
            ->where('tanggal', now()->toDateString())
            ->first();

        if ($existingAbsensi) {
            return back()->withErrors(['msg' => 'Anda sudah melakukan presensi untuk jadwal ini hari ini.']);
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

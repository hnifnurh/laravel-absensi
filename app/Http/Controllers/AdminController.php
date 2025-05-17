<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\Absensi;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // List semua user
    public function listUsers()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    // Tampilkan form tambah user baru
    public function createUser()
    {
        return view('admin.form');  // Sesuai file form.blade.php
    }

    // Proses simpan user baru
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:user,admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan.');
    }

    // Form tambah jadwal absensi
    public function formJadwal()
    {
        return view('admin.jadwal'); // Sesuai file jadwal.blade.php
    }

    // Simpan jadwal
    public function storeJadwal(Request $request)
    {
        $request->validate([
            'mata_kuliah' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Jadwal::create([
            'mata_kuliah' => $request->mata_kuliah,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.jadwal.form')->with('success', 'Jadwal berhasil dibuat.');
    }

    // Riwayat absensi
    public function riwayatAbsensi()
    {
        $riwayat = Absensi::with(['user', 'jadwal'])
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('admin.riwayat', compact('riwayat'));
    }
}

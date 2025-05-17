<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Hash;

public function dashboard()
{
    return view('admin.dashboard');
}

public function listUsers()
{
    $users = User::all();
    return view('admin.users', compact('users'));
}

public function createUser()
{
    return view('admin.user-create');
}

public function storeUser(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'role' => 'required|in:user,admin',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);

    return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan.');
}

public function jadwalForm()
{
    return view('admin.jadwal');
}

public function buatJadwal(Request $request)
{
    $request->validate([
        'tanggal' => 'required|date',
        'jam_mulai' => 'required',
        'jam_selesai' => 'required',
        'keterangan' => 'nullable',
    ]);

    JadwalAbsensi::create($request->all());

    return redirect()->route('admin.jadwal.form')->with('success', 'Jadwal absensi berhasil dibuat.');
}

public function riwayat()
{
    $riwayat = Absensi::with('user')->orderBy('tanggal', 'desc')->get();
    return view('admin.riwayat', compact('riwayat'));
}

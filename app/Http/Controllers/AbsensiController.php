<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Absensi;
use App\Models\Jadwal;

public function listUsers()
{
    $users = User::all();
    return view('admin.users', compact('users'));
}

public function jadwalForm()
{
    return view('admin.jadwal');
}

public function buatJadwal(Request $request)
{
    JadwalAbsensi::create($request->all());
    return redirect()->route('admin.jadwal.form')->with('success', 'Jadwal disimpan.');
}

public function riwayat()
{
    $riwayat = Absensi::with('user')->orderBy('tanggal', 'desc')->get();
    return view('admin.riwayat', compact('riwayat'));
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Jadwal;
use App\Models\Absensi;
use App\Models\User;
use Carbon\Carbon;

class TandaiAlpha extends Command
{
    protected $signature = 'presensi:cek-alpha';
    protected $description = 'Menandai mahasiswa yang tidak presensi sebagai alpha';

    public function handle()
    {
        $now = Carbon::now();

        $jadwals = Jadwal::whereDate('tanggal', today())
            ->where('jam_selesai', '<=', $now->format('H:i:s'))
            ->get();

        foreach ($jadwals as $jadwal) {
            $belumPresensi = User::whereDoesntHave('absensi', function ($query) use ($jadwal) {
                $query->where('jadwal_id', $jadwal->id);
            })->get();

            foreach ($belumPresensi as $user) {
                Absensi::create([
                    'user_id' => $user->id,
                    'jadwal_id' => $jadwal->id,
                    'status' => 'alpha',
                    'tanggal' => today(),
                ]);

                $this->info("Menandai {$user->name} sebagai alpha pada jadwal {$jadwal->mata_kuliah}");
            }
        }
    }
}


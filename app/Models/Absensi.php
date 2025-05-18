<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = [
        'user_id',
        'jadwal_id',
        'tanggal',
        'waktu_masuk',
        'status',
    ];

     // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }

    // Relasi ke Jadwal
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal'; // sesuai nama tabel migrasi

    protected $fillable = [
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'keterangan',
    ];
}
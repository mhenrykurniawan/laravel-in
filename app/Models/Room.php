<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    // use HasFactory;

    protected $fillable = [
        'kode_ruang',
        'nama_ruang',
        'gedung',
        'lantai',
        'kapasitas',
        'fasilitas',
        'status',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}

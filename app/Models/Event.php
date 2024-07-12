<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    public function pendonors()
    {
        return $this->belongsToMany(Pendonor::class, 'event_pendonor');
    }

    public function pemeriksaans()
    {
        return $this->hasMany(Pemeriksaan::class);
    }

}

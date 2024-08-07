<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pendonor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'alamat',
        'tgl_lahir',
        'jns_kelamin',
        'no_telepon',
        'golongan_darah',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pemeriksaans()
    {
        return $this->hasMany(Pemeriksaan::class);
    }

    public function riwayatPemeriksaans()
    {
        return $this->hasMany(RiwayatPemeriksaan::class);
    }
    public function hasils()
    {
        return $this->hasMany(Hasil::class, 'pendonor_id');
    }
    public function pemeriksaan()
    {
        return $this->hasMany(Pemeriksaan::class, 'pendonor_id');
    }
}

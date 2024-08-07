<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemeriksaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'pendonor_id',
        'kriteria_id',
        'nilai',
    ];


    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function pendonor()
    {
        return $this->belongsTo(Pendonor::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hasil extends Model
{
    use HasFactory;

    protected $fillable = ['pendonor_id', 'hasil','status','event_name', 'kriteria_nilai'];

    public function pendonor()
    {
        return $this->belongsTo(Pendonor::class, 'pendonor_id');
    }
}

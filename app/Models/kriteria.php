<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kriteria extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'bobot', 'jenis'];

    public function pemeriksaans()
    {
        return $this->hasMany(Pemeriksaan::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pendonor extends Model
{
    use HasFactory;

    protected $fillable = ['nama_pendonor', 'umur', 'tekanan_darah', 'berat_badan', 'hemoglobin', 'konsumsi_obat', 'tidur'];

}

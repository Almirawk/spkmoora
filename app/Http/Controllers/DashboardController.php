<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendonor;
use App\Models\Kriteria;
use App\Models\Pemeriksaan;
use App\Models\Hasil;
class DashboardController extends Controller
{
    public function index()
    {
        $jumlah_pendonor = Pendonor::count();
        $jumlah_kriteria = Kriteria::count();
        $jumlah_pemeriksaan = Pemeriksaan::distinct('pendonor_id')->count('pendonor_id');
        $jumlah_hasil = Hasil::count();

        return view('dashboard', compact('jumlah_pendonor', 'jumlah_kriteria', 'jumlah_pemeriksaan', 'jumlah_hasil'));
    }
}

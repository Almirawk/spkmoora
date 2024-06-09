<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendonor;
use App\Models\RiwayatPemeriksaan;
use App\Models\Kriteria;
use App\Models\Pemeriksaan;
use Illuminate\Support\Facades\Auth;

class RiwayatPemeriksaanController extends Controller
{
    public function index()
{
    if (Auth::check()) {
        $user = auth()->user();
        
        if ($user->role != 'admin') {
            $pendonorId = $user->pendonor->id;

            // Mengambil data pemeriksaan berdasarkan pendonor yang login dan memuat relasi kriteria dan pendonor
            $riwayatPemeriksaan = Pemeriksaan::where('pendonor_id', $pendonorId)->with('kriteria')->get();

            // Mengambil semua kriteria
            $kriterias = Kriteria::all();
            
            return view('welcome', compact('riwayatPemeriksaan', 'kriterias', 'user'));
        }
    }
    
    // Jika belum login atau merupakan admin, kembali ke tampilan standar halaman awal
    return view('welcome');
}


}

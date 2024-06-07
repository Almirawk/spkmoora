<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendonor;
use App\Models\RiwayatPemeriksaan;
use App\Models\Kriteria;
use App\Models\Pemeriksaan;

class RiwayatPemeriksaanController extends Controller
{
    public function index()
{
    $user = auth()->user();
    $pendonorId = $user->pendonor->id;

    // Mengambil data pemeriksaan berdasarkan pendonor yang login dan memuat relasi kriteria dan pendonor
    $riwayatPemeriksaan = Pemeriksaan::where('pendonor_id', $pendonorId)->with('kriteria')->get();

    // Mengambil semua kriteria
    $kriterias = Kriteria::all();

    return view('welcome', compact('riwayatPemeriksaan', 'kriterias', 'user'));
}

}

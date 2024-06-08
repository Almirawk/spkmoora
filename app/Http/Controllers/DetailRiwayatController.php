<?php

namespace App\Http\Controllers;
use App\Models\Pemeriksaan;

use Illuminate\Http\Request;

class DetailRiwayatController extends Controller
{
    public function show($id)
    {
        $pemeriksaan = Pemeriksaan::with(['pendonor', 'kriteria'])->findOrFail($id);
        return view('riwayat.detail', compact('pemeriksaan'));
    }
}

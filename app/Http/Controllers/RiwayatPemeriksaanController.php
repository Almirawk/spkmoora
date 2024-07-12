<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Hasil;
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
                $pendonor = $user->pendonor;
                $events = Event::where('tanggal_selesai', '>=', now())->get();
                $hasilPerhitungan = Hasil::where('pendonor_id', $pendonor->id)
                    ->orderByDesc('created_at')
                    ->get(); // Fetch all results for the logged-in donor
                
                return view('welcome', compact('hasilPerhitungan', 'user','events'));
            }
        }
        
        // Jika belum login atau merupakan admin, kembali ke tampilan standar halaman awal
        return view('welcome');
    }


}

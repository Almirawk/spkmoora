<?php

namespace App\Http\Controllers;

use App\Models\Pemeriksaan;
use App\Models\Kriteria;
use App\Models\pendonor;
use Illuminate\Http\Request;

class PemeriksaanController extends Controller
{
    public function index()
    {
        $kriterias = Kriteria::all();
        $pendonors = Pendonor::all();
        return view('pemeriksaan.index', compact('kriterias', 'pendonors'));

    }

    public function setNilai(Request $request)
    {
        $pendonorId = $request->input('pendonor_id');
        $nilai = $request->input('nilai');

        foreach ($nilai as $kriteriaId => $value) {
            Pemeriksaan::updateOrCreate(
                ['pendonor_id' => $pendonorId, 
                'kriteria_id' => $kriteriaId],
                ['nilai' => $value]
            );
        }

        return redirect()->route('pemeriksaan')->with('message', 'Nilai Berhasil Disimpan!');
    }

    public function updateNilai(Request $request)
    {
        $pendonorId = $request->input('pendonor_id');
        $nilaiData = $request->input('nilai');

        foreach ($nilaiData as $kriteriaId => $nilai) {
            $pemeriksaan = Pemeriksaan::where('pendonor_id', $pendonorId)
                                      ->where('kriteria_id', $kriteriaId)
                                      ->first();
            
            if ($pemeriksaan) {
                $pemeriksaan->nilai = $nilai;
                $pemeriksaan->save();
            } else {
                Pemeriksaan::create([
                    'pendonor_id' => $pendonorId,
                    'kriteria_id' => $kriteriaId,
                    'nilai' => $nilai,
                ]);
            }
        }

        return redirect()->route('pemeriksaan')->with('message', 'Nilai berhasil diupdate.');
    }

    public function destroy($id)
{
    $pendonor = Pendonor::find($id);

    if ($pendonor) {

        $pendonor->pemeriksaans()->delete();
        return redirect()->route('pemeriksaan')->with('message', 'Data pemeriksaan berhasil dihapus.');
    }

    return redirect()->route('pemeriksaan')->with('error', 'Pendonor tidak ditemukan.');
}

}

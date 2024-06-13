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

    // public function destroyValues($pendonor_id)
    // {
    //     // Find the pendonor
    //     $pendonor = Pendonor::findOrFail($pendonor_id);

    //     // Delete pemeriksaan values associated with this pendonor
    //     $pendonor->pemeriksaans()->delete();

    //     // Redirect back with a success message
    //     return redirect()->back()->with('message', 'Pemeriksaan values deleted successfully.');
    // }




    // public function add()
    // {
    //     return view('pemeriksaan.insert');
    // }

    // public function insert(Request $request)
    // {
    //     $data = $request->validate([
    //         'nama_pendonor' => 'required', 
    //         'umur' => 'nullable|integer',
    //         'tekanan_darah' => 'required|string',
    //         'berat_badan' => 'required|integer',
    //         'hemoglobin' => 'required|numeric',
    //         'konsumsi_obat' => 'required|integer',
    //         'tidur' => 'required|integer',
    //         'riwayat_penyakit' => 'required|boolean',
    //     ]);

    //     Pemeriksaan::create($data);
    //     return redirect()->route('pemeriksaan')->with('message', 'Data Berhasil Ditambahkan!');
    // }

    // public function edit($id)
    // {
    //     $pemeriksaan = Pemeriksaan::find($id);

    //     return view('pemeriksaan.edit', compact('pemeriksaan'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'nama_pendonor' => 'required', 
    //         'umur' => 'required',
    //         'tekanan_darah' => 'required',
    //         'berat_badan' => 'required',
    //         'hemoglobin' => 'required',
    //         'konsumsi_obat' => 'required',
    //         'tidur' => 'required',
    //         'riwayat_prnyakit' => 'required'
    //     ]);

    //     $pemeriksaan = Pemeriksaan::find($id);
    //     $pemeriksaan->update([
    //         'nama_pendonor' => $request->nama_pendonor,
    //         'umur' => $request->umur,
    //         'tekanan_darah' => $request->tekanan_darah,
    //         'berat_badan' => $request->berat_badan,
    //         'hemoglobin' => $request->hemoglobin,
    //         'konsumsi_obat' => $request->konsumsi_obat,
    //         'tidur' => $request->tidur,
    //         'riwayat_prnyakit' => $request->riwayat_penyakit
    //     ]);

    //     return redirect()->route('pemeriksaan')->with('message', 'Data Berhasil Diupdate!');
    // }

    // public function delete($id)
    // {
    //     $pemeriksaan = Pemeriksaan::find($id);
    //     $pemeriksaan->delete();

    //     return redirect()->route('pemeriksaan')->with('message', 'Data Telah Berhasil Dihapus');
    // }
}

<?php

namespace App\Http\Controllers;

use App\Models\Pendonor;
use Illuminate\Http\Request;


class PendonorController extends Controller
{
    public function index()
    {
        return view('pendonor.index', [
            'pendonor' => Pendonor::latest()->get()
        ]);
    }

    public function add()
    {
        return view('pendonor.insert');
    }

    public function insert(Request $request)
    {
        $request->validate([
            'nama_pendonor' => 'required', 
            'umur' => 'required',
            'tekanan_darah' => 'required',
            'berat_badan' => 'required',
            'hemoglobin' => 'required',
            'konsumsi_obat' => 'required',
            'tidur' => 'required',
        ]);

        Pendonor::create([
            'nama_pendonor' => $request->nama_pendonor,
            'umur' => $request->umur,
            'tekanan_darah' => $request->tekanan_darah,
            'berat_badan' => $request->berat_badan,
            'hemoglobin' => $request->hemoglobin,
            'konsumsi_obat' => $request->konsumsi_obat,
            'tidur' => $request->tidur,
        ]);

        return redirect()->route('pendonor')->with('message', 'Data Berhasil Ditambahkan!');
    }

    public function edit($id)
    {
        $pendonor = Pendonor::find($id);

        return view('pendonor.edit', compact('pendonor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pendonor' => 'required', 
            'umur' => 'required',
            'tekanan_darah' => 'required',
            'berat_badan' => 'required',
            'hemoglobin' => 'required',
            'konsumsi_obat' => 'required',
            'tidur' => 'required',
        ]);

        $pendonor = Pendonor::find($id);
        $pendonor->update([
            'nama_pendonor' => $request->nama_pendonor,
            'umur' => $request->umur,
            'tekanan_darah' => $request->tekanan_darah,
            'berat_badan' => $request->berat_badan,
            'hemoglobin' => $request->hemoglobin,
            'konsumsi_obat' => $request->konsumsi_obat,
            'tidur' => $request->tidur,
        ]);

        return redirect()->route('pendonor')->with('message', 'Data Berhasil Diupdate!');
    }

    public function delete($id)
    {
        $pendonor = Pendonor::find($id);
        $pendonor->delete();

        return redirect()->route('pendonor')->with('message', 'Data Telah Berhasil Dihapus');
    }
}

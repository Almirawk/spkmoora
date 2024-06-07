<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;


class KriteriaController extends Controller
{
    public function index()
    {
        return view('kriteria.index', [
            'kriteria' => Kriteria::latest()->get()
        ]);
    }

    public function add()
    {
        return view('kriteria.insert');
    }

    public function insert(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'bobot' => 'required',
            'jenis' => 'required', 
        ]);

        Kriteria::create([
            'nama' => $request->nama,
            'bobot' => $request->bobot,
            'jenis' => $request->jenis,
        ]);

        return redirect()->route('kriteria')->with('message', 'Data Berhasil Ditambahkan!');
    }

    public function edit($id)
    {
        $kriteria = Kriteria::find($id);

        return view('kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'bobot' => 'required',
            'jenis' => 'required',
        ]);

        $kriteria = Kriteria::find($id);
        $kriteria->update([
            'nama' => $request->nama,
            'bobot' => $request->bobot,
            'jenis' => $request->jenis,
        ]);

        return redirect()->route('kriteria')->with('message', 'Data Berhasil Diupdate!');
    }

    public function delete($id)
    {
        $kriteria = Kriteria::find($id);
        $kriteria->delete();

        return redirect()->route('kriteria')->with('message', 'Data Telah Berhasil Dihapus');
    }
}

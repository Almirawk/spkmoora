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
            'kode' => 'required', 
            'nama' => 'required',
            'bobot' => 'required',
        ]);

        Kriteria::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'bobot' => $request->bobot,
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
            'kode' => 'required',
            'nama' => 'required',
            'bobot' => 'required',
        ]);

        $kriteria = Kriteria::find($id);
        $kriteria->update([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'bobot' => $request->bobot,
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

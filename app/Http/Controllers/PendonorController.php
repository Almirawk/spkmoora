<?php

namespace App\Http\Controllers;

use App\Models\Pendonor;
use Illuminate\Http\Request;

class PendonorController extends Controller
{
    public function index()
    {
        $pendonor = Pendonor::with('user')->get();
        return view('pendonor.index', compact('pendonor'));
        // return view('pendonor.index', [
        //     'pendonor' => Pendonor::latest()->get()
        // ]);
    }

    public function add()
    {
        return view('pendonor.insert');
    }

    public function insert(Request $request)
    {
        $data = $request->validate([
            'nama_pendonor' => 'required|string|max:255', 
            'alamat' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'jns_kelamin' => 'required|integer',
            'no_telepon' => 'required|numeric',
        ]);

        Pendonor::create($data);
        return redirect()->route('pendonor')->with('message', 'Data Berhasil Ditambahkan!');
    }

    public function edit($id)
    {
        $pendonor = Pendonor::findOrFail($id);
        return view('pendonor.edit', compact('pendonor'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_pendonor' => 'required|string|max:255', 
            'alamat' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'jns_kelamin' => 'required|integer',
            'no_telepon' => 'required|numeric',
        ]);

        $pendonor = Pendonor::findOrFail($id);
        $pendonor->update([
            'nama_pendonor' => $request->input('nama_pendonor'), 
            'alamat' => $request->input('alamat'),
            'tgl_lahir' => $request->input('tgl_lahir'),
            'jns_kelamin' => $request->input('jns_kelamin'),
            'no_telepon' => $request->input('no_telepon'),
        ]);

        return redirect()->route('pendonor')->with('message', 'Data Berhasil Diupdate!');
    }

    public function delete($id)
    {
        $pendonor = Pendonor::findOrFail($id);
        $pendonor->delete();

        return redirect()->route('pendonor')->with('message', 'Data Telah Berhasil Dihapus');
    }
}

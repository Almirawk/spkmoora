<?php

namespace App\Http\Controllers;

use App\Models\Pendonor;
use App\Models\User;
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
        $validatedUserData = $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        $validatedPendonorData = $request->validate([
            'golongan_darah' => 'nullable|string|in:A,B,AB,O',
            'alamat' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'jns_kelamin' => 'required',
            'no_telepon' => 'required|numeric',
        ]);
        
        // Temukan data pendonor berdasarkan $id
        $pendonor = Pendonor::findOrFail($id);
    
        // Update data user di tabel 'users' berdasarkan user_id dari pendonor
        $user = User::findOrFail($pendonor->user_id);
        $user->update($validatedUserData);
    
        $pendonor->update($validatedPendonorData);
    
        return redirect()->route('pendonor')->with('message', 'Profil berhasil diperbarui.');
    }

    public function delete($id)
    {
        $pendonor = Pendonor::findOrFail($id);
        $pendonor->delete();

        return redirect()->route('pendonor')->with('message', 'Data Telah Berhasil Dihapus');
    }
}

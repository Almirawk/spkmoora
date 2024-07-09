<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function edit()
{
    $user = auth()->user(); // Ambil data pendonor yang sedang login
    return view('pendonor.edit', compact('user'));
}

public function update(Request $request)
{
    $user = auth()->user();
    $user->update($request->only(['name', 'email', 'password'])); // Update data user

    $pendonorData = $request->except(['_token', '_method', 'name', 'email', 'password']); // Ambil semua data kecuali yang ada di list

    if ($user->pendonor) {
        // Jika sudah ada data pendonor, update
        $user->pendonor()->update($pendonorData);
    } else {
        // Jika belum ada, buat baru
        $user->pendonor()->create($pendonorData);
    }

    return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
}
}

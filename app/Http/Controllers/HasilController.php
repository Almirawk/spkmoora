<?php

namespace App\Http\Controllers;

use App\Models\Hasil;
use Illuminate\Http\Request;
use Dompdf\Dompdf;

class HasilController extends Controller
{
    public function index()
    {
        $hasil = Hasil::all();
        return view('hasil.index', compact('hasil'));
    }

    public function generatePdf()
    {
        $hasil = Hasil::all();

        // menampilkan kedalam variabel
        $pdfView = view('hasil.pdf', compact('hasil'));

        $dompdf = new Dompdf();
        $dompdf->loadHtml($pdfView);

        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        return $dompdf->stream("hasil.pdf");
    }

    // public function add()
    // {
    //     return view('hasil.insert');
    // }

    // public function insert(Request $request)
    // {
    //     $request->validate([
    //         'nama' => 'required',
    //         'hasil' => 'required',
    //     ]);

    //     Hasil::create([
    //         'nama' => $request->nama,
    //         'hasil' => $request->hasil,
    //     ]);

    //     return redirect()->route('hasil')->with('message', 'Data Berhasil Ditambahkan!');
    // }

    // public function edit($id)
    // {
    //     $hasil = Hasil::find($id);

    //     return view('hasil.edit', compact('hasil'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'nama' => 'required',
    //         'hasil' => 'required',
    //     ]);

    //     $hasil = Hasil::find($id);
    //     $hasil->update([
    //         'nama' => $request->nama,
    //         'hasil' => $request->hasil,
    //     ]);

    //     return redirect()->route('Hasil')->with('message', 'Data Berhasil Diupdate!');
    // }

    // public function delete($id)
    // {
    //     $hasil = Hasil::find($id);
    //     $hasil->delete();

    //     return redirect()->route('hasil')->with('message', 'Data Telah Berhasil Dihapus');
    // }
}

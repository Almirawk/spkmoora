<?php

namespace App\Http\Controllers;

use App\Models\Hasil;
use App\Models\Kriteria;
use App\Models\Pendonor;
use App\Models\Pemeriksaan;
use Illuminate\Http\Request;
use Dompdf\Dompdf;

use Carbon\Carbon;

class HasilController extends Controller
{

    public function __construct()
    {
        $this->middleware('web');
    }

    public function index(Request $request)
{
    $pendonors = Pendonor::all();
    $kriterias = Kriteria::all();
    $pemeriksaans = Pemeriksaan::all();

    $bobot = $kriterias->pluck('bobot', 'id')->toArray();
    $namaKriterias = $kriterias->pluck('nama', 'id')->toArray();

    $hasilKonversi = $this->getHasilKonversi($pendonors, $pemeriksaans, $kriterias, $namaKriterias);

    $matriksKeputusan = $this->buildMatriksKeputusan($hasilKonversi, $kriterias);

    $matriksNormalisasi = $this->normalisasiMatriks($matriksKeputusan);
    $nilaiMoora = $this->hitungMoora($matriksNormalisasi, $kriterias);
    $hasilAkhir = [];

    foreach ($hasilKonversi as $index => $hasil) {
        $isValid = true;
        $kriteriaNilai = [];

        // Periksa validitas data pemeriksaan untuk pendonor saat ini
        foreach ($hasil['nilai_kriteria'] as $kriteriaId => $nilai) {
            $pemeriksaan = $pendonors->find($hasil['pendonor_id'])->pemeriksaan->where('kriteria_id', $kriteriaId)->first();
            if (!$pemeriksaan) {
                $isValid = false;
                break;
            }

            // Validasi tambahan jika diperlukan, misalnya untuk nilai 0
            if ($nilai == 0) {
                $isValid = false;
                break;
            }

            // Ambil nilai kriteria asli dari Pemeriksaan
            $kriteriaNilai[] = [
                'kriteria_id' => $kriteriaId,
                'nama' => $namaKriterias[$kriteriaId],
                'nilai' => $pemeriksaan->nilai,
            ];
        }

        if ($isValid) {
            $hasilAkhir[] = [
                'pendonor_id' => $hasil['pendonor_id'],
                'nama_pendonor' => $hasil['nama_pendonor'],
                'nilai_moora' => $nilaiMoora[$index],
                'kriteria_nilai' => $kriteriaNilai, // Tambahkan kriteria nilai asli dari Pemeriksaan
                'terpilih' => false, // Inisialisasi status terpilih
            ];
        }
    }

    usort($hasilAkhir, function ($a, $b) {
        return $b['nilai_moora'] <=> $a['nilai_moora'];
    });

    $jumlah_terpilih = $request->input('jumlah_terpilih', 5);

    $hasilAkhir = $this->markTerpilih($hasilAkhir, $jumlah_terpilih);

    session(['hasilAkhir' => $hasilAkhir]);

    return view('hasil.index', compact('hasilAkhir'));
}


    public function simpan(Request $request)
    {
        $eventName = $request->input('event_name'); // Ambil nama event dari form

        // Simpan ke tabel Hasil
        foreach (session('hasilAkhir') as $hasil) {
            // Ambil nilai kriteria dari Pemeriksaan sebelum dikonversi
            $kriteriaNilai = $this->getKriteriaNilai($hasil['pendonor_id']);

            // Simpan ke tabel Hasil
            Hasil::create([
                'pendonor_id' => $hasil['pendonor_id'],
                'hasil' => $hasil['nilai_moora'],
                'status' => $hasil['terpilih'],
                'event_name' => $eventName,
                'kriteria_nilai' => json_encode($kriteriaNilai), // Simpan nilai kriteria sebagai JSON
                'created_at' => now(),
            ]);
        }

        return redirect()->back()->with('message', 'Hasil perhitungan berhasil disimpan');
    }

    private function getKriteriaNilai($pendonorId)
    {
        $pemeriksaans = Pemeriksaan::where('pendonor_id', $pendonorId)->get();

        $kriteriaNilai = [];
        foreach ($pemeriksaans as $pemeriksaan) {
            $kriteriaNilai[] = [
                'nama' => $pemeriksaan->kriteria->nama,
                'nilai' => $pemeriksaan->nilai,
            ];
        }

        return $kriteriaNilai;
    }



    private function getHasilKonversi($pendonors, $pemeriksaans, $kriterias, $namaKriterias)
    {
        $hasilKonversi = [];

        foreach ($pendonors as $pendonor) {
            $nilaiPendonor = $pemeriksaans->where('pendonor_id', $pendonor->id);
            $nilaiKriteria = [];

            if ($this->validasiKriteria($nilaiPendonor, $namaKriterias)) {
                foreach ($kriterias as $kriteria) {
                    $nilai = $nilaiPendonor->where('kriteria_id', $kriteria->id)->first()->nilai ?? '-';
                    $nilaiKriteria[$kriteria->id] = $this->konversiNilai($nilai, $kriteria->nama);
                }

                $hasilKonversi[] = [
                    'pendonor_id' => $pendonor->id,
                    'nama_pendonor' => $pendonor->user->name,
                    'nilai_kriteria' => $nilaiKriteria,
                ];
            }
        }
        // dd($hasilKonversi);
        return $hasilKonversi;
    }

    private function konversiNilai($nilai, $namaKriteria)
    {
        if ($namaKriteria == 'Tekanan Darah') {
            return $this->konversiTekananDarah($nilai);
        } elseif ($namaKriteria == 'Hemoglobin') {
            return $this->konversiHemoglobin($nilai);
        } elseif ($namaKriteria == 'Berat Badan') {
            return $this->konversiBeratBadan($nilai);
        }

        return is_numeric($nilai) ? floatval($nilai) : 0;
    }

    private function buildMatriksKeputusan($hasilKonversi, $kriterias)
    {
        $matriksKeputusan = [];

        foreach ($hasilKonversi as $hasil) {
            $baris = [];
            foreach ($kriterias as $kriteria) {
                $baris[] = $hasil['nilai_kriteria'][$kriteria->id];
            }
            $matriksKeputusan[] = $baris;
        }

        return $matriksKeputusan;
    }

    private function markTerpilih(array $hasilAkhir, $jumlahTerpilih)
    {
        foreach ($hasilAkhir as $index => $item) {
            $hasilAkhir[$index]['terpilih'] = $index < $jumlahTerpilih;
        }

        return $hasilAkhir;
    }

    private function validasiKriteria($nilaiPendonor, $namaKriterias)
    {
        foreach ($nilaiPendonor as $nilai) {
            $kriteriaNama = $namaKriterias[$nilai->kriteria_id];
            $nilai = $nilai->nilai;

            if (!$this->isValidKriteria($kriteriaNama, $nilai)) {
                return false;
            }
        }

        return true;
    }

    private function isValidKriteria($kriteriaNama, $nilai)
    {
        switch ($kriteriaNama) {
            case 'Tekanan Darah':
                return $this->validasiTekananDarah($nilai);
            case 'Berat Badan':
                return $nilai >= 50;
            case 'Hemoglobin':
                return $nilai >= 12.5 && $nilai <= 17;
            case 'Tidak Konsumsi Obat':
                return $nilai >= 3;
            case 'Umur':
                return $nilai >= 17 && $nilai <= 50;
            case 'Lamanya Terakhir Tidur':
                return $nilai >= 4;
            case 'Riwayat Penyakit':
                return $nilai == 1;
            default:
                return true;
        }
    }

    private function validasiTekananDarah($nilai)
    {
        if (!preg_match('/^\d+\/\d+$/', $nilai)) {
            return false;
        }

        list($sistolik, $diastolik) = explode('/', $nilai);

        return $sistolik >= 110 && $sistolik <= 150 && $diastolik >= 70 && $diastolik <= 90;
    }

    private function konversiTekananDarah($tekanan_darah)
    {
        if (!preg_match('/^\d+\/\d+$/', $tekanan_darah)) {
            return 0;
        }

        list($sistolik, $diastolik) = explode('/', $tekanan_darah);

        if ($sistolik < 110 && $diastolik < 70) {
            return 1;
        } elseif ($sistolik > 155 && $diastolik > 90) {
            return 2;
        }

        return 3;
    }

    private function konversiBeratBadan($berat_badan)
    {
        if (!is_numeric($berat_badan)) {
            return 0;
        }

        if ($berat_badan < 50) {
            return 1;
        } elseif ($berat_badan <= 65) {
            return 4;
        } elseif ($berat_badan <= 80) {
            return 3;
        } elseif ($berat_badan > 80) {
            return 2;
        }
    }

    private function konversiHemoglobin($hemoglobin)
    {
        if (!is_numeric($hemoglobin)) {
            return 0;
        }

        if ($hemoglobin < 12.5) {
            return 1;
        } elseif ($hemoglobin > 17) {
            return 2;
        }

        return 3;
    }

    private function normalisasiMatriks($matriks)
    {
        $matriksNormalisasi = [];
        $jumlahKriteria = count($matriks[0]);

        for ($j = 0; $j < $jumlahKriteria; $j++) {
            $sum = 0;
            foreach ($matriks as $nilai) {
                $nilai[$j] = floatval($nilai[$j]);
                $sum += pow($nilai[$j], 2);
            }
            $akarSum = sqrt($sum);

            foreach ($matriks as $i => $nilai) {
                $matriksNormalisasi[$i][$j] = $nilai[$j] / $akarSum;
            }
        }

        return $matriksNormalisasi;
    }

    private function hitungMoora($matriksNormalisasi, $kriterias)
    {
        $nilaiMoora = [];

        foreach ($matriksNormalisasi as $i => $nilai) {
            $totalBenefit = 0;
            $totalCost = 0;

            foreach ($nilai as $j => $v) {
                $bobot = floatval(str_replace(',', '.', $kriterias[$j]->bobot));
                $jenis = $kriterias[$j]->jenis;

                if ($jenis == 'Benefit') {
                    $totalBenefit += $v * $bobot;
                } elseif ($jenis == 'Cost') {
                    $totalCost += $v * $bobot;
                }
            }

            $nilaiMoora[] = $totalBenefit - $totalCost;
        }

        return $nilaiMoora;
    }
    
        public function generateRiwayatPdf($datetime)
        {
            $hasil = Hasil::where('created_at', $datetime)->get();
            $event_name = $hasil->first()->event_name ?? 'N/A';
           
            $pdfView = view('hasil.pdf', compact('hasil','datetime','event_name'));
    
            $dompdf = new Dompdf();
            $dompdf->loadHtml($pdfView);
    
            $dompdf->setPaper('A4', 'landscape');
    
            $dompdf->render();
    
            return $dompdf->stream("riwayat_perhitungan.pdf");
        }
    
        public function riwayat()
        {
            $riwayat = Hasil::orderBy('created_at', 'desc')->get()->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d H:i:s');
            });
    
            return view('hasil.riwayat', compact('riwayat'));
        }
    
        public function detailRiwayat($datetime)
        {
            $hasilPerhitungan = Hasil::where('created_at', 'like', $datetime . '%')->get();
        
            return view('hasil.detail_riwayat', compact('hasilPerhitungan'));
        }
    }
    


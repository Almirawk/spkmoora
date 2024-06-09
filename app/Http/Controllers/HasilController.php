<?php

namespace App\Http\Controllers;

use App\Models\Hasil;
use App\Models\Kriteria;
use App\Models\Pendonor;
use App\Models\Pemeriksaan;
use Illuminate\Http\Request;
use Dompdf\Dompdf;

class HasilController extends Controller
{
    public function index()
    {
        // Mengambil semua pendonor, kriteria, dan pemeriksaan dari database
    $pendonors = Pendonor::all();
    $kriterias = Kriteria::all();
    $pemeriksaans = Pemeriksaan::all();
    $bobot = [];
    $namaKriterias = [];

    // Membuat array asosiatif untuk menyimpan bobot dan nama kriteria
    foreach ($kriterias as $kriteria) {
        $bobot[$kriteria->id] = $kriteria->bobot;
        $namaKriterias[$kriteria->id] = $kriteria->nama;
    }
    
    // Array untuk menyimpan hasil konversi pendonor yang lolos validasi
    $hasilKonversi = [];

    // Looping melalui setiap pendonor
    foreach ($pendonors as $pendonor) {
        // Mendapatkan nilai pemeriksaan untuk pendonor saat ini
        $nilaiPendonor = $pemeriksaans->where('pendonor_id', $pendonor->id);
        $nilaiKriteria = [];

        // Memeriksa apakah pendonor lolos validasi
        if ($this->validasiKriteria($nilaiPendonor, $namaKriterias)) {
            // Looping melalui setiap kriteria
            foreach ($kriterias as $kriteria) {
                // Mendapatkan nilai untuk kriteria saat ini
                $nilai = $nilaiPendonor->where('kriteria_id', $kriteria->id)->first()->nilai ?? '-';
                
                // Melakukan konversi nilai sesuai dengan jenis kriteria
                if ($kriteria->nama == 'Tekanan Darah') {
                    $nilai = $this->konversiTekananDarah($nilai);
                } elseif ($kriteria->nama == 'Hemoglobin') {
                    $nilai = $this->konversiHemoglobin($nilai);
                } elseif ($kriteria->nama == 'Berat Badan') {
                    $nilai = $this->konversiBeratBadan($nilai);
                } else{
                    $nilai = is_numeric($nilai) ? floatval($nilai) : 0;
                }

                // Menyimpan nilai konversi untuk kriteria saat ini
                $nilaiKriteria[$kriteria->id] = $nilai;
            }

            // Menyimpan hasil konversi pendonor yang lolos validasi
            $hasilKonversi[] = [
                'nama_pendonor' => $pendonor->user->name,
                'nilai_kriteria' => $nilaiKriteria,
            ];
            
        }
    }

       

        $matriksKeputusan = [];
        foreach ($hasilKonversi as $hasil) {
            $baris = [];
            foreach ($kriterias as $kriteria) {
                $baris[] = $hasil['nilai_kriteria'][$kriteria->id];
            }
            $matriksKeputusan[] = $baris;
        }

        // Normalisasi Matriks Keputusan
        $matriksNormalisasi = $this->normalisasiMatriks($matriksKeputusan);
       
        // Hitung nilai MOORA untuk setiap alternatif
        $nilaiMoora = $this->hitungMoora($matriksNormalisasi, $kriterias);
        
        // Menyusun hasil akhir dengan nama pendonor
        $hasilAkhir = [];
        foreach ($hasilKonversi as $index => $hasil) {
            $hasilAkhir[] = [
                'nama_pendonor' => $hasil['nama_pendonor'],
                'nilai_moora' => $nilaiMoora[$index],
            ];
        }

        // Mengurutkan hasil akhir berdasarkan nilai MOORA (descending)
        usort($hasilAkhir, function ($a, $b) {
            return $b['nilai_moora'] <=> $a['nilai_moora'];
        });

        // foreach ($hasilAkhir as $hasil) {
        //     Hasil::create([
        //         'nama' => $hasil['nama_pendonor'],
        //         'hasil' => $hasil['nilai_moora'],
        //         'created_at' => now(), // Tanggal dan waktu saat ini
        //     ]);
        // }

        
        // dd($hasilAkhir);

        return view('hasil.index', compact('hasilAkhir'));
    }

    public function simpan()
    {
        // Mengambil semua pendonor, kriteria, dan pemeriksaan dari database
    $pendonors = Pendonor::all();
    $kriterias = Kriteria::all();
    $pemeriksaans = Pemeriksaan::all();
    $bobot = [];
    $namaKriterias = [];

    // Membuat array asosiatif untuk menyimpan bobot dan nama kriteria
    foreach ($kriterias as $kriteria) {
        $bobot[$kriteria->id] = $kriteria->bobot;
        $namaKriterias[$kriteria->id] = $kriteria->nama;
    }

    // Array untuk menyimpan hasil konversi pendonor yang lolos validasi
    $hasilKonversi = [];

    // Looping melalui setiap pendonor
    foreach ($pendonors as $pendonor) {
        // Mendapatkan nilai pemeriksaan untuk pendonor saat ini
        $nilaiPendonor = $pemeriksaans->where('pendonor_id', $pendonor->id);
        $nilaiKriteria = [];

        // Memeriksa apakah pendonor lolos validasi
        if ($this->validasiKriteria($nilaiPendonor, $namaKriterias)) {
            // Looping melalui setiap kriteria
            foreach ($kriterias as $kriteria) {
                // Mendapatkan nilai untuk kriteria saat ini
                $nilai = $nilaiPendonor->where('kriteria_id', $kriteria->id)->first()->nilai ?? '-';
                
                // Melakukan konversi nilai sesuai dengan jenis kriteria
                if ($kriteria->nama == 'Tekanan Darah') {
                    $nilai = $this->konversiTekananDarah($nilai);
                } elseif ($kriteria->nama == 'Hemoglobin') {
                    $nilai = $this->konversiHemoglobin($nilai);
                } elseif ($kriteria->nama == 'Berat Badan') {
                    $nilai = $this->konversiBeratBadan($nilai);
                } else{
                    $nilai = is_numeric($nilai) ? floatval($nilai) : 0;
                }

                // Menyimpan nilai konversi untuk kriteria saat ini
                $nilaiKriteria[$kriteria->id] = $nilai;
            }

            // Menyimpan hasil konversi pendonor yang lolos validasi
            $hasilKonversi[] = [
                'pendonor_id' => $pendonor->id, // Ubah 'nama_pendonor' menjadi 'pendonor_id'
                'nilai_kriteria' => $nilaiKriteria,
            ];
        }
    }
        $matriksKeputusan = [];
        foreach ($hasilKonversi as $hasil) {
            $baris = [];
            foreach ($kriterias as $kriteria) {
                $baris[] = $hasil['nilai_kriteria'][$kriteria->id];
            }
            $matriksKeputusan[] = $baris;
        }

        // Normalisasi Matriks Keputusan
        $matriksNormalisasi = $this->normalisasiMatriks($matriksKeputusan);
        
        // Hitung nilai MOORA untuk setiap alternatif
        $nilaiMoora = $this->hitungMoora($matriksNormalisasi, $kriterias);
        
        // Menyusun hasil akhir dengan nama pendonor
        $hasilAkhir = [];
        foreach ($hasilKonversi as $index => $hasil) {
            $hasilAkhir[] = [
                'pendonor_id' => $hasil['pendonor_id'],
                'nilai_moora' => $nilaiMoora[$index],
            ];
        }
        

        // Mengurutkan hasil akhir berdasarkan nilai MOORA (descending)
        usort($hasilAkhir, function ($a, $b) {
            return $b['nilai_moora'] <=> $a['nilai_moora'];
        });

        foreach ($hasilAkhir as $hasil) {
            Hasil::create([
                'pendonor_id' => $hasil['pendonor_id'], // Ubah 'nama' menjadi 'pendonor_id'
                'hasil' => $hasil['nilai_moora'],
                'created_at' => now(), // Tanggal dan waktu saat ini
            ]);
        }

        
        // dd($hasilAkhir);

        return redirect()->back()->with('message', 'Hasil perhitungan berhasil disimpan');
    }

    

    private function validasiKriteria($nilaiPendonor, $namaKriterias)
{
    // Inisialisasi status validasi
    $valid = false;

    // Lakukan validasi untuk setiap kriteria
    foreach ($nilaiPendonor as $nilai) {
        $kriteriaNama = $namaKriterias[$nilai->kriteria_id];
        $nilai = $nilai->nilai;

        // Lakukan validasi sesuai dengan kriteria
        if ($kriteriaNama == 'Tekanan Darah') {
            // Memeriksa apakah nilai tekanan darah memiliki format yang sesuai
            if (!preg_match('/^\d+\/\d+$/', $nilai)) {
                return false; // Jika salah satu kriteria tidak valid, langsung kembalikan false
            }

            list($sistolik, $diastolik) = explode('/', $nilai);

            // Validasi rentang nilai tekanan darah
            if ($sistolik < 110 || $sistolik > 150 || $diastolik < 70 || $diastolik > 90) {
                return false; // Jika salah satu kriteria tidak valid, langsung kembalikan false
            }
        } elseif ($kriteriaNama == 'Berat Badan') {
            // Validasi minimal berat badan
            if ($nilai < 50) {
                return false; // Jika salah satu kriteria tidak valid, langsung kembalikan false
            }
        } elseif ($kriteriaNama == 'Hemoglobin') {
            // Validasi rentang nilai hemoglobin
            if ($nilai < 12.5 || $nilai > 17) {
                return false; // Jika salah satu kriteria tidak valid, langsung kembalikan false
            }
        } elseif ($kriteriaNama == 'Tidak Konsumsi Obat') {
            // Validasi minimal obat yang tidak dikonsumsi
            if ($nilai < 3) {
                return false; // Jika salah satu kriteria tidak valid, langsung kembalikan false
            }
        } elseif ($kriteriaNama == 'Umur') {
            // Validasi rentang nilai umur
            if ($nilai < 17 || $nilai > 50) {
                return false; // Jika salah satu kriteria tidak valid, langsung kembalikan false
            }
        } elseif ($kriteriaNama == 'Lamanya Terakhir Tidur') {
            // Validasi minimal lamanya terakhir tidur
            if ($nilai < 4) {
                return false; // Jika salah satu kriteria tidak valid, langsung kembalikan false
            }
        } elseif ($kriteriaNama == 'Riwayat Penyakit') {
            // Validasi jumlah riwayat penyakit
            if ($nilai != 1) {
                return false; // Jika salah satu kriteria tidak valid, langsung kembalikan false
            }
        }

        // Set valid menjadi true jika setidaknya ada satu kriteria yang valid
        $valid = true;
    }

    // Kembalikan status validasi
    return $valid;
}

    private function konversiTekananDarah($tekanan_darah)
    {
        // Memeriksa apakah nilai tekanan darah memiliki format yang sesuai
        if (!preg_match('/^\d+\/\d+$/', $tekanan_darah)) {
            // Jika tidak, kembalikan nilai default atau tangani kesalahan dengan cara lain
            return 0; // Misalnya, nilai default 0
        }

        list($sistolik, $diastolik) = explode('/', $tekanan_darah);

        // Lakukan konversi berdasarkan rentang nilai tekanan darah
        if ($sistolik < 110 && $diastolik < 70) {
            return 1; // Nilai rendah
        } elseif ($sistolik > 155 && $diastolik > 90) {
            return 2; // Nilai tinggi
        } else {
            return 3; // Nilai sedang
        }
    }

    private function konversiBeratBadan($berat_badan)
    {
        // Memeriksa apakah nilai berat badan memiliki format yang sesuai
        if (!is_numeric($berat_badan)) {
            // Jika tidak, kembalikan nilai default atau tangani kesalahan dengan cara lain
            return 0; // Misalnya, nilai default 0
        }

        // Lakukan konversi berdasarkan rentang nilai berat badan
        if ($berat_badan < 50) {
            return 1; // Nilai kurus
        } elseif ($berat_badan >= 50 && $berat_badan <= 65) {
            return 4; // Nilai sedang
        } elseif ($berat_badan > 65 && $berat_badan <= 80) {
            return 3; // Nilai gemuk
        } elseif ($berat_badan > 80) {
            return 2; // Nilai obesitas
        }
    }


    private function konversiHemoglobin($hemoglobin)
    {
        // Memeriksa apakah nilai hemoglobin memiliki format yang sesuai
        if (!is_numeric($hemoglobin)) {
            // Jika tidak, kembalikan nilai default atau tangani kesalahan dengan cara lain
            return 0; // Misalnya, nilai default 0
        }

        // Lakukan konversi berdasarkan rentang nilai hemoglobin
        if ($hemoglobin < 12.5) {
            return 1; // Nilai rendah
        } elseif ($hemoglobin > 17) {
            return 2; // Nilai tinggi
        } else {
            return 3; // Nilai normal
        }
    }

    private function normalisasiMatriks($matriks)
    {
        $matriksNormalisasi = [];
        $jumlahKriteria = count($matriks[0]);

        for ($j = 0; $j < $jumlahKriteria; $j++) {
            $sum = 0;
            foreach ($matriks as $i => $nilai) {
                // Pastikan Anda mengonversi nilai string ke numerik jika diperlukan
                $nilai[$j] = floatval($nilai[$j]);
                $sum += pow($nilai[$j], 2);
            }
            $akarSum = sqrt($sum);

            foreach ($matriks as $i => $nilai) {
                // Pastikan Anda menggunakan nilai numerik untuk normalisasi
                $matriksNormalisasi[$i][$j] = $nilai[$j] / $akarSum;
            }
        }
        // dd($matriksNormalisasi);
        return $matriksNormalisasi;
    }

    private function hitungMoora($matriksNormalisasi, $kriterias)
{
    $nilaiMoora = [];

    foreach ($matriksNormalisasi as $i => $nilai) {
        $totalBenefit = 0;
        $totalCost = 0;

        foreach ($nilai as $j => $v) {
            // Ambil bobot dan jenis kriteria (benefit atau cost)
            $bobot = $kriterias[$j]->bobot;
            $jenis = $kriterias[$j]->jenis;

            // Konversi bobot menjadi float (jika perlu)
            $bobot = floatval(str_replace(',', '.', $bobot));

            // Perhitungan total nilai benefit dan cost
            if ($jenis == 'Benefit') {
                $totalBenefit += $v * $bobot;
            } elseif ($jenis == 'Cost') {
                $totalCost += $v * $bobot;
            }
        }

        // Hitung nilai MOORA dengan mengurangkan total cost dari total benefit
        $nilaiMoora[] = $totalBenefit - $totalCost;
    }

    return $nilaiMoora;
}







public function generateRiwayatPdf($datetime)
{
    
    $hasil = Hasil::where('created_at', $datetime)->get();
    $pdfView = view('hasil.pdf', compact('hasil'));

    $dompdf = new Dompdf();
    $dompdf->loadHtml($pdfView);

    $dompdf->setPaper('A4', 'landscape');

    $dompdf->render();

    return $dompdf->stream("riwayat_perhitungan.pdf");
}

    public function riwayat()
{
    $riwayat = Hasil::orderBy('created_at', 'desc')->get()->groupBy(function($date) {
        return \Carbon\Carbon::parse($date->created_at)->format('Y-m-d H:i:s');
    });

    return view('hasil.riwayat', compact('riwayat'));
}
public function detailRiwayat($datetime)
{
    $hasilPerhitungan = Hasil::where('created_at', 'like', $datetime . '%')->get();

    return view('hasil.detail_riwayat', compact('hasilPerhitungan'));
}


}

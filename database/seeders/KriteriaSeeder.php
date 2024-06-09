<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\kriteria;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kriterias = [
            ['nama' => 'Tekanan Darah', 'bobot' => 0.25, 'jenis' => 'Benefit'],
            ['nama' => 'Berat Badan', 'bobot' => 0.15, 'jenis' => 'Benefit'],
            ['nama' => 'Hemoglobin', 'bobot' => 0.25, 'jenis' => 'Benefit'],
            ['nama' => 'Tidak Konsumsi Obat', 'bobot' => 0.15, 'jenis' => 'Benefit'],
            ['nama' => 'Umur', 'bobot' => 0.1, 'jenis' => 'Benefit'],
            ['nama' => 'Lamanya Terakhir Tidur', 'bobot' => 0.05, 'jenis' => 'Benefit'],
            ['nama' => 'Riwayat Penyakit', 'bobot' => 0.05, 'jenis' => 'Benefit'],
        ];

        foreach ($kriterias as $kriteria) {
            kriteria::create($kriteria);
        }
    }
}

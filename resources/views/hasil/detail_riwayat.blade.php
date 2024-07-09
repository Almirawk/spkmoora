@extends('layout.app')
@section('title', 'Detail Riwayat')
@section('content')
    <h1 class="h3 mb-2 text-gray-800">Detail Riwayat Perhitungan</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Ranking</th>
                            <th>Nama Pendonor</th>
                            <th>Pemeriksaan</th>
                            <th>Hasil</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hasilPerhitungan as $index => $hasil)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $hasil->pendonor->user->name }}</td>
                                <td>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Kriteria</th>
                                                <th>Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($hasil->pendonor->pemeriksaan as $pemeriksaan)
                                                <tr>
                                                    <td>{{ $pemeriksaan->kriteria->nama }}</td>
                                                    <td>
                                                        @php
                                                            $nilai = $pemeriksaan->nilai;
                                                            if ($pemeriksaan->kriteria->nama == 'Riwayat Penyakit') {
                                                                $nilai = $nilai == 1 ? 'Tidak' : ($nilai == 0 ? 'Iya' : '-');
                                                            }
                                                        @endphp
                                                        {{ $nilai }}
                                                    </td>
                                                    
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                                <td>{{ number_format($hasil->hasil, 5) }}</td>
                                <td>
                                    <span class="badge text-white p-2 {{ $hasil->status ? 'bg-primary' : 'bg-danger' }}">
                                        {{ $hasil->status ? 'Terpilih' : 'Tidak Terpilih' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

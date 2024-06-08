@extends('layout.app')
@section('title', 'Riwayat')
@section('content')
    <h1 class="h3 mb-2 text-gray-800">Riwayat Perhitungan</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayat as $datetime => $hasilPerhitungan)
                            <tr>
                                <td>{{ $datetime }}</td>
                                <td>
                                    <a href="{{ route('riwayat.pdf', $datetime) }}" class="btn btn-primary btn-sm mt-2"><i class="fas fa-file-pdf me-2"></i>Cetak PDF</a>
                                    <a href="{{ route('riwayat.detail', $datetime) }}" class="btn btn-primary btn-sm mt-2">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

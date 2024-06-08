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
                            <th>No</th>
                            <th>Nama Pendonor</th>
                            <th>Hasil</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hasilPerhitungan as $index => $hasil)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $hasil->nama }}</td>
                                <td>{{ $hasil->hasil }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

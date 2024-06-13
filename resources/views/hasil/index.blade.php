@extends('layout.app')
@section('title', 'Hasil')
@section('content')
    
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Hasil</h1>

    @if (session('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <form action="{{ route('hasil.simpan') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-save me-2"></i>Simpan Perhitungan
                </button>
            </form>
        </div>
        
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>Ranking</th>
                            <th>Nama Pendonor</th>
                            <th>Hasil</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hasilAkhir as $index => $row)
                        <tr class="text-center">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row['nama_pendonor'] }}</td>
                            <td>{{ $row['nilai_moora'] }}</td>
                            {{-- <td>
                                <a href="{{ route('hasil.edit', $row['nama_pendonor']) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit me-2"></i>Edit</a>
                                <a href="{{ route('hasil.delete', $row['nama_pendonor']) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash me-2"></i>Delete</a>
                            </td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

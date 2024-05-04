@extends('layout.app')
@section('title', 'hasil')
@section('content')
    
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Hasil</h1>

    @if (session('message'))
        <div class="alert alert-succes alert-sidmissible fade show" role="alert">
            {{session('message')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('hasil.pdf') }}" class="btn btn-primary btn-sm"><i class="fas fa-file-pdf me-2"></i>Cetak PDF</a>
        </div>
        
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Pendonor</th>
                            <th>Hasil</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($hasil as $row)
                        <tr class="text-center">
                            <td>{{$no++}}</td>
                            <td>{{$row->nama}}</td>
                            <td>{{$row->hasil}}</td>
                            <td>
                                <a href="{{route('hasil.edit', $row->id)}}" class="btn btn-warning btn-sm"><i class="fas fa-edit me-2"></i>Edit</a>
                                <a href="{{route('hasil.delete', $row->id)}}" class="btn btn-danger btn-sm"><i class="fas fa-trash me-2"></i> Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection
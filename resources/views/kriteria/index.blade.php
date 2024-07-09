@extends('layout.app')
@section('title', 'kriteria')
@section('content')
    
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Kriteria</h1>

    @if (session('message'))
        <div class="alert alert-success alert-sidmissible fade show" role="alert">
            {{session('message')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

    <!-- DataTales -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
                <i class="fas fa-plus me-3"></i>Tambah
            </button>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Kriteria</th>
                            <th>Bobot</th>
                            <th>Jenis</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($kriteria as $row)
                        <tr class="text-center">
                            <td>{{$no++}}</td>
                            <td>{{$row->nama}}</td>
                            <td>{{$row->bobot * 100}}%</td>
                            <td>{{$row->jenis}}</td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal{{ $row->id }}">
                                    <i class="fas fa-edit me-2"></i>Edit
                                </button>
                                <a href="{{route('kriteria.delete', $row->id)}}" class="btn btn-danger btn-sm"><i class="fas fa-trash me-2"></i> Delete</a>
                            </td>
                        </tr>

                        <!-- Bootstrap Modal for Edit Data -->
                        <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $row->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel{{ $row->id }}">Edit Data Kriteria</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('kriteria.update', $row->id) }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="nama">Nama Kriteria</label>
                                                <input type="text" class="form-control" id="nama" name="nama" value="{{ $row->nama }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="bobot">Bobot</label>
                                                <input type="number" step="0.01" class="form-control" id="bobot" name="bobot" value="{{ $row->bobot }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="jenis">Jenis</label>
                                                <select class="form-control" id="jenis" name="jenis" required>
                                                    <option value="Benefit" {{ $row->jenis == 'Benefit' ? 'selected' : '' }}>Benefit</option>
                                                    <option value="Cost" {{ $row->jenis == 'Cost' ? 'selected' : '' }}>Cost</option>
                                                </select>
                                            </div>                                            
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap Modal for Adding Data -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Data Kriteria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('kriteria.add.insert') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama Kriteria</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="bobot">Bobot</label>
                            <input type="text" class="form-control" id="bobot" name="bobot" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis">Jenis</label>
                            <select class="form-control" id="jenis" name="jenis" required>
                                <option value="Benefit" {{ $row->jenis == 'Benefit' ? 'selected' : '' }}>Benefit</option>
                                <option value="Cost" {{ $row->jenis == 'Cost' ? 'selected' : '' }}>Cost</option>
                            </select>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



@endsection
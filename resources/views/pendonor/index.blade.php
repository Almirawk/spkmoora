@extends('layout.app')
@section('title', 'pendonor')
@section('content')
    
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Pendonor</h1>

    @if (session('message'))
        <div class="alert alert-success alert-sidmissible fade show" role="alert">
            {{session('message')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- DataTales Example -->
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
                            <th>Nama pendonor</th>
                            <th>Umur</th>
                            <th>Tekanan Darah</th>
                            <th>Berat Badan</th>
                            <th>Hemoglobin</th>
                            <th>Konsumsi Obat</th>
                            <th>Tidur</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($pendonor as $row)
                        <tr class="text-center">
                            <td>{{$no++}}</td>
                            <td>{{$row->nama_pendonor}}</td>
                            <td>{{$row->umur}}</td>
                            <td>{{$row->tekanan_darah}}</td>
                            <td>{{$row->berat_badan}}</td>
                            <td>{{$row->hemoglobin}}</td>
                            <td>{{$row->konsumsi_obat}}</td>
                            <td>{{$row->tidur}}</td>
                            <td>
                                <button type="button" class="btn btn-warning mb-2 btn-sm" data-toggle="modal" data-target="#editModal{{ $row->id }}">
                                    <i class="fas fa-edit"></i>Edit
                                </button>
                                <a href="{{route('pendonor.delete', $row->id)}}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>Delete</a>
                            </td>
                        </tr>

                        <!-- Bootstrap Modals for Editing Data -->
                        <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $row->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel{{ $row->id }}">Edit Data Pendonor</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('pendonor.update', $row->id) }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="nama_pendonor">Nama Pendonor</label>
                                                <input type="text" class="form-control" id="nama_pendonor" name="nama_pendonor" value="{{ $row->nama_pendonor }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="umur">Umur</label>
                                                <input type="number" class="form-control" id="umur" name="umur" value="{{ $row->umur }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="tekanan_darah">Tekanan Darah</label>
                                                <input type="text" class="form-control" id="tekanan_darah" name="tekanan_darah" value="{{ $row->tekanan_darah }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="berat_badan">Berat Badan</label>
                                                <input type="text" class="form-control" id="berat_badan" name="berat_badan" value="{{ $row->berat_badan }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="hemoglobin">Hemoglobin</label>
                                                <input type="text" class="form-control" id="hemoglobin" name="hemoglobin" value="{{ $row->hemoglobin }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="konsumsi_obat">Konsumsi Obat</label>
                                                <input type="text" class="form-control" id="konsumsi_obat" name="konsumsi_obat" value="{{ $row->konsumsi_obat }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="tidur">Tidur</label>
                                                <input type="text" class="form-control" id="tidur" name="tidur" value="{{ $row->tidur }}" required>
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
                <h5 class="modal-title" id="addModalLabel">Tambah Data Pendonor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('pendonor.add.insert') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_pendonor">Nama Pendonor</label>
                        <input type="text" class="form-control" id="nama_pendonor" name="nama_pendonor" required>
                    </div>
                    <div class="form-group">
                        <label for="umur">Umur</label>
                        <input type="number" class="form-control" id="umur" name="umur" required>
                    </div>
                    <div class="form-group">
                        <label for="tekanan_darah">Tekanan Darah</label>
                        <input type="text" class="form-control" id="tekanan_darah" name="tekanan_darah" required>
                    </div>
                    <div class="form-group">
                        <label for="berat_badan">Berat Badan</label>
                        <input type="text" class="form-control" id="berat_badan" name="berat_badan" required>
                    </div>
                    <div class="form-group">
                        <label for="hemoglobin">Hemoglobin</label>
                        <input type="text" class="form-control" id="hemoglobin" name="hemoglobin" required>
                    </div>
                    <div class="form-group">
                        <label for="konsumsi_obat">Konsumsi Obat</label>
                        <input type="text" class="form-control" id="konsumsi_obat" name="konsumsi_obat" required>
                    </div>
                    <div class="form-group">
                        <label for="tidur">Tidur</label>
                        <input type="text" class="form-control" id="tidur" name="tidur" required>
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
@extends('layout.app')
@section('title', 'Pendonor')
@section('content')
    
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Pendonor</h1>

    @if (session('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
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
                            <th>Nama Pendonor</th>
                            <th>Alamat</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>No Telepon</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($pendonor as $row)
                        <tr class="text-center">
                            <td>{{$no++}}</td>
                            <td>{{$row->user->name}}</td>
                            <td>{{$row->alamat}}</td>
                            <td>{{$row->tgl_lahir}}</td>
                            <td>{{$row->jns_kelamin== 1 ? 'Laki-Laki' : 'Perempuan'}}</td>
                            <td>{{$row->no_telepon}}</td>
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
                                                <label for="alamat">Alamat</label>
                                                <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $row->alamat }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="tgl_lahir">Tanggal Lahir</label>
                                                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="{{ $row->tgl_lahir }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="jns_kelamin">Jenis Kelamin</label>
                                                <select class="form-control" id="jns_kelamin" name="jns_kelamin" required>
                                                    <option value="0" {{ $row->jns_kelamin == '0' ? 'selected' : '' }}>Perempuan</option>
                                                    <option value="1" {{ $row->jns_kelamin == '1' ? 'selected' : '' }}>Laki-Laki</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="no_telepon">No Telepon</label>
                                                <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="{{ $row->no_telepon }}" required>
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
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                        </div>
                        <div class="form-group">
                            <label for="tgl_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" required>
                        </div>
                        <div class="form-group">
                            <label for="jns_kelamin">Jenis Kelamin</label>
                            <select class="form-control" id="jns_kelamin" name="jns_kelamin" required>
                                <option value="0">Perempuan</option>
                                <option value="1">Laki-Laki</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="no_telepon">No Telepon</label>
                            <input type="text" class="form-control" id="no_telepon" name="no_telepon" required>
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

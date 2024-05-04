{{-- @extends('layout.app')
@section('title', 'tambah kriteria')
@section('content')
    <h1 class="h3 mb-2 text-gray-800">Kriteria</h1>

    <div class="row">
        <div class="col-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Kriteria</h6>
                </div>
                <div class="card-body">
                    <form action="{{route('kriteria.add.insert')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Kode</label>
                            <input type="text" name="kode" class="form-control">
                            @error('kode')
                                {{$message}} 
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nama Kriteria</label>
                            <input type="text" name="nama" class="form-control">
                            @error('nama')
                                {{$message}} 
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Bobot</label>
                            <input type="text" name="bobot" class="form-control">
                            @error('bobot')
                                {{$message}} 
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save">Simpan</i></button>
                    </form>
        
                </div>
            </div>
        </div>
    </div>
    
@endsection --}}
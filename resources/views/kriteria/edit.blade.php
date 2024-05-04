{{-- @extends('layout.app')
@section('title', 'edit kriteria')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Edit Kriteria</h1>

    <div class="row">
        <div class="col-6">
            <div class="card-body">
                <form action="{{ route('kriteria.update', $kriteria->id) }}" method="post">
                    @csrf
                    @method('post')
            
                    <div class="form-group">
                        <label for="kode">Kode</label>
                        <input type="text" name="kode" id="kode" class="form-control" value="{{ $kriteria->kode }}" required>
                    </div>
            
                    <div class="form-group">
                        <label for="nama">Nama Kriteria</label>
                        <input type="text" name="nama" id="nama" class="form-control" value="{{ $kriteria->nama }}" required>
                    </div>
            
                    <div class="form-group">
                        <label for="bobot">Bobot</label>
                        <input type="text" name="bobot" id="bobot" class="form-control" value="{{ $kriteria->bobot }}" required>
                    </div>
            
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Form untuk edit -->
    

@endsection --}}

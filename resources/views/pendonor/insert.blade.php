{{-- @extends('layout.app')
@section('title', 'tambah data pendonor')
@section('content')
    <h1 class="h3 mb-2 text-gray-800">Data Pendonor</h1>

    <div class="row">
        <div class="col-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Data Pendonor</h6>
                </div>
                <div class="card-body">
                    <form action="{{route('pendonor.add.insert')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Nama Pendonor</label>
                            <input type="text" name="nama_pendonor" class="form-control">
                            @error('nama pendonor')
                                {{$message}} 
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Umur</label>
                            <input type="text" name="umur" class="form-control">
                            @error('umur')
                                {{$message}} 
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Tekanan Darah</label>
                            <input type="text" name="tekanan_darah" class="form-control">
                            @error('tekanan darah')
                                {{$message}} 
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Berat Badan</label>
                            <input type="text" name="berat_badan" class="form-control">
                            @error('berat badan')
                                {{$message}} 
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Hemoglobin</label>
                            <input type="text" name="hemoglobin" class="form-control">
                            @error('hemoglobin')
                                {{$message}} 
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Konsumsi Obat</label>
                            <input type="text" name="konsumsi_obat" class="form-control">
                            @error('konsumsi obat')
                                {{$message}} 
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Tidur</label>
                            <input type="text" name="tidur" class="form-control">
                            @error('tidur')
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
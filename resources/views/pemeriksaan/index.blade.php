@extends('layout.app')
@section('title', 'pemeriksaan')
@section('content')

    <h1 class="h3 mb-2 text-gray-800">Data Pemeriksaan</h1>

    @if (session('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Pendonor</th>
                            <th>Golongan Darah</th>
                            @foreach ($kriterias as $item)
                                <th>{{ $item->nama }}</th>
                            @endforeach
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendonors as $pendonor)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pendonor->user->name }}</td>
                                <td>{{ $pendonor->golongan_darah}}</td>
                                @foreach ($kriterias as $kriteria)
                                @php
                                if ($kriteria->nama == 'Umur') {
                                    $tulisan = $pendonor->age;
                                }else {
                                $nilai = $pendonor->pemeriksaans->where('kriteria_id', $kriteria->id)->first()->nilai ?? '-';
                                if ($kriteria->nama == 'Riwayat Penyakit') {
                                    $tulisan = ($nilai == 1) ? 'Tidak' : (($nilai == 0) ? 'Iya' : '-');
                                } else {
                                    $tulisan = $nilai; 
                                }
                                }
                            @endphp
                            <td>{{ $tulisan }}</td>
                                @endforeach
                                <td>
                                    <div class="d-flex ">
                                        <button type="button" class="btn btn-primary mb-2 mr-1" data-toggle="modal"
                                        data-target="#nilaiEditModal{{ $pendonor->id }}"
                                        data-pendonor-id="{{ $pendonor->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger mb-2" data-toggle="modal"
                                        data-target="#deleteModal{{ $pendonor->id }}"
                                        data-pendonor-id="{{ $pendonor->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="nilaiEditModal{{ $pendonor->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="nilaiEditModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="nilaiEditModalLabel">Edit Nilai</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="POST" action="{{ route('nilai.update') }}">
                                            @csrf
                                            <div class="modal-body">
                                                <input type="hidden" id="pendonor_id" name="pendonor_id" value="{{ $pendonor->id }}">
                                                @foreach ($kriterias as $kriteria)
                                                    @if ($kriteria->nama !== 'Umur')
                                                    <div class="form-group">
                                                        @php
                                                            $nilaiRiwayat = $pendonor->pemeriksaans->where('kriteria_id', $kriteria->id)->first()->nilai ?? '';
                                                        @endphp
                                                        <label for="nilai_{{ $kriteria->id }}">{{ $kriteria->nama }}</label>
                                                        @if ($kriteria->nama === 'Lamanya Terakhir Tidur')
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="nilai_{{ $kriteria->id }}"
                                                                    name="nilai[{{ $kriteria->id }}]" value="{{ $nilaiRiwayat }}" required>
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">Jam terakhir</span>
                                                                </div>
                                                            </div>
                                                        @elseif ($kriteria->nama === 'Tidak Konsumsi Obat')
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="nilai_{{ $kriteria->id }}"
                                                                    name="nilai[{{ $kriteria->id }}]" value="{{ $nilaiRiwayat }}" required>
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">Hari terakhir</span>
                                                                </div>
                                                            </div>
                                                        @elseif ($kriteria->nama === 'Riwayat Penyakit')
                                                            <select class="form-control mb-2" id="nilai_{{ $kriteria->id }}" name="nilai[{{ $kriteria->id }}]" required>
                                                                <option value="0" @if($nilaiRiwayat == 0) selected @endif>Iya</option>
                                                                <option value="1" @if($nilaiRiwayat == 1) selected @endif>Tidak</option>
                                                            </select>
                                                        @else
                                                            <input type="text" class="form-control mb-2" id="nilai_{{ $kriteria->id }}" name="nilai[{{ $kriteria->id }}]"
                                                                   value="{{ $nilaiRiwayat }}" required>
                                                        @endif
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                        
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Konfirmasi Hapus -->
                            <div class="modal fade" id="deleteModal{{ $pendonor->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="deleteModalLabel{{ $pendonor->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $pendonor->id }}">Konfirmasi
                                                Hapus</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus data pemeriksaan untuk pendonor
                                            {{ $pendonor->user->name }}?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Batal</button>
                                            <form action="{{ route('pemeriksaan.destroy', $pendonor->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus</button>
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



    <script>
        $('#nilaiModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); 
            var pendonorId = button.data('pendonor-id'); 
            var modal = $(this);
            modal.find('.modal-body #pendonor_id').val(pendonorId);
        });

        $('#nilaiEditModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); 
            var pendonorId = button.data('pendonor-id'); 
            var modal = $(this);
            modal.find('.modal-body #pendonor_id').val(pendonorId);
        });

        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); 
            var pendonorId = button.data('pendonor-id'); 
            var modal = $(this);
            modal.find('.modal-body #pendonor_id').val(pendonorId);
        });
    </script>

@endsection

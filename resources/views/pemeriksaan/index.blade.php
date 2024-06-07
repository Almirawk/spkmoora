@extends('layout.app')
@section('title', 'pemeriksaan')
@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Pemeriksaan</h1>

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
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Pendonor</th>
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
                                @foreach ($kriterias as $kriteria)
                                    <td>{{ $pendonor->pemeriksaans->where('kriteria_id', $kriteria->id)->first()->nilai ?? '-' }}
                                    </td>
                                @endforeach
                                <td>
                                    <!-- Button for Set Value -->
                                    <button type="button" class="btn btn-success mb-2" data-toggle="modal"
                                        data-target="#nilaiModal{{ $pendonor->id }}" data-pendonor-id="{{ $pendonor->id }}">
                                        <i class="fas fa-plus"></i> Beri Nilai
                                    </button>
                                </td>
                            </tr>
                            <div class="modal fade" id="nilaiModal{{ $pendonor->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="nilaiModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="nilaiModalLabel">Beri Nilai</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="POST" action="{{ route('nilai.set') }}">
                                            @csrf
                                            <div class="modal-body">
                                                <input type="hidden" id="pendonor_id" name="pendonor_id"
                                                    value="{{ $pendonor->id }}">
                                                @foreach ($kriterias as $kriteria)
                                                    <div class="form-group">
                                                        <label
                                                            for="nilai_{{ $kriteria->id }}">{{ $kriteria->nama }}</label>
                                                        @if ($kriteria->nama === 'Riwayat Penyakit')
                                                            <select class="form-control mb-2"
                                                                id="nilai_{{ $kriteria->id }}"
                                                                name="nilai[{{ $kriteria->id }}]" required>
                                                                <option value="0">Iya</option>
                                                                <option value="1">Tidak</option>
                                                            </select>
                                                        @else
                                                            <input type="text" class="form-control mb-2"
                                                                id="nilai_{{ $kriteria->id }}"
                                                                name="nilai[{{ $kriteria->id }}]" required>
                                                        @endif
                                                    </div>
                                                @endforeach

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
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



    <script>
        // Set pendonor_id in the modal
        $('#nilaiModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var pendonorId = button.data('pendonor-id'); // Extract info from data-* attributes
            var modal = $(this);
            modal.find('.modal-body #pendonor_id').val(pendonorId);
        });
    </script>

@endsection

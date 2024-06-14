@extends('layout.app')
@section('title', 'Hasil')
@section('content')
    
    <h1 class="h3 mb-2 text-gray-800">Hasil</h1>

    @if (session('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
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

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <form id="jumlahTerpilihForm" action="{{ route('hasil') }}" method="GET">
                @csrf
                <div class="mb-3">
                    <label for="jumlah_terpilih" class="form-label">Jumlah Data Terpilih:</label>
                    <div id="jumlahTerpilihWrapper">
                        <input type="number" id="jumlah_terpilih" name="jumlah_terpilih" class="form-control" min="1" max="{{ count($hasilAkhir) }}" value="{{ request()->input('jumlah_terpilih', 5) }}">
                    </div>
                </div>
            </form>
            
        </div>

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
                            <th>Status</th> <!-- Kolom baru untuk menampilkan status terpilih atau tidak terpilih -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hasilAkhir as $index => $row)
                        <tr class="text-center">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row['nama_pendonor'] }}</td>
                            <td>{{ number_format($row['nilai_moora'], 5) }}</td>
                            <td>
                                @if ($row['terpilih'])
                                    <span class="badge text-white p-2 bg-primary">Terpilih</span>
                                @else
                                    <span class="badge text-white p-2 bg-danger">Tidak Terpilih</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // JavaScript to submit the form when jumlah_terpilih changes
        document.getElementById('jumlah_terpilih').addEventListener('change', function() {
            document.getElementById('jumlahTerpilihForm').submit();
        });
    </script>

@endsection

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Your Website</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        @if (Route::has('login'))
          @auth
            @if (auth()->user()->roles != 'admin')
              <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
              </li>
            @else
              <li class="nav-item">
                <a href="{{ url('/home') }}" class="nav-link">Home</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
              </li>
            @endif
          @else
            <li class="nav-item">
              <a href="{{ route('login') }}" class="nav-link">Log in</a>
            </li>
            @if (Route::has('register'))
              <li class="nav-item">
                <a href="{{ route('register') }}" class="nav-link">Register</a>
              </li>
            @endif
          @endauth
        @endif
      </ul>
    </div>
  </div>
</nav>

@auth
    
<div class="container mt-5">
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
              <th>Tanggal Pemeriksaan</th>
            </tr>
          </thead>
          <tbody>
            @php
            $no = 1;
            @endphp

            @if ($riwayatPemeriksaan->isNotEmpty())
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $user->name }}</td>
              @foreach ($kriterias as $kriteria)
              @php
              $nilai = $riwayatPemeriksaan->firstWhere('kriteria_id', $kriteria->id)->nilai ?? '-';
              $tanggal = $riwayatPemeriksaan->firstWhere('kriteria_id', $kriteria->id)->created_at ?? '-';
              if ($kriteria->nama == 'Riwayat Penyakit') {
              $nilai = $nilai == 0 ? 'Iya' : 'Tidak';
              }
              if ($kriteria->nama == 'Lamanya Terakhir Tidur') {
              $nilai = $nilai . ' jam';
              }
              if ($kriteria->nama == 'Tidak Konsumsi Obat') {
              $nilai = $nilai . ' hari';
              }
              @endphp
              <td>{{ $nilai }}</td>
              @endforeach
              <td>{{ $tanggal != '-' ? $tanggal->format('d-m-Y') : '-' }}</td>
            </tr>
            @else
            <tr>
              <td colspan="{{ count($kriterias) + 3 }}" class="text-center">Tidak ada data pemeriksaan.</td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endauth

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

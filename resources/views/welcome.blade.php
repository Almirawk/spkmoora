@if (!Auth::check())
    @extends('layouts.app')

    @section('content')
        <div class="container"
            style="background-color: #F44336; height: 100vh; display: flex; justify-content: center; align-items: center;">
            <div
                style="background-color: white; padding: 30px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
                <div style="text-align: center; margin-bottom: 20px;">

                    <img src="{{ asset('template/img/Logo_PMI.png') }}" alt="" style="width: 100px;">
                </div>
                <h2 style="text-align: center; margin-bottom: 20px;">Selamat Datang</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Remember Me</label>
                    </div>
                    <button type="submit" class="btn btn-primary"
                        style="background-color: #F44336; border: none; width: 100%; padding: 10px; border-radius: 5px;">Login</button>
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">Forgot Your Password?</a>
                    @endif
                </form>
            </div>
        </div>
    @endsection
@else
    @section('content')
    <div class="container mt-5">
      <div class="card shadow mb-4">
          <div class="card-body">
              <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                          <tr class="text-center">
                              <th>No</th>
                              <th>Nama Pendonor</th>
                              <th>Nama Event</th>
                              <th>Nilai</th>
                              <th>Hasil</th>
                              <th>Tanggal Pemeriksaan</th>
                              <th>Status</th>
                          </tr>
                      </thead>
                      <tbody>
                        @php
                            $no = 1;
                        @endphp

                        @if ($hasilPerhitungan->isNotEmpty())
                            @foreach ($hasilPerhitungan as $hasil)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $hasil->pendonor->user->name }}</td>
                                    <td>{{ $hasil->event_name }}</td>
                                    <td>{{ number_format($hasil->hasil, 5) }}</td>
                                    <td>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Kriteria</th>
                                                    <th>Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach (json_decode($hasil->kriteria_nilai, true) as $kriteria)
                                                    <tr>
                                                        <td>{{ $kriteria['nama'] }}</td>
                                                        <td>{{ $kriteria['nilai'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($hasil->created_at)->format('d-m-Y') }}</td>
                                    <td>
                                        <span class="badge {{ $hasil->status ? 'bg-primary' : 'bg-danger' }}">
                                            {{ $hasil->status ? 'Terpilih' : 'Tidak Terpilih' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data pemeriksaan.</td>
                            </tr>
                        @endif
                    </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>
    @endsection


@endif

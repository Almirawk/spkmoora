@extends('layouts.app')

@section('content')
<style>
    .logo-uaa {
    height: 70px; /* Adjust this height to match the PMI logo */
    width: auto;
    margin-left: 20px; /* Optional: Add some space between the two logos */
}
</style>
<div class="container" style="background-color: #F44336; height: 100vh; display: flex; justify-content: center; align-items: center;">
    <div style="background-color: white; padding: 30px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); width: 800px; display: flex; flex-direction: column; align-items: center; box-sizing: border-box;">
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="{{ asset('template/img/Logo_PMI.png') }}" alt="Logo PMI" style="width: 100px;">
            <img src="{{ asset('template/img/AlmaAta Logo.png') }}" alt="" class="logo-uaa">
        </div>
        <h2 style="text-align: center; margin-bottom: 20px;">Registrasi</h2>
        <form method="POST" action="{{ route('register') }}" style="width: 100%;">
            @csrf
            <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                <div style="flex: 0 0 48%;">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">Confirm Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>
                <div style="flex: 0 0 48%;">
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input id="alamat" type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" value="{{ old('alamat') }}" required autocomplete="alamat">
                        @error('alamat')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input id="tanggal_lahir" type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tgl_lahir" value="{{ old('tanggal_lahir') }}" required autocomplete="tanggal_lahir">
                        @error('tanggal_lahir')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select id="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror" name="jns_kelamin" required>
                            <option value="L">{{ __('Laki-laki') }}</option>
                            <option value="P">{{ __('Perempuan') }}</option>
                        </select>
                        @error('jenis_kelamin')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="no_telepon">No Telepon</label>
                        <input id="no_telepon" type="text" class="form-control @error('no_telepon') is-invalid @enderror" name="no_telepon" value="{{ old('no_telepon') }}" required autocomplete="no_telepon">
                        @error('no_telepon')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="golongan_darah">Golongan Darah (Optional)</label>
                        <input id="golongan_darah" type="text" class="form-control @error('golongan_darah') is-invalid @enderror" name="golongan_darah">
                        @error('golongan_darah')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="background-color: #F44336; border: none; width: 100%; padding: 10px; border-radius: 5px; margin-top: 20px;">Register</button>
        </form>
    </div>
</div>
@endsection

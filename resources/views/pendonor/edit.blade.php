<!-- resources/views/pendonor/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header">{{ __('Edit Profil Pendonor') }}</div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('profil.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">{{ __('Nama') }}</label>
                        <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}"
                            required autocomplete="name" autofocus>
                    </div>

                    <div class="form-group">
                        <label for="email">{{ __('Email') }}</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}"
                            required autocomplete="email">
                    </div>

                    <div class="form-group">
                        <label for="alamat">{{ __('Alamat') }}</label>
                        <textarea id="alamat" class="form-control" name="alamat" rows="3">{{ $user->pendonor->alamat ?? '' }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="tgl_lahir">{{ __('Tanggal Lahir') }}</label>
                        <input id="tgl_lahir" type="date" class="form-control" name="tgl_lahir"
                            value="{{ $user->pendonor->tgl_lahir ?? '' }}">
                    </div>

                    <div class="form-group">
                        <label for="jns_kelamin">{{ __('Jenis Kelamin') }}</label>
                        <select id="jns_kelamin" class="form-control" name="jns_kelamin">
                            <option value="L" {{ $user->pendonor->jns_kelamin == 'L' ? 'selected' : '' }}>Laki-laki
                            </option>
                            <option value="L" {{ $user->pendonor->jns_kelamin == 'P' ? 'selected' : '' }}>Perempuan
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="no_telepon">{{ __('Nomor Telepon') }}</label>
                        <input id="no_telepon" type="text" class="form-control" name="no_telepon"
                            value="{{ $user->pendonor->no_telepon ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="golongan_darah">{{ __('Golongan Darah') }}</label>
                        <select id="golongan_darah" class="form-control" name="golongan_darah">
                            <option value="A" {{ $user->pendonor->golongan_darah == 'A' ? 'selected' : '' }}>A
                            </option>
                            <option value="B" {{ $user->pendonor->golongan_darah == 'B' ? 'selected' : '' }}>B
                            </option>
                            <option value="AB" {{ $user->pendonor->golongan_darah == 'AB' ? 'selected' : '' }}>AB
                            </option>
                            <option value="O" {{ $user->pendonor->golongan_darah == 'O' ? 'selected' : '' }}>O
                            </option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('Simpan Perubahan') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection

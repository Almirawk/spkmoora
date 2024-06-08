@extends('layout.app')
@section('title', 'Dashboard')
@section('content')

<style>
    .content {
        flex-grow: 1;
        padding: 20px;
    }
    .card {
        margin: 10px 0;
    }
    .card-body {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .icon i {
        color: rgba(0, 0, 0, 0.15);
    }
    .footer {
        margin-top: auto;
        padding: 20px 0;
        text-align: center;
    }
</style>

<div class="content">
    <h1 class="h3 mb-2 text-gray-800">Dashboard</h1>

    <!-- Page Content -->
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="card border-left-danger shadow">
                <div class="card-body">
                    <div>
                        <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Pendonor</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $jumlah_pendonor }}</span>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="card border-left-success shadow">
                <div class="card-body">
                    <div>
                        <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Kriteria</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $jumlah_kriteria }}</span>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="card border-left-info shadow">
                <div class="card-body">
                    <div>
                        <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Pemeriksaan</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $jumlah_pemeriksaan }}</span>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="card border-left-info shadow">
                <div class="card-body">
                    <div>
                        <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Hasil</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $jumlah_hasil }}</span>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

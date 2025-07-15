@extends('backend.layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-5 text-center display-5">Dashboard</h2>

    <!-- Ringkasan Dashboard -->
    <div class="row justify-content-center g-4 mb-5">
        <!-- Kamar Terisi -->
        <div class="col-lg-4 col-md-6">
            <div class="card bg-primary text-white shadow text-center py-4">
                <div class="card-body">
                    <h4 class="mb-3 fw-semibold">Kamar Terisi</h4>
                    <h1 class="display-4 fw-bold">{{ $kamarTerisi }} / {{ $totalKamar }}</h1>
                    <p class="mb-0">{{ $kamarTersedia }} kamar tersedia</p>
                </div>
            </div>
        </div>

        <!-- Check-out Hari Ini -->
        <div class="col-lg-4 col-md-6">
            <div class="card bg-warning text-dark shadow text-center py-4">
                <div class="card-body">
                    <h4 class="mb-3 fw-semibold">Check-out Hari Ini</h4>
                    <h1 class="display-4 fw-bold">{{ $checkOutHariIni->count() }}</h1>
                    <p class="mb-0">Pemesanan</p>
                </div>
            </div>
        </div>

        <!-- Total Tamu Menginap -->
        <div class="col-lg-4 col-md-6">
            <div class="card bg-dark text-white shadow text-center py-4">
                <div class="card-body">
                    <h4 class="mb-3 fw-semibold">Total Tamu Menginap</h4>
                    <h1 class="display-4 fw-bold">{{ $tamuMenginap->sum('jumlah_tamu') }}</h1>
                    <p class="mb-0">Dalam {{ $tamuMenginap->count() }} pemesanan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Tamu Menginap -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light fw-bold fs-5">
                    Tamu yang Sedang Menginap
                </div>
                <div class="card-body p-0">
                    @forelse ($tamuMenginap as $tamu)
                        <div class="d-flex justify-content-between align-items-start p-4 border-bottom">
                            <div>
                                <h6 class="text-capitalize fw-semibold">{{ $tamu->nama_tamu }}</h6>
                                <small class="text-muted d-block">
                                    Dari: {{ \Carbon\Carbon::parse($tamu->tanggal_checkin)->format('d M Y H:i') }} WIB<br>
                                    Sampai: {{ \Carbon\Carbon::parse($tamu->tanggal_checkout)->format('d M Y H:i') }} WIB
                                </small>
                            </div>
                            <span class="badge rounded-pill text-bg-primary px-3 py-2 fs-6">
                                Kamar {{ $tamu->kamar->nomor_kamar ?? '-' }}
                            </span>
                        </div>
                    @empty
                        <div class="p-4 text-center text-muted">
                            Tidak ada tamu yang sedang menginap.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('backend.layouts.app')

@push('styles')
<!-- Google Font Inter -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Inter', sans-serif;
        font-size: 15px;
        color: #333;
    }

    h5, .fw-bold {
        font-size: 1.6rem;
        font-weight: 600;
    }

    .table th, .table td {
        font-size: 14px;
        vertical-align: middle;
    }

    .btn {
        font-size: 14px;
        font-weight: 500;
    }

    .form-control,
    .form-select,
    .nav-link {
        font-size: 14px;
    }

    .table-hover tbody tr:hover {
        background-color: #f9f9f9;
    }
</style>
@endpush

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        {{-- Bagian Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-bold text-dark mb-1">{{ $judul ?? 'Manajemen Pemesanan' }}</h5>
                <p class="text-muted mb-0">Lihat dan kelola semua pemesanan hotel.</p>
            </div>
            <a href="{{ route('backend.pemesanan.create') }}" class="btn btn-primary fw-medium">
                <i class="bi bi-plus-circle me-2"></i> Buat Pemesanan
            </a>
        </div>

        {{-- Bagian Filter & Pencarian --}}
        <div class="row align-items-center mb-3">
            <div class="col-md-4 ms-auto">
                <form method="GET" action="{{ route('backend.pemesanan.index') }}">
                    <input type="hidden" name="status" value="{{ request('status') }}">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama tamu..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit" aria-label="Cari">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Bagian Navigasi Tab Status --}}
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a @class(['nav-link', 'active' => !request('status')]) href="{{ route('backend.pemesanan.index', ['search' => request('search')]) }}">
                    Semua
                </a>
            </li>
            @foreach(['checkin' => 'Check-In', 'selesai' => 'Selesai'] as $key => $label)
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => request('status') == $key]) href="{{ route('backend.pemesanan.index', ['status' => $key, 'search' => request('search')]) }}">
                        {{ $label }}
                    </a>
                </li>
            @endforeach
        </ul>

        {{-- Tabel Data Pemesanan --}}
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Tamu</th>
                        <th scope="col">Kamar</th>
                        <th scope="col">Jadwal Menginap</th>
                        <th scope="col">Total Harga</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pemesanan as $pesan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="fw-medium">{{ $pesan->nama_tamu }}</div>
                            <small class="text-muted">{{ $pesan->telepon }}</small>
                        </td>
                        <td>
                            @if($pesan->kamar)
                                <div class="fw-medium">No. {{ $pesan->kamar->nomor_kamar }}</div>
                                <small class="text-muted">{{ $pesan->kamar->tipe }}</small>
                            @else
                                <span class="text-danger small">Kamar Dihapus</span>
                            @endif
                        </td>
                        <td>
                            <div class="fw-medium">{{ $pesan->tanggal_checkin->format('d M Y') }} - {{ $pesan->tanggal_checkout->format('d M Y') }}</div>
                            <small class="text-muted">Pukul {{ $pesan->tanggal_checkin->format('H:i') }} s/d {{ $pesan->tanggal_checkout->format('H:i') }}</small>
                        </td>
                        <td>Rp{{ number_format($pesan->total_harga, 0, ',', '.') }}</td>
                        <td>{{ Str::of($pesan->status)->replace('_', ' ')->title() }}</td>
                        <td class="text-center">
                            <a href="{{ route('backend.pemesanan.edit', $pesan->id) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Edit Pemesanan">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('backend.pemesanan.destroy', $pesan->id) }}" class="d-inline form-hapus">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Hapus Pemesanan">
                                    <i class="bi bi-trash3-fill"></i> Hapus
                                </button>
                            </form>
                            <button class="btn btn-sm btn-info mt-1" type="button" data-bs-toggle="collapse" data-bs-target="#detail-{{ $pesan->id }}">
                                <i class="bi bi-info-circle"></i> Show Detail
                            </button>
                        </td>
                    </tr>
                    <tr class="collapse bg-light" id="detail-{{ $pesan->id }}">
                        <td colspan="7">
                            <strong>Jumlah Tamu:</strong> {{ $pesan->jumlah_tamu ?? '-' }} <br>
                            <strong>Catatan:</strong> {{ $pesan->catatan ?? '-' }} <br>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Tidak ada data pemesanan yang cocok.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el))

        const deleteForms = document.querySelectorAll('.form-hapus');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Anda Yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush
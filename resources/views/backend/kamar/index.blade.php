@extends('backend.layouts.app')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold text-dark mb-1">{{ $judul }}</h5>
                <p class="text-muted mb-0">Kelola semua data kamar yang tersedia di sistem Anda.</p>
            </div>
            <a href="{{ route('backend.kamar.create') }}" class="btn btn-primary fw-medium">
                <i class="bi bi-plus-circle me-2"></i> Tambah Kamar
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nomor Kamar</th>
                        <th scope="col">Tipe</th>
                        <th scope="col">Harga / Malam</th>
                        <th scope="col">Kapasitas</th>
                        <th scope="col">Fasilitas</th><th scope="col">Status</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($index as $kamar)
                    <tr class="align-middle">
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-medium">{{ $kamar->nomor_kamar }}</td>
                        <td>{{ $kamar->tipe }}</td>
                        <td>Rp {{ number_format($kamar->harga_per_malam, 0, ',', '.') }}</td>
                        <td>{{ $kamar->kapasitas }} Orang</td>
                        <td>{{ $kamar->fasilitas }}</td> <td>
                        @if ($kamar->status_otomatis == 'Tersedia')
                        <span class="badge text-bg-success">Tersedia</span>
                        @else
                        <span class="badge text-bg-danger">Terisi</span>
                        @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('backend.kamar.edit', $kamar->id) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Edit Kamar">
                                <i class="bi bi-pencil-square"> Edit</i>
                            </a>

                            <form method="POST" class="form-hapus" action="{{ route('backend.kamar.destroy', $kamar->id) }}" style="display: inline-block;" class="form-hapus">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Hapus Kamar">
                                    <i class="bi bi-trash3-fill"> Hapus</i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            Belum ada data kamar.
                        </td>
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
    // 1. Mengaktifkan Tooltip Bootstrap
    // Ini akan menampilkan tulisan "Edit Kamar" atau "Hapus Kamar" saat ikon di-hover
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    // 2. Mengaktifkan Konfirmasi Hapus dengan SweetAlert2
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('.form-hapus');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Mencegah form dikirim langsung

                Swal.fire({
                    title: 'Anda Yakin?',
                    text: "Data kamar yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus Saja!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Jika dikonfirmasi, kirim form
                    }
                });
            });
        });
    });
</script>
@endpush
@extends('backend.layouts.app')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold text-dark mb-1">{{ $judul }}</h5>
                <p class="text-muted mb-0">Kelola pengguna sistem dan hak akses mereka.</p>
            </div>
            <a href="{{ route('backend.user.create') }}" class="btn btn-primary fw-medium">
                <i class="bi bi-plus-circle me-2"></i> Tambah Pengguna
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Email</th>
                        <th scope="col">Peran</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($index as $user)
                    <tr class="align-middle">
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->nama) }}&background=random&color=fff" alt="Avatar" class="rounded-circle me-2" width="32" height="32">
                            <span class="fw-medium">{{ $user->nama }}</span>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if ($user->role == 'admin')
                            <span class="badge text-bg-primary">Admin</span>
                            @elseif ($user->role == 'resepsionis')
                            <span class="badge text-bg-info">Resepsionis</span>
                            @endif
                        </td>
                        <td>
                            @if ($user->status == 1)
                            <span class="badge text-bg-success">Aktif</span>
                            @else
                            <span class="badge text-bg-danger">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('backend.user.edit', $user->id) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Edit Pengguna">
                                <i class="bi bi-pencil-square"> Edit</i>
                            </a>

                            <form method="POST" action="{{ route('backend.user.destroy', $user->id) }}" style="display: inline-block;" class="form-hapus">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Hapus Pengguna">
                                    <i class="bi bi-trash3-fill"> Hapus</i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            Belum ada data pengguna.
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
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    // 2. Mengaktifkan Konfirmasi Hapus dengan SweetAlert2
    // Script ini sama dengan yang kita gunakan di modul kamar, membuatnya konsisten
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('.form-hapus');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Mencegah form dikirim langsung

                Swal.fire({
                    title: 'Anda Yakin?',
                    text: "Data pengguna yang dihapus tidak dapat dikembalikan!",
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
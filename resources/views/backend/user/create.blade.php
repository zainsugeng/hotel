@extends('backend.layouts.app')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h5 class="fw-bold mb-1">{{$judul}}</h5>
        <p class="text-muted mb-4">Masukkan detail untuk pengguna baru.</p>

        <form action="{{ route('backend.user.store') }}" method="POST">
            @csrf
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label for="nama" class="form-label fw-medium">Nama</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                        class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan Nama Lengkap">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label fw-medium">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror" placeholder="contoh@email.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="role" class="form-label fw-medium">Peran</label>
                    <select name="role" id="role" class="form-select @error('role') is-invalid @enderror">
                        <option value="">--Pilih Peran--</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="resepsionis" {{ old('role') == 'resepsionis' ? 'selected' : '' }}>Resepsionis</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label fw-medium">Status</label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="">--Pilih Status--</option>
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="hp" class="form-label fw-medium">Nomor HP</label>
                    <input type="text" name="hp" id="hp" value="{{ old('hp') }}" class="form-control @error('hp') is-invalid @enderror" placeholder="Contoh: 08123456789">
                    @error('hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6"></div> <div class="col-md-6 mb-3">
                    <label for="password" class="form-label fw-medium">Password</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan Password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password_confirmation" class="form-label fw-medium">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Konfirmasi Password">
                </div>

            </div>

            <div class="border-top pt-3 mt-3">
                <a href="{{ route('backend.user.index') }}" class="btn btn-outline-secondary">
                    Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i> Simpan Pengguna
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
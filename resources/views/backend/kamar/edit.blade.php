@extends('backend.layouts.app')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h5 class="fw-bold mb-1">{{ $judul }}</h5>
        <p class="text-muted mb-4">Perbarui detail untuk kamar nomor <strong>{{ $edit->nomor_kamar }}</strong>.</p>

        <form action="{{ route('backend.kamar.update', $edit->id) }}" method="POST">
            @method('put')
            @csrf
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label for="nomor_kamar" class="form-label fw-medium">Nomor Kamar</label>
                    <input type="text" name="nomor_kamar" id="nomor_kamar" value="{{ old('nomor_kamar', $edit->nomor_kamar) }}"
                        class="form-control @error('nomor_kamar') is-invalid @enderror" placeholder="Masukkan Nomor Kamar">
                    @error('nomor_kamar')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tipe" class="form-label fw-medium">Tipe Kamar</label>
                    <select name="tipe" id="tipe" class="form-select @error('tipe') is-invalid @enderror">
                        <option value="">--Pilih Tipe--</option>
                        <option value="Standar" {{ old('tipe', $edit->tipe) == 'Standar' ? 'selected' : '' }}>Standar</option>
                        <option value="Deluxe" {{ old('tipe', $edit->tipe) == 'Deluxe' ? 'selected' : '' }}>Deluxe</option>
                        <option value="Suite" {{ old('tipe', $edit->tipe) == 'Suite' ? 'selected' : '' }}>Suite</option>
                    </select>
                    @error('tipe')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="harga_per_malam" class="form-label fw-medium">Harga per Malam</label>
                    <input type="number" name="harga_per_malam" id="harga_per_malam" value="{{ old('harga_per_malam', $edit->harga_per_malam) }}"
                        class="form-control @error('harga_per_malam') is-invalid @enderror" placeholder="Contoh: 500000">
                    @error('harga_per_malam')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="kapasitas" class="form-label fw-medium">Kapasitas (Orang)</label>
                    <input type="number" name="kapasitas" id="kapasitas" value="{{ old('kapasitas', $edit->kapasitas) }}"
                        class="form-control @error('kapasitas') is-invalid @enderror" placeholder="Contoh: 2">
                    @error('kapasitas')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="fasilitas" class="form-label fw-medium">Fasilitas</label>
                    <textarea name="fasilitas" id="fasilitas" class="form-control @error('fasilitas') is-invalid @enderror" rows="4" placeholder="Contoh: AC, TV, Wi-Fi, Sarapan">{{ old('fasilitas', $edit->fasilitas) }}</textarea>
                    @error('fasilitas')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="border-top pt-3 mt-3">
                <a href="{{ route('backend.kamar.index') }}" class="btn btn-outline-secondary">
                    Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i> Perbaharui Kamar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

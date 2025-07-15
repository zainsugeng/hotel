@extends('backend.layouts.app')
@section('content')

<!-- contentAwal -->
<div class="card">
    <div class="card-body">
        <div class="">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-semibold text-dark mb-0">{{ $judul }}</h5>
                    <p>Masukkan detail untuk kamar baru</p>
                </div>
            </div>

            <form action="{{ route('backend.kamar.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-medium">Nomor Kamar</label>
                        <input type="text" name="nomor_kamar" value="{{ old('nomor_kamar') }}"
                            class="form-control @error('nomor_kamar') is-invalid @enderror" placeholder="Masukkan Nomor Kamar">
                        @error('nomor_kamar')
                        <span class="invalid-feedback alert-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="fw-medium">Tipe Kamar</label>
                        <select name="tipe" class="form-select @error('tipe') is-invalid @enderror">
                            <option value="">--Pilih Tipe--</option>
                            <option value="Standar" {{ old('tipe') == 'Standar' ? 'selected' : '' }}>Standar</option>
                            <option value="Deluxe" {{ old('tipe') == 'Deluxe' ? 'selected' : '' }}>Deluxe</option>
                            <option value="Suite" {{ old('tipe') == 'Suite' ? 'selected' : '' }}>Suite</option>
                        </select>
                        @error('tipe')
                        <span class="invalid-feedback alert-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Harga</label>
                        <input type="number" name="harga_per_malam" value="{{ old('harga_per_malam') }}"
                            class="form-control @error('harga_per_malam') is-invalid @enderror" placeholder="Masukkan harga">
                        @error('harga_per_malam')
                        <span class="invalid-feedback alert-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Kapasitas</label>
                        <input type="number" name="kapasitas" value="{{ old('kapasitas') }}"
                            class="form-control @error('kapasitas') is-invalid @enderror" placeholder="Jumlah orang">
                        @error('kapasitas')
                        <span class="invalid-feedback alert-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Fasilitas</label>
                        <textarea name="fasilitas" class="form-control @error('fasilitas') is-invalid @enderror" rows="4">{{ old('fasilitas') }}</textarea>
                        @error('fasilitas')
                        <span class="invalid-feedback alert-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="border-top pt-3">
                    <div class="text-end">
                        <a href="{{ route('backend.kamar.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@extends('backend.layouts.app')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h5 class="fw-bold mb-1">{{ $judul }}</h5>
        <p class="text-muted mb-4">Perbarui detail pemesanan untuk tamu <strong>{{ $pemesanan->nama_tamu }}</strong></p>

        <form action="{{ route('backend.pemesanan.update', $pemesanan->id) }}" method="POST">
            @method('put')
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama_tamu" class="form-label fw-medium">Nama Tamu</label>
                    <input type="text" name="nama_tamu" id="nama_tamu" class="form-control @error('nama_tamu') is-invalid @enderror" value="{{ old('nama_tamu', $pemesanan->nama_tamu) }}" required>
                    @error('nama_tamu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="telepon" class="form-label fw-medium">Nomor Telepon</label>
                    <input type="text" name="telepon" id="telepon" class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon', $pemesanan->telepon) }}" required>
                    @error('telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label for="kamar_id" class="form-label fw-medium">Pilih Kamar</label>
                    <select name="kamar_id" id="kamar_id" class="form-select @error('kamar_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kamar --</option>
                        @foreach($kamarList as $kamar)
                        <option value="{{ $kamar->id }}" {{ old('kamar_id', $pemesanan->kamar_id) == $kamar->id ? 'selected' : '' }}>
                            No. {{ $kamar->nomor_kamar }} - {{ $kamar->tipe }} (Rp {{ number_format($kamar->harga_per_malam, 0, ',', '.') }})
                        </option>
                        @endforeach
                    </select>
                    @error('kamar_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tanggal_checkin" class="form-label fw-medium">Tanggal & Waktu Check-in</label>
                    <input type="datetime-local" name="tanggal_checkin" id="tanggal_checkin" class="form-control @error('tanggal_checkin') is-invalid @enderror" value="{{ old('tanggal_checkin', $pemesanan->tanggal_checkin->format('Y-m-d\TH:i')) }}" required>
                    @error('tanggal_checkin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tanggal_checkout" class="form-label fw-medium">Tanggal & Waktu Check-out</label>
                    <input type="datetime-local" name="tanggal_checkout" id="tanggal_checkout" class="form-control @error('tanggal_checkout') is-invalid @enderror" value="{{ old('tanggal_checkout', $pemesanan->tanggal_checkout->format('Y-m-d\TH:i')) }}" required>
                    @error('tanggal_checkout')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="jumlah_tamu" class="form-label fw-medium">Jumlah Tamu</label>
                    <input type="number" name="jumlah_tamu" id="jumlah_tamu" class="form-control @error('jumlah_tamu') is-invalid @enderror" value="{{ old('jumlah_tamu', $pemesanan->jumlah_tamu) }}" min="1" required>
                    @error('jumlah_tamu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label fw-medium">Status</label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        @foreach(['Check In', 'Selesai'] as $status)
                        <option value="{{ $status }}" {{ old('status', $pemesanan->status) == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-12 mb-3">
                    <label for="catatan" class="form-label fw-medium">Catatan (Opsional)</label>
                    <textarea name="catatan" id="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="3">{{ old('catatan', $pemesanan->catatan) }}</textarea>
                    @error('catatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="pt-3 border-top mt-3">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i> Simpan Perubahan</button>
                <a href="{{ route('backend.pemesanan.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
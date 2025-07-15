<?php

namespace App\Http\Controllers; // Sesuaikan jika Anda menaruhnya di folder Backend

use App\Models\Kamar;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KamarController extends Controller
{
    public function index()
{
    $today = now()->toDateString(); // atau Carbon::today()->toDateString();

    // Ambil semua kamar dan cek status otomatis
    $kamar = Kamar::orderBy('created_at', 'asc')->get()->map(function ($kamar) use ($today) {
        $isTerisi = \App\Models\Pemesanan::where('kamar_id', $kamar->id)
            ->where('status', '!=', 'Dibatalkan')
            ->whereDate('tanggal_checkin', '<=', $today)
            ->whereDate('tanggal_checkout', '>=', $today)
            ->exists();

        // Tambahkan properti dinamis untuk status
        $kamar->status_otomatis = $isTerisi ? 'Terisi' : 'Tersedia';
        return $kamar;
    });

    return view('backend.kamar.index', [
        'judul' => 'Manajemen Kamar',
        'index' => $kamar
    ]);
}

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nomor_kamar' => 'required|unique:kamar,nomor_kamar',
            'tipe' => 'required',
            'harga_per_malam' => 'required|numeric',
            'kapasitas' => 'required|numeric',
            'fasilitas' => 'required',
        ]);

        Kamar::create($validatedData);
        return redirect()->route('backend.kamar.index')->with('success', 'Data berhasil tersimpan');
    }

    public function show(Kamar $kamar)
    {
        // Biasanya tidak digunakan di admin panel, bisa dikosongkan
    }

    /**
     * REVISI: Menggunakan Route Model Binding (Kamar $kamar)
     * Laravel otomatis mencari data kamar berdasarkan ID di URL.
     */
    public function edit(Kamar $kamar)
    {
        return view('backend.kamar.edit', [
            'judul' => 'Ubah Kamar',
            'edit' => $kamar
        ]);
    }

    /**
     * REVISI TOTAL: Fungsi update yang sudah benar
     */
    public function update(Request $request, Kamar $kamar)
    {

        $rules = [
            'nomor_kamar' => [
                'required',
                'string',
                Rule::unique('kamar')->ignore($kamar->id),
            ],
            'tipe' => 'required',
            'harga_per_malam' => 'required|numeric|min:0', // <-- PERBAIKAN UTAMA
            'kapasitas' => 'required|numeric|min:1',
            'fasilitas' => 'required|string',
        ];

        $validatedData = $request->validate($rules);

        $kamar->update($validatedData);

        return redirect()->route('backend.kamar.index')->with('success', 'Data kamar berhasil diperbaharui!');
    }

    public function destroy(Kamar $kamar)
    {
        $kamar->delete();
        return redirect()->route('backend.kamar.index')->with('success', 'Data kamar berhasil dihapus');
    }
    public function create()
{
    return view('backend.kamar.create', [
        'judul' => 'Tambah Kamar Baru',
    ]);
}
}

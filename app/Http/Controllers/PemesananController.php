<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Kamar;
use Carbon\Carbon;


class PemesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $query = Pemesanan::with(['user', 'kamar'])->latest();

        // Logika filter menjadi sangat bersih dengan memanggil Query Scope dari Model
        if ($request->status == 'akan_datang') $query->akanDatang();
        if ($request->status == 'checkin') $query->checkIn();
        if ($request->status == 'selesai') $query->selesai();
        if ($request->status == 'dibatalkan') $query->dibatalkan();
        
        if ($request->filled('search')) {
            $query->where('nama_tamu', 'like', '%' . $request->search . '%')
                  ->orWhereHas('kamar', function($q) use ($request) {
                      $q->where('nomor_kamar', 'like', '%' . $request->search . '%');
                  });
        }

        $pemesanan = $query->paginate(); 

        return view('backend.pemesanan.index', [
            'judul' => 'Manajemen Pemesanan',
            'pemesanan' => $pemesanan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kamarTersedia = Kamar::where('status', 'tersedia')->orderBy('nomor_kamar')->get();
        return view('backend.pemesanan.create', [
            'judul' => 'Pemesanan Baru',
            'kamarList' => $kamarTersedia
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validateRequest($request);
        $this->createOrUpdatePemesanan($data);
        return redirect()->route('backend.pemesanan.index')->with('success', 'Pemesanan baru berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pemesanan $pemesanan)
    {
        $kamarTersedia = Kamar::where('status', 'tersedia')->get();
        $kamarSaatIni = Kamar::find($pemesanan->kamar_id);
        
        if ($kamarSaatIni && !$kamarTersedia->contains($kamarSaatIni)) {
            $kamarList = $kamarTersedia->push($kamarSaatIni)->sortBy('nomor_kamar');
        } else {
            $kamarList = $kamarTersedia->sortBy('nomor_kamar');
        }

        return view('backend.pemesanan.edit', [
            'judul' => 'Edit Pemesanan',
            'pemesanan' => $pemesanan,
            'kamarList' => $kamarList,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pemesanan $pemesanan)
    {
        $data = $this->validateRequest($request);
        $this->createOrUpdatePemesanan($data, $pemesanan);
        return redirect()->route('backend.pemesanan.index')->with('success', 'Pemesanan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pemesanan $pemesanan)
    {
        $pemesanan->delete();
        return redirect()->route('backend.pemesanan.index')->with('success', 'Pemesanan berhasil dihapus.');
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'kamar_id' => 'required|exists:kamar,id',
            'nama_tamu' => 'required|string|max:255',
            'telepon' => 'required|string|max:25',
            'email' => 'nullable|email',
            'tanggal_checkin' => 'required|date',
            'tanggal_checkout' => 'required|date|after_or_equal:tanggal_checkin',
            'jumlah_tamu' => 'required|integer|min:1',
            'status' => 'required|string',
            'metode_pemesanan' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);
    }

    private function createOrUpdatePemesanan(array $data, ?Pemesanan $pemesanan = null)
    {
        $kamar = Kamar::find($data['kamar_id']);
        $checkin = Carbon::parse($data['tanggal_checkin']);
        $checkout = Carbon::parse($data['tanggal_checkout']);
        $jumlahHari = max(1, $checkin->diffInDays($checkout));
        
        $data['total_harga'] = $jumlahHari * $kamar->harga_per_malam;
        $data['user_id'] = auth()->id();

        if ($pemesanan) {
            $pemesanan->update($data);
        } else {
            Pemesanan::create($data);
        }
    }
}

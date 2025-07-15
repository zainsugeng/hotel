<?php

namespace App\Http\Controllers; // Atau App\Http\Controllers\Backend

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Kamar;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $totalKamar = Kamar::count();

        // Tamu yang sedang menginap (status bukan dibatalkan)
        $tamuMenginap = Pemesanan::where('status', 'Check In')
            ->whereDate('tanggal_checkin', '<=', $today)
            ->whereDate('tanggal_checkout', '>=', $today)
            ->get();

        // Hitung kamar yang sedang terisi
        $kamarTerisi = $tamuMenginap->pluck('kamar_id')->unique()->count();

        // Hitung kamar yang tersedia
        $kamarTersedia = $totalKamar - $kamarTerisi;

        // Data check-in hari ini
        $checkInHariIni = Pemesanan::with('kamar') // <-- PERBAIKAN PERFORMA
            ->whereDate('tanggal_checkin', $today)
            ->where('status', '!=', 'Dibatalkan')
            ->get();

        // Data check-out hari ini
        $checkOutHariIni = Pemesanan::with('kamar') // <-- PERBAIKAN PERFORMA
            ->whereDate('tanggal_checkout', $today)
            ->where('status', '!=', 'Dibatalkan')
            ->get();

        // Daftar check-in mendatang
        $akanDatang = Pemesanan::with('kamar') // <-- PERBAIKAN PERFORMA
            ->whereDate('tanggal_checkin', '>', $today)
            ->where('status', 'Dipesan') // Status lebih spesifik
            ->orderBy('tanggal_checkin', 'asc')
            ->get();
            
        return view('backend.dashboard.index', compact(
            'totalKamar',
            'kamarTerisi',
            'kamarTersedia', // Anda bisa gunakan ini jika mau
            'checkInHariIni',
            'checkOutHariIni',
            'tamuMenginap',
            'akanDatang',
        ));
    }
}
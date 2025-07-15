<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';

    protected $fillable = [
        'user_id',
        'kamar_id',
        'nama_tamu',
        'telepon',
        'email',
        'tanggal_checkin',
        'tanggal_checkout',
        'jumlah_tamu',
        'total_harga',
        'status',
        'metode_pemesanan',
        'catatan',
    ];

    protected $casts = [
        'tanggal_checkin' => 'datetime',
        'tanggal_checkout' => 'datetime',
    ];

    // Relasi ke model lain
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    // Accessor untuk status dinamis
    public function getStatusDinamisAttribute()
    {
        // PRIORITAS 1: Cek status manual yang sudah pasti dan tidak perlu dihitung ulang.
        // strcasecmp() digunakan agar tidak case-sensitive (misal: 'selesai' vs 'Selesai')
        if (strcasecmp($this->status, 'Selesai') == 0) {
            return 'Selesai';
        }
        if (strcasecmp($this->status, 'Dibatalkan') == 0) {
            return 'Dibatalkan';
        }
        if (strcasecmp($this->status, 'Check In') == 0) {
            // Ganti "Check In" menjadi "Sedang Check-in" agar lebih deskriptif di tampilan
            return 'Sedang Check-in';
        }

        // PRIORITAS 2: Jika statusnya belum pasti (misal: 'Dipesan'), baru kita hitung berdasarkan tanggal.
        $sekarang = now();

        // Jika sudah lewat tanggal checkout, otomatis dianggap Selesai.
        if ($sekarang->gt($this->tanggal_checkout)) {
            return 'Selesai';
        }

        // Jika berada di antara tanggal checkin dan checkout
        if ($sekarang->between($this->tanggal_checkin, $this->tanggal_checkout)) {
            // Seharusnya sudah check-in, tapi jika status di DB masih 'Dipesan', anggap sedang berjalan
            return 'Sedang Check-in';
        }

        // Jika belum masuk tanggal checkin
        if ($sekarang->lt($this->tanggal_checkin)) {
            return 'Akan Datang';
        }

        // Fallback jika tidak ada kondisi yang cocok
        return $this->status;
    }

    // Query Scopes untuk filter di Controller
    public function scopeAkanDatang($query)
    {
        // Ambil pemesanan yang statusnya 'Dipesan' DAN tanggal checkin-nya di masa depan
        return $query->where('status', 'Dipesan')->where('tanggal_checkin', '>', now());
    }

    public function scopeCheckIn($query)
    {
        // Ambil pemesanan yang statusnya 'Check In'
        return $query->where('status', 'Check In');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'Selesai');
    }

    public function scopeDibatalkan($query)
    {
        return $query->where('status', 'Dibatalkan');
    }
}

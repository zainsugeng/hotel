<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Kamar extends Model
{
    protected $table = 'kamar'; // atau 'kamar' jika nama tabelnya tunggal
    protected $fillable = [
        'nomor_kamar',
        'tipe',
        'harga_per_malam', // pastikan ini yang dipakai, bukan 'harga'
        'status',
        'kapasitas',
        'fasilitas'
    ];
    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class);
    }
    
}

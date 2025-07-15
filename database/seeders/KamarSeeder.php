<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class KamarSeeder extends Seeder
{
    public function run(): void
    {
         // Nonaktifkan pengecekan foreign key sementara
         Schema::disableForeignKeyConstraints();
        
         // Kosongkan tabel kamar
         DB::table('kamar')->truncate();
 
         // Aktifkan kembali pengecekan foreign key
         Schema::enableForeignKeyConstraints();
 
         // Masukkan data kamar baru
         DB::table('kamar')->insert([
            [
                'nomor_kamar' => '101',
                'tipe' => 'Standar',
                'harga_per_malam' => 500000,
                'status' => 'tersedia',
                'kapasitas' => 2, // <-- DATA BARU
                'fasilitas' => 'AC, TV 24 inch, Wi-Fi', // <-- DATA BARU
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_kamar' => '102',
                'tipe' => 'Deluxe',
                'harga_per_malam' => 750000,
                'status' => 'tersedia',
                'kapasitas' => 2, // <-- DATA BARU
                'fasilitas' => 'AC, TV 32 inch, Wi-Fi, Kulkas Mini', // <-- DATA BARU
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_kamar' => '103',
                'tipe' => 'Suite',
                'harga_per_malam' => 1200000,
                'status' => 'tersedia',
                'kapasitas' => 4, // <-- DATA BARU
                'fasilitas' => 'AC, Smart TV 4K 50 inch, Wi-Fi, Kulkas', // <-- DATA BARU
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_kamar' => '201',
                'tipe' => 'Standar',
                'harga_per_malam' => 500000,
                'status' => 'tersedia',
                'kapasitas' => 2, // <-- DATA BARU
                'fasilitas' => 'AC, TV 24 inch, Wi-Fi', // <-- DATA BARU
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_kamar' => '202',
                'tipe' => 'Deluxe',
                'harga_per_malam' => 750000,
                'status' => 'tersedia',
                'kapasitas' => 2, // <-- DATA BARU
                'fasilitas' => 'AC, TV 32 inch, Wi-Fi, Kulkas Mini', // <-- DATA BARU
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_kamar' => '203',
                'tipe' => 'Suite',
                'harga_per_malam' => 1200000,
                'status' => 'tersedia',
                'kapasitas' => 4, // <-- DATA BARU
                'fasilitas' => 'AC, Smart TV 4K 50 inch, Wi-Fi, Kulkas', // <-- DATA BARU
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

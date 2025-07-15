<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Perbaikan: Sebaiknya 'User' dengan huruf kapital

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin', // Diubah dari '1' menjadi 'admin'
            'status' => '1',
            'hp' => '081234567890',
            'password' => bcrypt('123'),
        ]);

        User::create([
            'nama' => 'resepsionis',
            'email' => 'resepsionis@gmail.com',
            'role' => 'resepsionis', // Diubah dari '0' menjadi 'resepsionis'
            'status' => '1',
            'hp' => '081234567890',
            'password' => bcrypt('123'),
        ]);

        // Baris ini sudah benar, tidak perlu diubah
        $this->call(KamarSeeder::class);
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();
            // Mengasumsikan tabel user Anda bernama 'users' (plural)
            $table->foreignId('user_id')->nullable()->constrained('user')->onDelete('set null');
            $table->foreignId('kamar_id')->constrained('kamar')->onDelete('cascade');

            $table->string('nama_tamu');
            $table->string('telepon', 25);
            $table->string('email')->nullable();
            $table->dateTime('tanggal_checkin');
            $table->dateTime('tanggal_checkout');
            $table->unsignedInteger('jumlah_tamu')->default(1);
            $table->unsignedInteger('total_harga')->default(0);
            $table->string('status', 50)->default('Dipesan');
            $table->string('metode_pemesanan', 50)->default('Website');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
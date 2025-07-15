<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Pastikan nama tabel adalah 'kamar'
        Schema::table('kamar', function (Blueprint $table) {
            // Tambahkan dua baris ini untuk membuat kolom baru
            $table->integer('kapasitas')->after('status')->default(2);
            $table->text('fasilitas')->after('kapasitas')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Bagian ini untuk rollback jika diperlukan
        Schema::table('kamar', function (Blueprint $table) {
            $table->dropColumn(['kapasitas', 'fasilitas']);
        });
    }
};

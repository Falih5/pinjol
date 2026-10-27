<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspeksi_aset', function (Blueprint $table) {
            $table->id('id_inspeksi');
            $table->foreignId('id_peminjaman')->unique()->constrained('peminjaman', 'id_peminjaman')->onDelete('cascade');
            $table->dateTime('waktu_serah')->nullable();
            $table->foreignId('id_petugas_serah')->nullable()->constrained('users', 'id_user')->nullOnDelete();
            $table->enum('kondisi_baseline', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->nullable();
            $table->string('foto_baseline_url', 255)->nullable();
            $table->dateTime('waktu_kembali')->nullable();
            $table->foreignId('id_petugas_kembali')->nullable()->constrained('users', 'id_user')->nullOnDelete();
            $table->enum('kondisi_akhir', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->nullable();
            $table->string('foto_akhir_url', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspeksi_aset');
    }
};
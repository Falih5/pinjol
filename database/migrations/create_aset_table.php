<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aset', function (Blueprint $table) {
            $table->id('id_aset');
            $table->string('kode_aset', 50)->unique();
            $table->string('nama_aset', 100);
            $table->enum('kategori', ['Fasilitas', 'Barang']);
            $table->enum('kondisi_saat_ini', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik');
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aset');
    }
};
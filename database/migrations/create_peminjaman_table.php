<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id('id_peminjaman');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
            $table->foreignId('id_aset')->constrained('aset', 'id_aset')->onDelete('cascade');
            $table->timestamp('waktu_pengajuan')->useCurrent();
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai');
            $table->string('tujuan_penggunaan', 255)->nullable();
            $table->enum('status_pengajuan', ['Menunggu', 'Disetujui', 'Ditolak', 'Dipinjam', 'Selesai'])->default('Menunggu');
            $table->dateTime('batas_sla_admin')->nullable();
            $table->foreignId('id_admin_approval')->nullable()->constrained('users', 'id_user')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
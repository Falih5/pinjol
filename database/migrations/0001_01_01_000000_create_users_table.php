<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
{
    Schema::create('users', function (Blueprint $table) {
        $table->id('id_user'); // Primary Key kustom
        $table->string('identitas')->unique(); // digantikan dari email
        $table->string('nama_lengkap');
        $table->string('password');
        $table->string('role')->default('Peminjam');
        $table->string('unit_organisasi')->nullable();
        $table->boolean('is_banned')->default(false);
        $table->rememberToken();
        $table->timestamps();
    });
}
};
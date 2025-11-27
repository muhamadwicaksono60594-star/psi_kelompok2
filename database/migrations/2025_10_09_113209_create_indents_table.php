<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('indents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama');
            $table->string('asal_instansi');
            $table->string('jurusan');
            $table->string('nim_nis');
            $table->string('no_telepon');
            $table->text('alamat');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['menunggu', 'diterima', 'ditolak'])->default('menunggu');
            $table->string('berkas')->nullable(); // simpan path berkas
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indents');
    }
};
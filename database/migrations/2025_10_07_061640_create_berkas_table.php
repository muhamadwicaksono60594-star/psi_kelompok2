<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('berkas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pendaftar_id');
            $table->string('nama_file');
            $table->string('path');
            $table->string('jenis')->nullable(); // contoh: foto, dokumen, surat_pengantar
            $table->timestamps();

            // relasi ke tabel pendaftar
            $table->foreign('pendaftar_id')
                  ->references('id')
                  ->on('pendaftarans')
                  ->onDelete('cascade');
        });
    }

    /**
     * Undo migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('berkas');
    }
};

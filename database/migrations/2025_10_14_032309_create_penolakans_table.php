<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penolakans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pendaftar_id')->nullable();
            $table->unsignedBigInteger('indent_id')->nullable();
            $table->text('alasan');
            $table->timestamps();

            // Relasi opsional ke dua tabel (bisa salah satu null)
            $table->foreign('pendaftar_id')->references('id')->on('pendaftarans')->onDelete('cascade');
            $table->foreign('indent_id')->references('id')->on('indents')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penolakans');
    }
};

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
        Schema::create('surat_balasan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pendaftar_id')->nullable();
            $table->unsignedBigInteger('indent_id')->nullable();
            $table->enum('jenis', ['pendaftar', 'indent']);
            $table->string('status_surat'); // diterima / ditolak
            $table->string('file_path');
            $table->timestamps();

            $table->foreign('pendaftar_id')->references('id')->on('pendaftarans')->onDelete('cascade');
            $table->foreign('indent_id')->references('id')->on('indents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_balasan');
    }
};

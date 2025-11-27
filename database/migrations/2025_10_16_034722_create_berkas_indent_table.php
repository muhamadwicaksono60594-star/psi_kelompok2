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
    Schema::create('berkas_indent', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('indent_id'); // relasi ke tabel indent
        $table->string('nama_file');             // nama file yang tampil di tombol
        $table->string('path');                  // path penyimpanan file di storage
        $table->timestamps();

        // relasi foreign key
        $table->foreign('indent_id')->references('id')->on('indents')->onDelete('cascade');
    });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berkas_indent');
    }
};

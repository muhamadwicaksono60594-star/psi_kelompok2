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
        Schema::table('berkas', function (Blueprint $table) {
            // tambahkan kolom indent_id
            $table->unsignedBigInteger('indent_id')->nullable()->after('pendaftar_id');

            // buat foreign key-nya
            $table->foreign('indent_id')
                ->references('id')
                ->on('indents') // atau 'indents' kalau nama tabel kamu jamak
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('berkas', function (Blueprint $table) {
            $table->dropForeign(['indent_id']);
            $table->dropColumn('indent_id');
        });
    }

};

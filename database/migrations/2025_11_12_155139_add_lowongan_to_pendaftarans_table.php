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
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->unsignedBigInteger('lowongan_id')->nullable()->after('user_id');
            $table->date('tanggal_mulai')->nullable()->after('status');
            $table->date('tanggal_selesai')->nullable()->after('tanggal_mulai');

            $table->foreign('lowongan_id')->references('id')->on('lowongan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropForeign(['lowongan_id']);
            $table->dropColumn(['lowongan_id', 'tanggal_mulai', 'tanggal_selesai']);
        });
    }

};

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
        Schema::create('ganti_pengawas_ujians', function (Blueprint $table) {
            $table->id();
            $table->string('kd_dosen_asli', 10);
            $table->string('kd_dosen_pengganti', 10);
            $table->string('kel_ujian', 50);
            $table->string('kd_mtk', 10);
            $table->string('paket', 20);
            $table->string('petugas', 20);
            $table->string('ket');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ganti__pengawas_ujians');
    }
};

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
        Schema::create('pj_mtks', function (Blueprint $table) {
            $table->id();
            $table->string('kd_dosen', 10);
            $table->string('prodi', 6);
            $table->string('paket', 6);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pj_mtks');
    }
};

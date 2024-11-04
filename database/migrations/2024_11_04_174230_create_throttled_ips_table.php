<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('throttled_ips', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address');
            $table->unsignedBigInteger('user_id')->nullable(); // Jika ingin menyimpan ID pengguna
            $table->string('user_agent')->nullable();
            $table->timestamp('throttled_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('throttled_ips');
    }
};

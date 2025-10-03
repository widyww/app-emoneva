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
        Schema::create('guru_pelatihan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guru_id');
            $table->string('nama_pelatihan')->nullable();
            $table->string('tingkatan')->nullable()->comment('1. Pemula, 2.Lanjutan 3. Mahir');     
            $table->string('level')->nullable()->comment('1. Lokal, 2.Nasional 3. Internasional');         
            $table->string('tahun_pelatihan')->nullable();
            $table->string('jam_pelatihan')->nullable();
            $table->timestamps();

            $table->foreign('guru_id')->references('id')->on('guru')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_pelatihan');
    }
};

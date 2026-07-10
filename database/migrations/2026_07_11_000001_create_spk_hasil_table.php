<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menyimpan skor & peringkat SAW per sekolah per periode.
     * Satu baris per (sekolah, periode) agar perhitungan ulang memakai updateOrCreate.
     */
    public function up(): void
    {
        Schema::create('spk_hasil', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sekolah_id')->index();
            $table->unsignedBigInteger('periode_id')->index();
            $table->decimal('skor', 8, 5)->default(0)->comment('nilai V hasil SAW');
            $table->integer('peringkat')->nullable()->comment('1 = prioritas tertinggi');
            $table->enum('kategori', ['tinggi', 'sedang', 'rendah'])->nullable();
            $table->json('rincian')->nullable()->comment('skor & kontribusi per kriteria untuk transparansi');
            $table->timestamp('dihitung_pada')->nullable();
            $table->timestamps();

            $table->foreign('sekolah_id')->references('id')->on('sekolah')->onDelete('cascade');
            $table->foreign('periode_id')->references('id')->on('periode')->onDelete('cascade');
            $table->unique(['sekolah_id', 'periode_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spk_hasil');
    }
};

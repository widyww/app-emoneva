<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menyimpan definisi kriteria SPK beserta bobot hasil AHP.
     * Bobot diisi oleh AhpWeightService setelah lolos uji konsistensi (CR <= 10%).
     */
    public function up(): void
    {
        Schema::create('spk_kriteria', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique()->comment('C1, C2, ... untuk identifikasi kriteria');
            $table->string('nama')->comment('mis. Kondisi Listrik');
            $table->decimal('bobot', 6, 4)->default(0)->comment('hasil AHP, total seluruh kriteria aktif = 1');
            $table->enum('tipe', ['benefit', 'cost'])->default('benefit')->comment('pendekatan skor kebutuhan = benefit');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spk_kriteria');
    }
};

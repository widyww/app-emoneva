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
        Schema::create('sekolah', function (Blueprint $table) {
            $table->id();
            $table->string('npsn')->unique()->nullable();
            $table->string('tingkatan')->nullable();
            $table->string('nama')->nullable();
            $table->string('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('foto_sekolah')->nullable();
            $table->string('kepsek_nama')->nullable();
            $table->string('kepsek_hp')->nullable();
            $table->string('kepsek_foto')->nullable();
            $table->string('sk_ijin')->nullable();
            $table->string('status_sekolah')->nullable()->comment('1. NEGERI | 2. SWASTA/YAYASAN');
            $table->string('status_akreditasi')->nullable();
            $table->string('status_tanah')->nullable();
            $table->string('jum_siswa_pria')->nullable();
            $table->string('jum_siswa_wanita')->nullable();
            $table->string('status_verifikasi')->nullable();
            $table->string('keterangan_verifikasi')->nullable();
            $table->string('tahun')->nullable();
            //RELASI KECAMATAN KOTA
            $table->unsignedBigInteger('kecamatan_id')->nullable();
            $table->unsignedBigInteger('kota_id')->nullable();     
                                           
            $table->timestamps();
            $table->foreign('kecamatan_id')->references('id')->on('kecamatan')->onDelete('set null');
            $table->foreign('kota_id')->references('id')->on('kota')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sekolah');
    }
};

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
        Schema::create('guru', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('status')->nullable()->comment('1. PNS, 2. PPPK');
            $table->string('nip')->nullable();
            $table->string('nuptk')->nullable();
            $table->string('tempat')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('agama')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->date('tmt_pns_tahun')->nullable();
            $table->string('telepon')->nullable();

            //data kompetensi
            $table->string('mapel')->nullable();
            $table->string('sertifikasi_status')->nullable();
            $table->string('sertifikasi_tahun')->nullable();
            $table->string('sertifikasi_alasan')->nullable();
            //kompetensi office
            $table->string('kompetensi_word')->nullable();
            $table->string('kompetensi_powerpoin')->nullable();
            $table->string('kompetensi_excel')->nullable();
            $table->string('kompetensi_pemrogramman')->nullable();
            $table->string('kompetensi_jaringan')->nullable();
            $table->string('kompetensi_multimedia')->nullable();

            // pelatihan
            $table->string('pelatihan_status')->nullable()->comment('1. Ya, 2.Tidak'); // relasi
            $table->string('pelatihan_kebutuhan')->nullable()->comment('1. Ya, 2.Tidak'); // relasi
            //status verifikasi
            $table->string('status_verifikasi')->nullable();
            $table->string('catatan_verifikasi')->nullable();

            // relasi ke sekolah
            $table->foreignId('sekolah_id')->constrained('sekolah')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru');
    }
};

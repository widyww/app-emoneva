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
        Schema::create('sekolah_fasilitastik', function (Blueprint $table) {
           $table->id();
            $table->unsignedBigInteger('sekolah_id')->index();

            //LISTRIK
            $table->enum('listrik_status',['ada','tidak'])->default('tidak')->nullable();
            $table->string('listrik_sumber')->nullable();
            $table->string('listrik_durasi')->nullable();

            // KOMPUTER
            $table->string('jumlah_kom')->nullable();
            $table->enum('labkom_status',['ada','tidak'])->default('tidak')->nullable();

            // INTERNET
            $table->enum('internet_status',['ada','tidak'])->default('tidak')->nullable();
            $table->string('internet_sumber')->nullable();
            $table->string('internet_bandwith')->nullable();
            $table->string('topologi_jaringan')->nullable();
            $table->string('internet_kesesuaian')->nullable();
            $table->text('internet_alasankuota')->nullable();

            // SARAN
            $table->text('saran_pengembangan')->nullable();            
            $table->timestamps();

            $table->foreign('sekolah_id')->references('id')->on('sekolah')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sekolah_fasilitastik');
    }
};

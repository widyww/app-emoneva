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
        Schema::create('sekolah_fasilitastik_lab', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sekolah_fasilitastik_id');
            $table->string('labkom_nama')->nullable();
            $table->string('labkom_jumlah_pc')->nullable();
            $table->timestamps();

            $table->foreign('sekolah_fasilitastik_id')->references('id')->on('sekolah_fasilitastik')->onDelete('cascade');
        });     

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sekolah_fasilitastik_lab');
    }
};

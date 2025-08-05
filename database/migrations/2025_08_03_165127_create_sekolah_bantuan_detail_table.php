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
        Schema::create('sekolah_bantuan_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolah_bantuan_status_id')->constrained('sekolah_bantuan_status')->onDelete('cascade');
            $table->string('nama_lembaga');
            $table->text('keterangan_bantuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sekolah_bantuan_detail');
    }
};

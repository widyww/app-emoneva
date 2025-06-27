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
            $table->string('npsn')->nullable();
            $table->string('nama')->nullable();
            $table->string('tingkatan')->nullable();
            $table->string('alamat')->nullable();
            $table->string('kecamatan_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('sk_ijin')->comment('SK atau Ijin Operasional')->nullable();
            $table->string('status')->comment('Negeri/Swasta')->nullable();
            $table->string('akreditasi')->nullable();
            $table->timestamps();
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

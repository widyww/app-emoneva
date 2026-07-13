<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kriteria', function (Blueprint $t) {
            $t->id();
            $t->string('kode', 5)->unique();       // C1..C5
            $t->string('nama');
            $t->text('definisi')->nullable();
            $t->enum('sifat', ['benefit', 'cost'])->default('benefit');
            $t->unsignedTinyInteger('urutan')->default(0);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kriteria');
    }
};

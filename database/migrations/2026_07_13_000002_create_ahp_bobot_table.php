<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ahp_bobot', function (Blueprint $t) {
            $t->id();
            $t->foreignId('periode_id')->constrained('periode')->cascadeOnDelete();
            $t->foreignId('kriteria_id')->constrained('kriteria')->cascadeOnDelete();
            $t->decimal('bobot', 10, 6);
            $t->timestamps();
            $t->unique(['periode_id', 'kriteria_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ahp_bobot');
    }
};

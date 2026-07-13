<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ahp_perbandingan', function (Blueprint $t) {
            $t->id();
            $t->foreignId('periode_id')->constrained('periode')->cascadeOnDelete();
            $t->foreignId('kriteria_baris_id')->constrained('kriteria')->cascadeOnDelete();
            $t->foreignId('kriteria_kolom_id')->constrained('kriteria')->cascadeOnDelete();
            $t->decimal('nilai', 8, 4);            // nilai baris terhadap kolom (mis. 3 atau 0.3333)
            $t->timestamps();
            $t->unique(['periode_id', 'kriteria_baris_id', 'kriteria_kolom_id'], 'uq_ahp_sel');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ahp_perbandingan');
    }
};

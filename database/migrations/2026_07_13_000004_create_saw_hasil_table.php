<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saw_hasil', function (Blueprint $t) {
            $t->id();
            $t->foreignId('periode_id')->constrained('periode')->cascadeOnDelete();
            $t->foreignId('sekolah_id')->constrained('sekolah')->cascadeOnDelete();
            $t->json('skor');                 // {"C1":5,"C2":1,...}
            $t->decimal('nilai_vi', 10, 6);
            $t->unsignedInteger('peringkat');
            $t->timestamp('dihitung_pada')->nullable();
            $t->timestamps();
            $t->unique(['periode_id', 'sekolah_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saw_hasil');
    }
};

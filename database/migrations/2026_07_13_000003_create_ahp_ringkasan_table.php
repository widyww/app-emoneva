<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ahp_ringkasan', function (Blueprint $t) {
            $t->id();
            $t->foreignId('periode_id')->unique()->constrained('periode')->cascadeOnDelete();
            $t->decimal('lambda_maks', 10, 4);
            $t->decimal('ci', 10, 4);
            $t->decimal('ri', 6, 2);
            $t->decimal('cr', 10, 4);
            $t->boolean('konsisten')->default(false);
            $t->timestamp('dihitung_pada')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ahp_ringkasan');
    }
};

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
        Schema::table('sekolah_sosekbud', function (Blueprint $table) {
            $table->text('kondisi_geografis')->nullable()->change();
            $table->text('kondisi_sosekbud')->nullable()->change();
            $table->text('akses_transportasi')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sekolah_sosekbud', function (Blueprint $table) {
            $table->string('kondisi_geografis')->nullable()->change();
            $table->string('kondisi_sosekbud')->nullable()->change();
            $table->string('akses_transportasi')->nullable()->change();
        });
    }
};

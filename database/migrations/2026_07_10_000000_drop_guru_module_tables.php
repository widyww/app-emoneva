<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Menghapus sisa modul kompetensi guru dari basis data produksi setelah
 * fokus sistem dipersempit menjadi monitoring & evaluasi fasilitas TIK saja.
 *
 * Aman untuk dijalankan pada database yang sudah berisi data: hanya membuang
 * kolom `users.guru_id` dan tabel-tabel guru; tabel lain tidak tersentuh.
 */
return new class extends Migration
{
    public function up(): void
    {
        // 1) Lepas kolom guru_id dari tabel users (beserta foreign key-nya) bila masih ada.
        if (Schema::hasColumn('users', 'guru_id')) {
            try {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropForeign(['guru_id']);
                });
            } catch (\Throwable $e) {
                // Foreign key mungkin tidak pernah dibuat — abaikan.
            }

            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('guru_id');
            });
        }

        // 2) Hapus tabel guru — anak (yang mereferensikan guru) lebih dulu.
        Schema::dropIfExists('guru_kebutuhan');
        Schema::dropIfExists('guru_pelatihan');
        Schema::dropIfExists('guru');
    }

    public function down(): void
    {
        // Rollback terbatas: hanya mengembalikan kolom users.guru_id (nullable, tanpa FK).
        // Tabel guru tidak dapat dipulihkan karena migrasi pembuatnya telah dihapus.
        if (!Schema::hasColumn('users', 'guru_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('guru_id')->nullable()->after('sekolah_id');
            });
        }
    }
};

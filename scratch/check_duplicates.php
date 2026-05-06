<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Support\Facades\DB;

echo "--- CHECKING FOR DUPLICATES ---\n\n";

// 1. Duplicate NPSN
$dupNpsn = Sekolah::select('npsn', DB::raw('count(*) as count'))
    ->groupBy('npsn')
    ->having('count', '>', 1)
    ->get();

echo "1. Duplicate NPSNs: " . $dupNpsn->count() . "\n";
if ($dupNpsn->count() > 0) {
    foreach ($dupNpsn as $d) {
        echo "   - NPSN: {$d->npsn} (Count: {$d->count})\n";
        $schools = Sekolah::where('npsn', $d->npsn)->get();
        foreach ($schools as $s) {
            echo "     ID: {$s->id}, Name: {$s->nama}, Kota: {$s->kota?->nama}\n";
        }
    }
}

// 2. Duplicate School Names in the same Kota
$dupNames = Sekolah::select('nama', 'kota_id', DB::raw('count(*) as count'))
    ->groupBy('nama', 'kota_id')
    ->having('count', '>', 1)
    ->get();

echo "\n2. Duplicate School Names in same City: " . $dupNames->count() . "\n";
if ($dupNames->count() > 0) {
    foreach ($dupNames as $d) {
        $kota = DB::table('kota')->where('id', $d->kota_id)->value('nama');
        echo "   - Name: {$d->nama} in {$kota} (Count: {$d->count})\n";
        $schools = Sekolah::where('nama', $d->nama)->where('kota_id', $d->kota_id)->get();
        foreach ($schools as $s) {
            echo "     ID: {$s->id}, NPSN: {$s->npsn}\n";
        }
    }
}

// 3. Duplicate User Emails (NPSN)
$dupEmails = User::select('email', DB::raw('count(*) as count'))
    ->groupBy('email')
    ->having('count', '>', 1)
    ->get();

echo "\n3. Duplicate User Emails (NPSN): " . $dupEmails->count() . "\n";
if ($dupEmails->count() > 0) {
    foreach ($dupEmails as $d) {
        echo "   - Email: {$d->email} (Count: {$d->count})\n";
    }
}

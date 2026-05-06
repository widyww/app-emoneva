<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Sekolah;
use App\Models\User;

$wrongNpsns = [
    '76006907', // SLB Tual
    '60103998', // SMK 4 Buru
    '69659382', // SMK 6 Buru
    '69650965', // SMK 8 Buru
    // '60100972', // Wait, 60100972 is SMK ALHILAAL NAMLEA in image, but was mislabeled as SMKN 10.
    // Let's handle 60100972 carefully. 
    // Image 17 says 60100972 is SMK ALHILAAL NAMLEA.
    // My cleanup seeder already fixed it. 
    // Let's just remove the ones that are definitely redundant.
    '69631987', // SMK 11 Malteng
    '60100234', // SMK Kes Langgur
    '60102780', // SMKN 1 SBB
    '60100350', // SMAS PGRI OMA HARUKU (Double)
];

echo "Cleaning up duplicates...\n";

foreach ($wrongNpsns as $npsn) {
    $sekolah = Sekolah::where('npsn', $npsn)->first();
    if ($sekolah) {
        User::where('sekolah_id', $sekolah->id)->delete();
        $sekolah->delete();
        echo "Deleted: $npsn ($sekolah->nama)\n";
    }
}

// Fix SMK ALHILAAL vs SMKN 10 Malteng (both had 60100972 potentially)
// Actually if I use updateOrCreate, it should be fine.
// But let's check if there's an entry for "SMK NEGERI 10 MALUKU TENGAH" with wrong NPSN.
$wrongMalteng10 = Sekolah::where('nama', 'LIKE', '%SMK NEGERI 10 MALUKU TENGAH%')->where('npsn', '!=', '69831986')->first();
if ($wrongMalteng10) {
    User::where('sekolah_id', $wrongMalteng10->id)->delete();
    $wrongMalteng10->delete();
    echo "Deleted wrong Malteng 10: $wrongMalteng10->npsn\n";
}

echo "Done.\n";

<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\SekolahFasilitas;

echo "Updating Fasilitas TIK to match dropdown values...\n";

$allFasilitas = SekolahFasilitas::all();
foreach ($allFasilitas as $f) {
    // 1. Listrik Sumber
    if (stripos($f->listrik_sumber, 'PLN') !== false) $listrik_sumber = 'PLN';
    elseif (stripos($f->listrik_sumber, 'Genset') !== false) $listrik_sumber = 'Genset';
    else $listrik_sumber = 'Tidak Ada';

    // 2. Internet Sumber
    if (stripos($f->internet_sumber, 'Fiber') !== false || stripos($f->internet_sumber, 'Indihome') !== false) $internet_sumber = 'Indihome';
    elseif (stripos($f->internet_sumber, 'Starlink') !== false || stripos($f->internet_sumber, 'Satelit') !== false) $internet_sumber = 'Starlink';
    else $internet_sumber = 'Lainnya';

    // 3. Topologi
    if (stripos($f->topologi_jaringan, 'LAN') !== false) $topologi = 'LAN';
    else $topologi = 'Wireless';

    // 4. Kesesuaian
    if (stripos($f->internet_kesesuaian, 'Sangat') !== false || $f->internet_kesesuaian === 'Sesuai') $kesesuaian = 'Sesuai';
    else $kesesuaian = 'Tidak Sesuai';

    $f->update([
        'listrik_sumber' => $listrik_sumber,
        'internet_sumber' => $internet_sumber,
        'topologi_jaringan' => $topologi,
        'internet_kesesuaian' => $kesesuaian,
    ]);
}

echo "Success.\n";

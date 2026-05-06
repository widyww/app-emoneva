<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\SekolahBantuanStatus;
use App\Models\SekolahBantuanDetail;

echo "Mapping Bantuan Status to 'ya'/'tidak'...\n";

$statuses = SekolahBantuanStatus::all();
foreach ($statuses as $s) {
    $hasDetails = SekolahBantuanDetail::where('sekolah_bantuan_status_id', $s->id)->exists();
    $s->update(['status' => $hasDetails ? 'ya' : 'tidak']);
}

echo "Success.\n";

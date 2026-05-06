<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Sekolah;

echo "Generating KNN Dataset...\n";

$sekolahs = Sekolah::with(['sekolah_sosekbud', 'fasilitas'])->get();
$filename = 'c:/laragon/www/app-emoneva/scratch/dataset_knn_sekolah.csv';
$file = fopen($filename, 'w');

// Header CSV
fputcsv($file, [
    'npsn', 
    'nama_sekolah', 
    'score_geografis', 
    'score_listrik', 
    'score_internet', 
    'jumlah_komputer', 
    'bandwidth_mbps', 
    'rasio_komputer_siswa', 
    'score_akreditasi', 
    'label_prioritas_bantuan'
]);

foreach ($sekolahs as $s) {
    $sosekbud = $s->sekolah_sosekbud;
    $fasilitas = $s->fasilitas;
    
    // 1. Score Geografis
    $geo = 2; // default
    if ($sosekbud) {
        if (stripos($sosekbud->kondisi_geografis, 'Terpencil') !== false) $geo = 1;
        elseif (stripos($sosekbud->kondisi_geografis, 'Perkotaan') !== false) $geo = 3;
    }

    // 2. Score Listrik & Internet
    $listrik = ($fasilitas && $fasilitas->listrik_status === 'ada') ? 1 : 0;
    $internet = ($fasilitas && $fasilitas->internet_status === 'ada') ? 1 : 0;
    
    // 3. Score Akreditasi
    $akred = 1; // default C
    if ($s->status_akreditasi === 'A') $akred = 3;
    elseif ($s->status_akreditasi === 'B') $akred = 2;

    // 4. Rasio Komputer
    $totalSiswa = (int)$s->jum_siswa_pria + (int)$s->jum_siswa_wanita;
    $jmlKom = $fasilitas ? (int)$fasilitas->jumlah_kom : 0;
    $rasio = $totalSiswa > 0 ? round($jmlKom / $totalSiswa, 4) : 0;

    // 5. Label Prioritas (Logic dari kondisi dummy sebelumnya)
    // Jika fasilitas buruk -> Prioritas 1 (Tinggi)
    // Jika fasilitas sedang -> Prioritas 2 (Sedang)
    // Jika fasilitas baik -> Prioritas 3 (Rendah)
    $prioritas = 2;
    if ($akred == 1 || $listrik == 0 || $internet == 0) $prioritas = 1;
    elseif ($akred == 3 && $listrik == 1 && $internet == 1 && $jmlKom > 40) $prioritas = 3;

    fputcsv($file, [
        $s->npsn,
        $s->nama,
        $geo,
        $listrik,
        $internet,
        $jmlKom,
        $fasilitas ? (int)$fasilitas->internet_bandwith : 0,
        $rasio,
        $akred,
        $prioritas
    ]);
}

fclose($file);
echo "Dataset generated successfully: $filename\n";

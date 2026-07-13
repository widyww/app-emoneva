# Panduan Implementasi Metode AHP–SAW pada Sistem emoNeva

> **Tujuan.** Menambahkan modul Sistem Pendukung Keputusan (SPK) perangkingan prioritas bantuan fasilitas TIK ke dalam aplikasi emoNeva (Laravel 11), mengikuti alur metodologi pada skripsi (AHP → bobot; SAW → perangkingan) dan **selaras persis dengan angka pada berkas Excel** (`dataset_fasilitas_tik_sma.xlsx` dan `hasil_saw_prioritas_tik_sma.xlsx`).
>
> **Prasyarat.** Basis kode emoNeva sudah berjalan; data SQL tahun lalu sudah dimuat melalui seeder (tabel `sekolah`, `sekolah_fasilitastik`, `sekolah_fasilitastik_lab`, `sekolah_bantuan_status`, `sekolah_bantuan_detail` sudah terisi). Panduan ini **tidak** mengubah modul yang sudah ada; hanya menambah tabel, model, service, controller, route, dan view baru.

---

## 0. Ringkasan yang akan ditambahkan

| Lapisan | Berkas baru | Fungsi |
|---|---|---|
| Migrasi | `kriteria`, `ahp_perbandingan`, `ahp_bobot`, `ahp_ringkasan`, `saw_hasil` | Menyimpan kriteria, matriks AHP, bobot & konsistensi, serta hasil perangkingan |
| Model | `Kriteria`, `AhpPerbandingan`, `AhpBobot`, `AhpRingkasan`, `SawHasil` | Eloquent untuk tabel di atas |
| Seeder | `KriteriaSeeder`, `AhpPerbandinganSeeder` | Mengisi 5 kriteria & matriks default yang mereproduksi bobot Excel |
| Service | `AhpService`, `SawService`, `RubrikKebutuhan` | Logika perhitungan (inti metode) |
| Controller | `Spk\AhpController` (Administrator), `Spk\PerangkinganController` (Kabalai) | Input matriks & tampilan hasil |
| Route | Grup di `routes/web.php` | Endpoint per peran |
| View | `spk/ahp/*`, `spk/perangkingan/*` | Antarmuka |

Alur eksekusi mengikuti dua diagram pada Bab III:

```
[Kuesioner Kepala Balai] → Administrator input matriks → AhpService
        → bobot Wj + uji CR (≤0,1)  ─────────────┐
                                                  ▼
[Data fasilitas tervalidasi] → SawService → RubrikKebutuhan (skor 1–5)
        → normalisasi (benefit) → Vi = Σ(Wj·rij) → peringkat → Kabalai
```

---

## 1. Sumber kebenaran (harus sama dengan Excel)

Seluruh angka di bawah **wajib** dipakai agar hasil sistem identik dengan Excel.

### 1.1 Kriteria (semua bersifat *benefit* terhadap skor kebutuhan)

| Kode | Nama | Definisi operasional | Kolom sumber |
|---|---|---|---|
| C1 | Ketersediaan komputer | Rasio jumlah komputer layak pakai terhadap jumlah siswa (kebutuhan ideal 1:10) | `sekolah_fasilitastik.jumlah_kom` ÷ (`jum_siswa_pria`+`jum_siswa_wanita`) |
| C2 | Durasi/ketersediaan daya listrik | Lama (durasi) pasokan listrik harian untuk operasional TIK | `sekolah_fasilitastik.listrik_durasi` |
| C3 | Kapasitas jaringan internet | Ketersediaan & kecepatan koneksi (bandwidth) | `internet_status` + `internet_bandwith` |
| C4 | Ketersediaan ruang lab komputer | Ada/tidaknya ruang laboratorium komputer | `labkom_status` |
| C5 | Riwayat penerimaan bantuan | Status pernah/belum pernah menerima bantuan | `sekolah_bantuan_status.status` |

### 1.2 Rubrik konversi skor kebutuhan (1–5; makin butuh makin tinggi)

| Skor | C1 rasio kom:siswa | C2 durasi (jam/hari) | C3 internet & bandwidth (Mbps) | C4 lab | C5 bantuan |
|---|---|---|---|---|---|
| 5 | < 0,025 | ≤ 6 | tidak ada / 0 | tidak ada | belum pernah |
| 4 | 0,025 – < 0,05 | 7 – 11 | 1 – 9 | – | – |
| 3 | 0,05 – < 0,075 | 12 – 17 | 10 – 24 | – | – |
| 2 | 0,075 – < 0,10 | 18 – 23 | 25 – 49 | – | pernah |
| 1 | ≥ 0,10 | 24 | ≥ 50 | ada | – |

**Aturan tambahan (wajib):**
- **Data kosong → skor 5** (asumsi konservatif: sekolah tak lengkap dianggap paling butuh).
- **Anomali C2 > 24 jam → skor 1** (nilai daya VA yang keliru diinput dianggap listrik penuh).

### 1.3 Matriks perbandingan berpasangan default (mereproduksi bobot Excel)

Nilai segitiga atas (10 perbandingan) — sisi bawah adalah kebalikannya:

| Pasangan | Nilai (baris lebih penting) |
|---|---|
| C1–C2 | 3 |
| C1–C3 | 2 |
| C1–C4 | 3 |
| C1–C5 | 5 |
| C2–C3 | 1/3 |
| C2–C4 | 1/2 |
| C2–C5 | 2 |
| C3–C4 | 2 |
| C3–C5 | 4 |
| C4–C5 | 3 |

### 1.4 Bobot & konsistensi yang harus dihasilkan

| Kriteria | Bobot (Wj) | % |
|---|---|---|
| C1 | 0,4011 | 40,11 |
| C2 | 0,1051 | 10,51 |
| C3 | 0,2681 | 26,81 |
| C4 | 0,1631 | 16,31 |
| C5 | 0,0626 | 6,26 |

λmaks = 5,086 · CI = 0,022 · RI(n=5) = 1,12 · **CR = 0,019 ≤ 0,10 (konsisten)**

> **Catatan metode bobot.** Excel memakai **rata-rata geometrik baris**. Jika kamu ingin persis mengikuti kalimat Bab III (normalisasi kolom lalu rata-rata baris), selisih bobot ≤ 0,18 poin persen dan peringkat identik. Panduan ini mengimplementasikan rata-rata geometrik; alternatif kolom disertakan sebagai komentar pada `AhpService`.

### 1.5 Rumus SAW

Karena seluruh kriteria *benefit*: `r_ij = x_ij / max_i(x_ij)`, lalu `V_i = Σ_j (W_j · r_ij)`. Peringkat = urut `V_i` menurun.

---

## 2. Langkah 1 — Migrasi tabel baru

Buat lima migrasi (`php artisan make:migration ...`). Isi masing-masing seperti berikut.

**`create_kriteria_table`**
```php
Schema::create('kriteria', function (Blueprint $t) {
    $t->id();
    $t->string('kode', 5)->unique();       // C1..C5
    $t->string('nama');
    $t->text('definisi')->nullable();
    $t->enum('sifat', ['benefit', 'cost'])->default('benefit');
    $t->unsignedTinyInteger('urutan')->default(0);
    $t->timestamps();
});
```

**`create_ahp_perbandingan_table`** — matriks input per periode
```php
Schema::create('ahp_perbandingan', function (Blueprint $t) {
    $t->id();
    $t->foreignId('periode_id')->constrained('periode')->cascadeOnDelete();
    $t->foreignId('kriteria_baris_id')->constrained('kriteria')->cascadeOnDelete();
    $t->foreignId('kriteria_kolom_id')->constrained('kriteria')->cascadeOnDelete();
    $t->decimal('nilai', 8, 4);            // nilai baris terhadap kolom (mis. 3 atau 0.3333)
    $t->timestamps();
    $t->unique(['periode_id', 'kriteria_baris_id', 'kriteria_kolom_id'], 'uq_ahp_sel');
});
```

**`create_ahp_bobot_table`** — bobot hasil per periode
```php
Schema::create('ahp_bobot', function (Blueprint $t) {
    $t->id();
    $t->foreignId('periode_id')->constrained('periode')->cascadeOnDelete();
    $t->foreignId('kriteria_id')->constrained('kriteria')->cascadeOnDelete();
    $t->decimal('bobot', 10, 6);
    $t->timestamps();
    $t->unique(['periode_id', 'kriteria_id']);
});
```

**`create_ahp_ringkasan_table`** — nilai konsistensi per periode
```php
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
```

**`create_saw_hasil_table`** — hasil perangkingan per periode
```php
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
```

Jalankan: `php artisan migrate`.

---

## 3. Langkah 2 — Model Eloquent

**`app/Models/Kriteria.php`**
```php
class Kriteria extends Model
{
    protected $table = 'kriteria';
    protected $fillable = ['kode', 'nama', 'definisi', 'sifat', 'urutan'];
}
```

**`app/Models/AhpPerbandingan.php`**
```php
class AhpPerbandingan extends Model
{
    protected $table = 'ahp_perbandingan';
    protected $fillable = ['periode_id', 'kriteria_baris_id', 'kriteria_kolom_id', 'nilai'];
    protected $casts = ['nilai' => 'float'];
}
```

**`app/Models/AhpBobot.php`**, **`AhpRingkasan.php`**, **`SawHasil.php`** — analog (isi `$fillable` sesuai kolom; pada `SawHasil` tambahkan `protected $casts = ['skor' => 'array', 'nilai_vi' => 'float'];`).

**Tambahkan relasi pada `app/Models/Sekolah.php`** (jika belum ada — sesuaikan nama relasi dengan yang sudah dipakai di sistemmu):
```php
public function fasilitas()      { return $this->hasOne(SekolahFasilitas::class, 'sekolah_id'); }
public function bantuanStatus()  { return $this->hasOne(SekolahBantuanStatus::class, 'sekolah_id'); }

public function jumlahSiswa(): int
{
    return (int) $this->jum_siswa_pria + (int) $this->jum_siswa_wanita;
}
```
Dan pada **`SekolahFasilitas`**: `public function labs() { return $this->hasMany(SekolahFasilitasLab::class, 'sekolah_fasilitastik_id'); }`

---

## 4. Langkah 3 — Seeder selaras Excel

**`database/seeders/KriteriaSeeder.php`**
```php
public function run(): void
{
    $data = [
        ['kode'=>'C1','nama'=>'Ketersediaan komputer','sifat'=>'benefit','urutan'=>1,
         'definisi'=>'Rasio jumlah komputer layak pakai terhadap jumlah siswa (ideal 1:10).'],
        ['kode'=>'C2','nama'=>'Durasi/ketersediaan daya listrik','sifat'=>'benefit','urutan'=>2,
         'definisi'=>'Lama (durasi) pasokan listrik harian untuk operasional TIK.'],
        ['kode'=>'C3','nama'=>'Kapasitas jaringan internet','sifat'=>'benefit','urutan'=>3,
         'definisi'=>'Ketersediaan dan kecepatan koneksi internet (bandwidth).'],
        ['kode'=>'C4','nama'=>'Ketersediaan ruang laboratorium komputer','sifat'=>'benefit','urutan'=>4,
         'definisi'=>'Ada/tidaknya ruang laboratorium komputer.'],
        ['kode'=>'C5','nama'=>'Riwayat penerimaan bantuan','sifat'=>'benefit','urutan'=>5,
         'definisi'=>'Status pernah/belum pernah menerima bantuan fasilitas TIK.'],
    ];
    foreach ($data as $d) {
        \App\Models\Kriteria::updateOrCreate(['kode' => $d['kode']], $d);
    }
}
```

**`database/seeders/AhpPerbandinganSeeder.php`** — menanam 10 nilai segitiga atas (Excel) untuk periode aktif:
```php
public function run(): void
{
    $periode = \App\Models\Periode::where('status', 1)->first()
            ?? \App\Models\Periode::first();
    $k = \App\Models\Kriteria::pluck('id', 'kode');   // ['C1'=>1,...]

    // pasangan => nilai baris terhadap kolom
    $pasangan = [
        ['C1','C2',3], ['C1','C3',2], ['C1','C4',3], ['C1','C5',5],
        ['C2','C3',1/3], ['C2','C4',1/2], ['C2','C5',2],
        ['C3','C4',2], ['C3','C5',4],
        ['C4','C5',3],
    ];

    foreach ($pasangan as [$a, $b, $nilai]) {
        // sel atas
        \App\Models\AhpPerbandingan::updateOrCreate(
            ['periode_id'=>$periode->id, 'kriteria_baris_id'=>$k[$a], 'kriteria_kolom_id'=>$k[$b]],
            ['nilai'=>round($nilai, 4)]
        );
        // sel bawah (kebalikan)
        \App\Models\AhpPerbandingan::updateOrCreate(
            ['periode_id'=>$periode->id, 'kriteria_baris_id'=>$k[$b], 'kriteria_kolom_id'=>$k[$a]],
            ['nilai'=>round(1/$nilai, 4)]
        );
    }
    // diagonal = 1
    foreach ($k as $id) {
        \App\Models\AhpPerbandingan::updateOrCreate(
            ['periode_id'=>$periode->id, 'kriteria_baris_id'=>$id, 'kriteria_kolom_id'=>$id],
            ['nilai'=>1]
        );
    }
}
```

**Registrasi di `database/seeders/DatabaseSeeder.php`** (setelah seeder data SQL-mu, karena butuh periode & sekolah):
```php
$this->call([
    // ... seeder data SQL yang sudah ada (sekolah, fasilitas, dst.)
    KriteriaSeeder::class,
    AhpPerbandinganSeeder::class,
]);
```
Jalankan: `php artisan db:seed --class=KriteriaSeeder && php artisan db:seed --class=AhpPerbandinganSeeder`.

---

## 5. Langkah 4 — `RubrikKebutuhan` (konversi skor)

**`app/Services/Spk/RubrikKebutuhan.php`** — angka **persis** Tabel 1.2.
```php
namespace App\Services\Spk;

use App\Models\Sekolah;

class RubrikKebutuhan
{
    /** @return array{C1:int,C2:int,C3:int,C4:int,C5:int} */
    public function skor(Sekolah $s): array
    {
        $f = $s->fasilitas;
        return [
            'C1' => $this->c1($s, $f),
            'C2' => $this->c2($f),
            'C3' => $this->c3($f),
            'C4' => $this->c4($f),
            'C5' => $this->c5($s),
        ];
    }

    private function c1(Sekolah $s, $f): int
    {
        $kom   = is_numeric($f?->jumlah_kom) ? (float) $f->jumlah_kom : null;
        $siswa = $s->jumlahSiswa();
        if ($kom === null || $siswa <= 0) return 5;      // data kosong
        $r = $kom / $siswa;
        return match (true) {
            $r >= 0.10   => 1,
            $r >= 0.075  => 2,
            $r >= 0.05   => 3,
            $r >= 0.025  => 4,
            default      => 5,
        };
    }

    private function c2($f): int
    {
        $d = is_numeric($f?->listrik_durasi) ? (float) $f->listrik_durasi : null;
        if ($d === null) return 5;                       // kosong
        if ($d > 24)     return 1;                       // anomali satuan VA → listrik penuh
        return match (true) {
            $d <= 6   => 5,
            $d <= 11  => 4,
            $d <= 17  => 3,
            $d <= 23  => 2,
            default   => 1,                              // 24 jam
        };
    }

    private function c3($f): int
    {
        $bw = is_numeric($f?->internet_bandwith) ? (float) $f->internet_bandwith : null;
        if (($f?->internet_status ?? 'tidak') === 'tidak' || $bw === 0.0) return 5;
        if ($bw === null) return 5;                      // kosong
        return match (true) {
            $bw <= 9   => 4,
            $bw <= 24  => 3,
            $bw <= 49  => 2,
            default    => 1,                             // ≥50
        };
    }

    private function c4($f): int
    {
        return ($f?->labkom_status ?? 'tidak') === 'ada' ? 1 : 5;
    }

    private function c5(Sekolah $s): int
    {
        return ($s->bantuanStatus?->status === 'ya') ? 2 : 5;   // belum/kosong → 5
    }
}
```

---

## 6. Langkah 5 — `AhpService` (bobot & konsistensi)

**`app/Services/Spk/AhpService.php`**
```php
namespace App\Services\Spk;

class AhpService
{
    /** Indeks Random Saaty */
    private array $RI = [1=>0.0,2=>0.0,3=>0.58,4=>0.90,5=>1.12,6=>1.24,7=>1.32,8=>1.41,9=>1.45,10=>1.49];

    /**
     * @param array<int,array<int,float>> $m  Matriks n×n (indeks 0..n-1 selaras urutan kriteria)
     * @return array{bobot:array<int,float>,lambda_maks:float,ci:float,ri:float,cr:float,konsisten:bool}
     */
    public function hitung(array $m): array
    {
        $n = count($m);

        // (1) Rata-rata geometrik tiap baris  → bobot ternormalisasi
        $gm = [];
        for ($i = 0; $i < $n; $i++) {
            $prod = 1.0;
            for ($j = 0; $j < $n; $j++) $prod *= $m[$i][$j];
            $gm[$i] = $prod ** (1 / $n);
        }
        $sum   = array_sum($gm);
        $bobot = array_map(fn ($g) => $g / $sum, $gm);

        // --- Alternatif "normalisasi kolom lalu rata-rata baris" (sesuai kalimat Bab III):
        // $colSum = array_map(fn($j)=>array_sum(array_column($m,$j)), range(0,$n-1));
        // for ($i=0;$i<$n;$i++){ $s=0; for($j=0;$j<$n;$j++) $s += $m[$i][$j]/$colSum[$j]; $bobot[$i]=$s/$n; }

        // (2) λmaks = rata-rata (A·w)_i / w_i
        $lambda = 0.0;
        for ($i = 0; $i < $n; $i++) {
            $aw = 0.0;
            for ($j = 0; $j < $n; $j++) $aw += $m[$i][$j] * $bobot[$j];
            $lambda += $aw / $bobot[$i];
        }
        $lambdaMaks = $lambda / $n;

        // (3) CI, CR
        $ci = ($lambdaMaks - $n) / ($n - 1);
        $ri = $this->RI[$n] ?? 1.49;
        $cr = $ri == 0.0 ? 0.0 : $ci / $ri;

        return [
            'bobot'       => $bobot,
            'lambda_maks' => $lambdaMaks,
            'ci'          => $ci,
            'ri'          => $ri,
            'cr'          => $cr,
            'konsisten'   => $cr <= 0.10,
        ];
    }
}
```

---

## 7. Langkah 6 — `SawService` (perangkingan)

**`app/Services/Spk/SawService.php`**
```php
namespace App\Services\Spk;

use App\Models\{Sekolah, AhpBobot, SawHasil, Periode};
use Illuminate\Support\Facades\DB;

class SawService
{
    public function __construct(private RubrikKebutuhan $rubrik) {}

    public function hitungDanSimpan(Periode $periode): array
    {
        // 1) Ambil bobot AHP periode ini: ['C1'=>0.4011, ...]
        $bobot = AhpBobot::where('periode_id', $periode->id)
            ->join('kriteria', 'kriteria.id', '=', 'ahp_bobot.kriteria_id')
            ->pluck('bobot', 'kriteria.kode')->map(fn ($b) => (float) $b)->all();

        // 2) Alternatif = SMA yang punya data fasilitas (lihat catatan filter di §12)
        $sekolahs = Sekolah::with(['fasilitas', 'bantuanStatus'])
            ->where('tingkatan', 'SMA')
            ->whereHas('fasilitas')
            // ->where('status_verifikasi', 2)   // aktifkan bila hanya data tervalidasi
            // ->where('tahun', $periode->tahun)  // aktifkan bila sekolah.tahun sudah terisi
            ->get();

        // 3) Matriks skor kebutuhan
        $skor = [];
        foreach ($sekolahs as $s) $skor[$s->id] = $this->rubrik->skor($s);

        // 4) Nilai maksimum tiap kriteria (semua benefit)
        $maks = [];
        foreach (['C1','C2','C3','C4','C5'] as $k) {
            $maks[$k] = max(array_column($skor, $k) ?: [1]) ?: 1;
        }

        // 5) Vi = Σ (Wj · rij),  rij = xij / maks
        $vi = [];
        foreach ($skor as $id => $sk) {
            $v = 0.0;
            foreach ($sk as $k => $x) $v += ($bobot[$k] ?? 0) * ($x / $maks[$k]);
            $vi[$id] = $v;
        }
        arsort($vi);                    // urut menurun

        // 6) Simpan hasil + peringkat
        DB::transaction(function () use ($periode, $vi, $skor) {
            SawHasil::where('periode_id', $periode->id)->delete();
            $rank = 1;
            foreach ($vi as $id => $nilai) {
                SawHasil::create([
                    'periode_id'    => $periode->id,
                    'sekolah_id'    => $id,
                    'skor'          => $skor[$id],
                    'nilai_vi'      => round($nilai, 6),
                    'peringkat'     => $rank++,
                    'dihitung_pada' => now(),
                ]);
            }
        });

        return ['jumlah' => count($vi)];
    }
}
```

---

## 8. Langkah 7 — Controller & Route

**`app/Http/Controllers/Spk/AhpController.php`** (peran Administrator)
```php
namespace App\Http\Controllers\Spk;

use App\Http\Controllers\Controller;
use App\Models\{Kriteria, AhpPerbandingan, AhpBobot, AhpRingkasan, Periode};
use App\Services\Spk\AhpService;
use Illuminate\Http\Request;

class AhpController extends Controller
{
    public function index()
    {
        $periode  = Periode::where('status', 1)->firstOrFail();
        $kriteria = Kriteria::orderBy('urutan')->get();
        $sel = AhpPerbandingan::where('periode_id', $periode->id)
            ->get()->keyBy(fn ($r) => $r->kriteria_baris_id.'-'.$r->kriteria_kolom_id);
        $ringkasan = AhpRingkasan::where('periode_id', $periode->id)->first();
        $bobot = AhpBobot::where('periode_id', $periode->id)->pluck('bobot', 'kriteria_id');
        return view('spk.ahp.index', compact('periode','kriteria','sel','ringkasan','bobot'));
    }

    // Simpan input matriks (hanya segitiga atas dari form) lalu hitung bobot
    public function hitung(Request $request, AhpService $ahp)
    {
        $periode  = Periode::where('status', 1)->firstOrFail();
        $kriteria = Kriteria::orderBy('urutan')->get();
        $ids      = $kriteria->pluck('id')->values();
        $n        = $ids->count();

        // request->nilai[i][j] hanya untuk i<j (segitiga atas)
        $input = $request->input('nilai', []);
        foreach ($ids as $i => $ida) {
            foreach ($ids as $j => $idb) {
                if ($i === $j) { $val = 1; }
                elseif ($i < $j) { $val = (float) ($input[$i][$j] ?? 1); }
                else { $val = 1 / ((float) ($input[$j][$i] ?? 1)); }
                AhpPerbandingan::updateOrCreate(
                    ['periode_id'=>$periode->id,'kriteria_baris_id'=>$ida,'kriteria_kolom_id'=>$idb],
                    ['nilai'=>round($val, 4)]
                );
            }
        }

        // Bangun matriks numerik & hitung
        $m = [];
        foreach ($ids as $i => $ida) {
            foreach ($ids as $j => $idb) {
                $m[$i][$j] = (float) AhpPerbandingan::where([
                    'periode_id'=>$periode->id,'kriteria_baris_id'=>$ida,'kriteria_kolom_id'=>$idb,
                ])->value('nilai');
            }
        }
        $r = $ahp->hitung($m);

        // Simpan bobot & ringkasan
        foreach ($ids as $i => $id) {
            AhpBobot::updateOrCreate(
                ['periode_id'=>$periode->id,'kriteria_id'=>$id],
                ['bobot'=>round($r['bobot'][$i], 6)]
            );
        }
        AhpRingkasan::updateOrCreate(
            ['periode_id'=>$periode->id],
            ['lambda_maks'=>round($r['lambda_maks'],4),'ci'=>round($r['ci'],4),
             'ri'=>$r['ri'],'cr'=>round($r['cr'],4),'konsisten'=>$r['konsisten'],'dihitung_pada'=>now()]
        );

        $msg = $r['konsisten']
            ? 'Bobot berhasil dihitung. CR = '.number_format($r['cr'],4).' (konsisten).'
            : 'PERINGATAN: CR = '.number_format($r['cr'],4).' > 0,10. Perbaiki penilaian.';
        return back()->with('status', $msg);
    }
}
```

**`app/Http/Controllers/Spk/PerangkinganController.php`** (peran Kabalai)
```php
namespace App\Http\Controllers\Spk;

use App\Http\Controllers\Controller;
use App\Models\{Periode, SawHasil, AhpRingkasan};
use App\Services\Spk\SawService;

class PerangkinganController extends Controller
{
    public function index()
    {
        $periode   = Periode::where('status', 1)->firstOrFail();
        $ringkasan = AhpRingkasan::where('periode_id', $periode->id)->first();
        $hasil = SawHasil::with('sekolah')
            ->where('periode_id', $periode->id)->orderBy('peringkat')->get();
        return view('spk.perangkingan.index', compact('periode','ringkasan','hasil'));
    }

    public function hitungUlang(SawService $saw)
    {
        $periode = Periode::where('status', 1)->firstOrFail();
        if (! AhpRingkasan::where('periode_id',$periode->id)->where('konsisten',true)->exists()) {
            return back()->with('status', 'Bobot AHP belum konsisten. Hitung AHP dulu (CR ≤ 0,1).');
        }
        $r = $saw->hitungDanSimpan($periode);
        return back()->with('status', 'Perangkingan selesai untuk '.$r['jumlah'].' sekolah.');
    }
}
```

**Route (`routes/web.php`)** — pakai middleware peran yang sudah ada:
```php
use App\Http\Controllers\Spk\{AhpController, PerangkinganController};

Route::middleware(['auth', 'Administrator'])->prefix('administrator/spk')->group(function () {
    Route::get('ahp', [AhpController::class, 'index'])->name('spk.ahp.index');
    Route::post('ahp/hitung', [AhpController::class, 'hitung'])->name('spk.ahp.hitung');
});

Route::middleware(['auth', 'Kabalai'])->prefix('kabalai/spk')->group(function () {
    Route::get('perangkingan', [PerangkinganController::class, 'index'])->name('spk.rank.index');
    Route::post('perangkingan/hitung', [PerangkinganController::class, 'hitungUlang'])->name('spk.rank.hitung');
});
```

---

## 9. Langkah 8 — View (kerangka)

**`resources/views/spk/ahp/index.blade.php`** (potongan inti — form segitiga atas + hasil)
```blade
@if(session('status'))<div class="alert alert-info">{{ session('status') }}</div>@endif

<form method="POST" action="{{ route('spk.ahp.hitung') }}">
  @csrf
  <table class="table table-bordered text-center">
    <tr><th></th>@foreach($kriteria as $k)<th>{{ $k->kode }}</th>@endforeach</tr>
    @foreach($kriteria as $i => $baris)
      <tr><th>{{ $baris->kode }}</th>
        @foreach($kriteria as $j => $kolom)
          @if($i === $j)
            <td>1</td>
          @elseif($i < $j)
            <td><input type="number" step="0.0001" min="0.11" name="nilai[{{ $i }}][{{ $j }}]"
                 value="{{ optional($sel->get($baris->id.'-'.$kolom->id))->nilai ?? 1 }}" class="form-control form-control-sm"></td>
          @else
            <td class="text-muted">1/({{ $baris->kode }},{{ $kolom->kode }})</td>
          @endif
        @endforeach
      </tr>
    @endforeach
  </table>
  <button class="btn btn-primary">Hitung Bobot</button>
</form>

@if($ringkasan)
  <p>λmaks = {{ $ringkasan->lambda_maks }} · CI = {{ $ringkasan->ci }} ·
     CR = <b>{{ $ringkasan->cr }}</b>
     <span class="badge bg-{{ $ringkasan->konsisten ? 'success' : 'danger' }}">
       {{ $ringkasan->konsisten ? 'Konsisten' : 'Tidak konsisten' }}</span></p>
  <table class="table"><tr><th>Kriteria</th><th>Bobot</th></tr>
    @foreach($kriteria as $k)
      <tr><td>{{ $k->kode }} — {{ $k->nama }}</td>
          <td>{{ number_format($bobot[$k->id] ?? 0, 4) }}</td></tr>
    @endforeach
  </table>
@endif
```

**`resources/views/spk/perangkingan/index.blade.php`** (tabel peringkat)
```blade
@if(session('status'))<div class="alert alert-info">{{ session('status') }}</div>@endif
<form method="POST" action="{{ route('spk.rank.hitung') }}">@csrf
  <button class="btn btn-success mb-3">Hitung Ulang Perangkingan</button></form>

<table class="table table-striped">
  <tr><th>Peringkat</th><th>Sekolah</th><th>C1</th><th>C2</th><th>C3</th><th>C4</th><th>C5</th><th>Vi</th></tr>
  @foreach($hasil as $h)
    <tr @class(['table-warning' => $h->peringkat <= 10])>
      <td>{{ $h->peringkat }}</td><td>{{ $h->sekolah->nama }}</td>
      <td>{{ $h->skor['C1'] }}</td><td>{{ $h->skor['C2'] }}</td><td>{{ $h->skor['C3'] }}</td>
      <td>{{ $h->skor['C4'] }}</td><td>{{ $h->skor['C5'] }}</td>
      <td>{{ number_format($h->nilai_vi, 4) }}</td>
    </tr>
  @endforeach
</table>
```

---

## 10. Langkah 9 — Alur eksekusi end-to-end (peta ke skripsi)

1. **Kepala Balai mengisi kuesioner** perbandingan berpasangan (Lampiran) → nilai skala Saaty.
2. **Administrator** membuka `spk/ahp`, memasukkan nilai segitiga atas, menekan **Hitung Bobot** → `AhpService` menghasilkan bobot + CR (disimpan). *(Ini realisasi diagram alur AHP pada Bab III.)*
3. Jika **CR ≤ 0,1**, bobot dinyatakan valid.
4. **Kabalai** membuka `spk/perangkingan`, menekan **Hitung Ulang** → `SawService`: setiap SMA dikonversi ke skor 1–5 (`RubrikKebutuhan`) → normalisasi *benefit* → `Vi = Σ Wj·rij` → diurutkan → disimpan. *(Realisasi diagram alur SAW pada Bab III.)*
5. Tabel peringkat tampil; 10 teratas adalah prioritas penerima bantuan.

---

## 11. Langkah 10 — Verifikasi hasil (wajib sebelum sidang)

Pastikan sistem mereproduksi Excel. Jalankan `php artisan tinker`:
```php
$k = App\Models\Kriteria::orderBy('urutan')->pluck('id')->values();
$p = App\Models\Periode::where('status',1)->first();
$m = [];
foreach ($k as $i=>$a) foreach ($k as $j=>$b)
  $m[$i][$j] = (float) App\Models\AhpPerbandingan::where(
     ['periode_id'=>$p->id,'kriteria_baris_id'=>$a,'kriteria_kolom_id'=>$b])->value('nilai');
$r = app(App\Services\Spk\AhpService::class)->hitung($m);
array_map(fn($b)=>round($b,4), $r['bobot']);  // ≈ [0.4011, 0.1051, 0.2681, 0.1631, 0.0626]
round($r['cr'],4);                            // ≈ 0.0192
```
Bobot dan CR harus sama dengan §1.4. Setelah `SawService` dijalankan, peringkat 1 seharusnya **SMA Muhammadiyah Patinea** (Vi ≈ 0,9159) dan terbawah Vi ≈ 0,2125 — cocokkan dengan `hasil_saw_prioritas_tik_sma.xlsx`.

Disarankan juga membuat *feature test* (`tests/Feature/AhpSawTest.php`) yang menegaskan `assertEqualsWithDelta(0.4011, $bobot['C1'], 0.001)` dan `assertTrue($cr <= 0.10)`.

---

## 12. Keputusan/penyesuaian yang perlu kamu tetapkan

Beberapa hal sengaja dibuat fleksibel; tetapkan sesuai kondisi datamu:

1. **Nama basis data.** Deskripsi sistem menyebut `emonev`, berkas SQL bernama `db_emoneva`. Samakan `.env` (`DB_DATABASE`) dengan yang benar-benar dipakai.
2. **Filter data SAW.** Pada data seeder saat ini, hampir semua SMA masih `status_verifikasi = 0` dan `tahun = null`. Agar 64 SMA tetap terproses (mereproduksi Excel), biarkan filter verifikasi & periode **nonaktif** (seperti kode di §7). Untuk produksi, aktifkan `status_verifikasi = 2` dan isi `sekolah.tahun` sesuai periode — atau, pada seeder data, set kedua kolom itu agar konsisten dengan skenario tervalidasi.
3. **Metode bobot.** Default = rata-rata geometrik (angka Excel). Bila ingin persis sesuai kalimat Bab III, aktifkan blok alternatif "normalisasi kolom" di `AhpService` (selisih ≤ 0,18 poin persen, peringkat tetap).
4. **Cakupan jenjang.** SAW difilter `tingkatan = 'SMA'` sesuai populasi skripsi. Bila kelak ingin memasukkan SMK/SLB, cukup longgarkan filter ini.

---

*Selesai. Ikuti langkah 1→10 berurutan; setiap service sudah diisolasi sehingga mudah diuji satuan. Angka pada §1 adalah acuan tunggal—jangan diubah bila ingin hasil identik dengan Excel dan skripsi.*

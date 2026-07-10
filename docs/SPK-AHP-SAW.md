# 📗 Dokumentasi Sistem Pendukung Keputusan (SPK) untuk emoneva
### Penentuan Prioritas Sekolah Penerima Bantuan TIK — Metode **AHP + SAW**

> **Status:** Dokumen rancangan / bahan pembelajaran (belum diimplementasikan)
> **Sistem induk:** emoneva — e-Monitoring & Evaluasi Infrastruktur TIK Sekolah
> **Framework:** Laravel 11.x
> **Tanggal disusun:** 10 Juli 2026

---

## Daftar Isi

1. [Ringkasan Eksekutif](#1-ringkasan-eksekutif)
2. [Apa Itu SPK dan Mengapa emoneva Membutuhkannya](#2-apa-itu-spk-dan-mengapa-emoneva-membutuhkannya)
3. [Mengenal Sistem emoneva Saat Ini](#3-mengenal-sistem-emoneva-saat-ini)
4. [Objek Keputusan yang Didukung](#4-objek-keputusan-yang-didukung)
5. [Mengapa Memilih AHP + SAW](#5-mengapa-memilih-ahp--saw)
6. [Cara Kerja Metode AHP](#6-cara-kerja-metode-ahp)
7. [Cara Kerja Metode SAW](#7-cara-kerja-metode-saw)
8. [Hubungan AHP dan SAW (Alur Gabungan)](#8-hubungan-ahp-dan-saw-alur-gabungan)
9. [Penerapan pada emoneva: Kriteria & Konversi Data](#9-penerapan-pada-emoneva-kriteria--konversi-data)
10. [Studi Kasus Perhitungan Lengkap (End-to-End)](#10-studi-kasus-perhitungan-lengkap-end-to-end)
11. [Rancangan Integrasi Teknis (High-Level)](#11-rancangan-integrasi-teknis-high-level)
12. [Alur Kerja Pengguna (Role Kabalai)](#12-alur-kerja-pengguna-role-kabalai)
13. [Keunggulan, Batasan, dan Catatan Penting](#13-keunggulan-batasan-dan-catatan-penting)
14. [Glosarium & Referensi](#14-glosarium--referensi)
15. [Peta Langkah Implementasi (Untuk Besok)](#15-peta-langkah-implementasi-untuk-besok)

---

## 1. Ringkasan Eksekutif

emoneva saat ini sudah mengumpulkan data lengkap kondisi sekolah (listrik, laboratorium komputer, internet, riwayat bantuan, kondisi geografis, jumlah siswa, akreditasi, status UNBK). Namun keputusan **"sekolah mana yang paling layak diprioritaskan menerima bantuan TIK"** masih dilakukan secara manual dan hanya bisa mengurutkan sekolah berdasarkan **satu kriteria pada satu waktu** (mis. hanya listrik, atau hanya internet).

Sistem Pendukung Keputusan (SPK) yang diusulkan menggabungkan **banyak kriteria sekaligus** menjadi **satu skor prioritas** dan **peringkat** yang objektif, konsisten, dan dapat dipertanggungjawabkan, menggunakan kombinasi dua metode:

- **AHP (Analytic Hierarchy Process)** → untuk **menentukan bobot** setiap kriteria secara ilmiah melalui perbandingan berpasangan oleh pihak Balai (pakar), sekaligus **menguji konsistensi** penilaian.
- **SAW (Simple Additive Weighting)** → untuk **menghitung skor & merangking** setiap sekolah berdasarkan bobot dari AHP.

Hasil akhir: daftar sekolah terurut dari prioritas tertinggi ke terendah, lengkap dengan kategori (Tinggi / Sedang / Rendah), yang ditampilkan di dashboard **Kabalai**.

---

## 2. Apa Itu SPK dan Mengapa emoneva Membutuhkannya

### 2.1 Definisi SPK

**Sistem Pendukung Keputusan (Decision Support System)** adalah sistem berbasis komputer yang membantu pengambil keputusan mengolah data dan model untuk **memecahkan masalah semi-terstruktur**. SPK **tidak menggantikan** manusia sebagai pengambil keputusan, melainkan **memberi rekomendasi terukur** agar keputusan lebih objektif, cepat, dan konsisten.

Masalah "pemilihan penerima bantuan" termasuk **masalah semi-terstruktur**: sebagian bisa dihitung (data listrik, jumlah PC), sebagian butuh pertimbangan kebijakan (seberapa penting akreditasi dibanding kondisi geografis). Inilah tipe masalah yang paling cocok untuk SPK.

### 2.2 Masalah Nyata di emoneva Tanpa SPK

| Masalah Saat Ini | Dampak |
|---|---|
| Penilaian hanya per-kriteria (listrik saja / internet saja) | Tidak ada gambaran menyeluruh; sekolah yang buruk di banyak aspek bisa terlewat |
| Keputusan prioritas bersifat subjektif | Rawan bias, sulit dipertanggungjawabkan saat diaudit |
| Bobot kepentingan antar-kriteria tidak baku | Setiap petugas bisa punya "pertimbangan" berbeda |
| Tidak ada skor/ranking baku | Sulit menjelaskan *mengapa* sekolah A didahulukan daripada B |

### 2.3 Nilai Tambah Setelah Ada SPK

- **Objektif** — semua sekolah dinilai dengan rumus dan bobot yang sama.
- **Transparan** — setiap skor dapat dirinci per kriteria ("mengapa sekolah ini prioritas").
- **Konsisten** — AHP memastikan bobot antar-kriteria logis (lewat *Consistency Ratio*).
- **Cepat** — ranking ratusan sekolah dihitung otomatis per periode.
- **Akuntabel** — hasil dapat diarsipkan per `periode` sebagai dasar pengambilan keputusan.

---

## 3. Mengenal Sistem emoneva Saat Ini

Agar SPK menyatu dengan sistem, berikut pemetaan komponen emoneva yang relevan.

### 3.1 Peran (Role) Pengguna

| Role | Middleware | Tugas Terkait Bantuan |
|---|---|---|
| **Administrator** | `Administrator` | Kelola data master (kota, kecamatan, periode, sekolah, user) |
| **Operator Sekolah** | `Operator` | Mengisi data sekolahnya (identitas, sosekbud, fasilitas TIK, riwayat bantuan) lalu **mengajukan verifikasi** |
| **Verifikator** | `Verifikator` | Memverifikasi kebenaran data sekolah + monitoring |
| **Kabalai** (Kepala Balai) | `Kabalai` | Melihat dashboard, mengurutkan/memfilter sekolah → **calon pengguna utama SPK** |

> Sumber: `routes/web.php`, `app/Http/Middleware/{Administrator,Operator,Verifikator,Kabalai}.php`, kolom `users.role` (1=Administrator, 2=Verifikator, 3=Operator Sekolah, 4=Kabalai).

### 3.2 Data yang Sudah Tersedia (Bahan Baku Kriteria SPK)

Seluruh kriteria SPK **dapat diambil dari tabel yang sudah ada** — tidak perlu mengumpulkan data baru.

| Tabel / Kolom | Isi | Potensi Kriteria SPK |
|---|---|---|
| `sekolah` — `status_akreditasi`, `jum_siswa_pria`, `jum_siswa_wanita`, `jum_guru`, `unbk_status`, `status_verifikasi` | Identitas & profil sekolah | Akreditasi, jumlah siswa terdampak, status UNBK, filter kelayakan (harus terverifikasi) |
| `sekolah_fasilitastik` — `listrik_status`, `listrik_durasi`, `jumlah_kom`, `labkom_status`, `internet_status`, `internet_bandwith`, `internet_kesesuaian` | Kondisi infrastruktur TIK | Kriteria listrik, komputer/lab, internet |
| `sekolah_fasilitastik_lab` — `labkom_jumlah_pc` | Detail jumlah PC per lab | Rasio PC : siswa |
| `sekolah_bantuan_status` + `sekolah_bantuan_detail` | Riwayat bantuan yang pernah diterima | Kriteria "sudah/belum pernah dibantu" |
| `sekolah_sosekbud` — `kondisi_geografis`, `kondisi_sosekbud`, `akses_transportasi` | Kondisi geografis & sosial | Kriteria keterpencilan / aksesibilitas |
| `periode` — `tahun`, `status` | Periode penilaian aktif | Penanda tahun perhitungan SPK |

### 3.3 Alur Data Eksisting

```
Operator Sekolah  ──isi data──▶  (identitas, sosekbud, fasilitas TIK, bantuan)
        │
        └── ajukan verifikasi ──▶  Verifikator  ──verifikasi──▶  status_verifikasi = terverifikasi
                                                                        │
                                                                        ▼
                                                    Kabalai melihat data & mengurutkan
                                                    (SAAT INI: per-kriteria satu per satu)
                                                                        │
                                                          ⬇  DI SINI SPK MASUK  ⬇
                                                    SPK menggabungkan semua kriteria →
                                                    skor prioritas + ranking otomatis
```

**Prinsip penting:** SPK hanya memproses sekolah yang **sudah terverifikasi** pada **periode aktif**, agar keputusan berbasis data yang sah.

---

## 4. Objek Keputusan yang Didukung

> **Keputusan:** *"Sekolah mana yang harus diprioritaskan untuk menerima bantuan infrastruktur TIK pada periode ini?"*

- **Alternatif (yang dinilai):** daftar sekolah terverifikasi pada periode aktif.
- **Kriteria (dasar penilaian):** kondisi listrik, lab/komputer, internet, riwayat bantuan, keterpencilan, jumlah siswa terdampak, dll. (rinci di [Bagian 9](#9-penerapan-pada-emoneva-kriteria--konversi-data)).
- **Tujuan:** memaksimalkan **ketepatan sasaran** — bantuan jatuh ke sekolah yang paling membutuhkan.
- **Keluaran:** skor prioritas (0–1), peringkat, dan kategori (Tinggi/Sedang/Rendah) per sekolah.

Pengambil keputusan tetap **Kabalai** — SPK memberi rekomendasi, keputusan final tetap di tangan manusia.

---

## 5. Mengapa Memilih AHP + SAW

### 5.1 Sifat Masalah = MCDM

Ini adalah masalah **Multi-Criteria Decision Making (MCDM)**: banyak **alternatif** (sekolah) dinilai atas banyak **kriteria**. Keluarga metode yang tepat: AHP, SAW, WP, TOPSIS, dsb. Kita memakai **dua metode yang saling melengkapi**, bukan bersaing.

### 5.2 Peran Masing-Masing Metode

| Metode | Menjawab pertanyaan | Perannya di emoneva |
|---|---|---|
| **AHP** | "Seberapa **penting** tiap kriteria dibanding kriteria lain?" | Menghasilkan **bobot** kriteria + uji konsistensi |
| **SAW** | "Berdasarkan bobot itu, sekolah mana yang **paling prioritas**?" | Menghitung **skor & ranking** sekolah |

Analogi: **AHP menentukan "timbangannya", SAW melakukan "penimbangan".**

### 5.3 Mengapa AHP untuk Pembobotan

- **Ilmiah & dapat dipertanggungjawabkan.** Bobot tidak ditebak, tetapi diturunkan dari perbandingan berpasangan oleh pihak Balai (pakar domain).
- **Ada uji konsistensi (Consistency Ratio).** AHP satu-satunya yang bisa **mendeteksi penilaian yang tidak logis** (mis. A>B, B>C, tetapi C>A). Jika CR > 10%, penilaian harus diperbaiki. Ini memberi legitimasi kuat pada laporan/skripsi.
- **Terstruktur hierarkis.** Cocok karena keputusan bantuan memang punya hierarki: Tujuan → Kriteria → Alternatif.

### 5.4 Mengapa SAW untuk Perankingan

- **Sederhana & mudah dijelaskan.** Konsepnya "jumlah terbobot dari nilai ternormalisasi" — mudah dipahami penguji maupun pihak Balai.
- **Cocok dengan data emoneva.** Setelah kondisi sekolah dikonversi ke skor (1–5), SAW menormalisasi dan menjumlahkannya secara langsung.
- **Cepat dihitung** untuk ratusan sekolah.
- **Transparan.** Kontribusi tiap kriteria terhadap skor akhir bisa ditampilkan apa adanya.

### 5.5 Mengapa Kombinasi, Bukan Salah Satu Saja

| Jika hanya... | Kelemahan |
|---|---|
| **SAW saja** | Bobot ditentukan manual/subjektif, tanpa uji konsistensi → mudah dibantah |
| **AHP saja** | Perankingan alternatif via AHP murni menjadi **sangat panjang** bila alternatif (sekolah) banyak — butuh perbandingan berpasangan tiap pasang sekolah pada tiap kriteria (tidak praktis untuk ratusan sekolah) |
| **AHP + SAW** ✅ | AHP dipakai hanya untuk bobot (jumlah kriteria sedikit → praktis), SAW menangani perankingan banyak sekolah (efisien). **Saling menutupi kelemahan.** |

### 5.6 Perbandingan Singkat dengan Alternatif Lain

| Metode | Kelebihan | Kekurangan untuk kasus ini |
|---|---|---|
| **AHP + SAW** ✅ | Bobot ilmiah + perankingan sederhana & transparan | Konversi data kategorik → skor perlu rubrik yang disepakati |
| AHP + TOPSIS | Terlihat lebih "canggih" (jarak ke solusi ideal) | Lebih kompleks dijelaskan; hasil sering mirip SAW |
| SAW murni | Paling sederhana | Bobot tidak teruji konsistensi |
| WP (Weighted Product) | Baik untuk kriteria berdimensi beda | Perkalian pangkat kurang intuitif dijelaskan |

**Kesimpulan:** untuk emoneva pada tahap ini, **AHP (bobot) + SAW (ranking)** adalah keseimbangan terbaik antara *ketelitian ilmiah* dan *kesederhanaan implementasi & penjelasan*.

---

## 6. Cara Kerja Metode AHP

**AHP (Analytic Hierarchy Process)** dikembangkan oleh **Thomas L. Saaty (1980)**. Tujuannya: mengubah penilaian kualitatif ("kriteria A lebih penting dari B") menjadi **bobot numerik** yang konsisten.

### 6.1 Langkah 1 — Menyusun Hierarki

```
                 TUJUAN
   "Prioritas Sekolah Penerima Bantuan TIK"
                    │
   ┌──────┬─────────┼─────────┬──────────┐
   ▼      ▼         ▼         ▼          ▼
 Listrik  Lab/    Internet  Riwayat   Keterpencilan ...
          Komputer          Bantuan
                    │
                    ▼
   Alternatif: Sekolah A, Sekolah B, Sekolah C, ...
```

### 6.2 Langkah 2 — Perbandingan Berpasangan (Skala Saaty)

Pihak Balai membandingkan **tingkat kepentingan tiap pasang kriteria** memakai **skala Saaty 1–9**:

| Nilai | Arti |
|---|---|
| 1 | Kedua kriteria sama penting |
| 3 | Kriteria A sedikit lebih penting dari B |
| 5 | Kriteria A lebih penting dari B |
| 7 | Kriteria A jauh lebih penting dari B |
| 9 | Kriteria A mutlak lebih penting dari B |
| 2,4,6,8 | Nilai antara (kompromi) |
| Kebalikan (1/3, 1/5, …) | Jika B yang lebih penting dari A |

Hasilnya adalah **matriks perbandingan berpasangan** berukuran *n × n* (n = jumlah kriteria). Elemen diagonal selalu 1, dan elemen bawah adalah kebalikan elemen atas (`a[j][i] = 1 / a[i][j]`).

### 6.3 Langkah 3 — Menghitung Bobot (Prioritas)

1. **Jumlahkan tiap kolom** matriks.
2. **Normalisasi**: bagi tiap elemen dengan jumlah kolomnya.
3. **Bobot kriteria** = rata-rata tiap baris matriks ternormalisasi (disebut *priority vector* / *eigenvector*).

Bobot ini berjumlah = 1 (100%).

### 6.4 Langkah 4 — Uji Konsistensi (Bagian Terpenting)

AHP memverifikasi bahwa penilaian tidak saling bertentangan:

1. Hitung **λ maks (lambda maksimum)** = rata-rata dari (baris hasil perkalian matriks × bobot, dibagi bobot).
2. **Consistency Index:**
   `CI = (λmaks − n) / (n − 1)`
3. **Consistency Ratio:**
   `CR = CI / RI`
   dengan **RI (Random Index)** dari tabel Saaty:

   | n | 1 | 2 | 3 | 4 | 5 | 6 | 7 | 8 | 9 | 10 |
   |---|---|---|---|---|---|---|---|---|---|----|
   | RI | 0 | 0 | 0.58 | 0.90 | 1.12 | 1.24 | 1.32 | 1.41 | 1.45 | 1.49 |

4. **Aturan:** jika **CR ≤ 0.10 (10%)** → penilaian **konsisten & dapat diterima**. Jika CR > 10% → penilaian harus **diperbaiki** (ulangi perbandingan berpasangan).

> Inilah keunggulan AHP: bobot bukan sekadar angka, tapi angka yang **sudah lolos uji logika**.

---

## 7. Cara Kerja Metode SAW

**SAW (Simple Additive Weighting)**, dikenal juga sebagai **metode penjumlahan terbobot**, adalah metode MCDM paling dasar dan paling banyak dipakai. Intinya: **skor akhir = penjumlahan dari (bobot × nilai ternormalisasi) tiap kriteria.**

### 7.1 Langkah 1 — Matriks Keputusan

Susun matriks **X** berukuran *m × n* (m = jumlah sekolah, n = jumlah kriteria). Setiap sel `x[i][j]` = nilai sekolah *i* pada kriteria *j*. (Data kategorik emoneva dikonversi dulu ke angka — lihat [Bagian 9](#9-penerapan-pada-emoneva-kriteria--konversi-data).)

### 7.2 Langkah 2 — Normalisasi

Ubah semua nilai ke skala 0–1 agar sebanding, dengan membedakan sifat kriteria:

- **Benefit** (semakin besar semakin baik/diprioritaskan):
  `r[i][j] = x[i][j] / max(x[·][j])`
- **Cost** (semakin kecil semakin baik/diprioritaskan):
  `r[i][j] = min(x[·][j]) / x[i][j]`

> **Catatan penting untuk emoneva:** kita menggunakan pendekatan **"skor kebutuhan"** — data kondisi sekolah dikonversi ke skor 1–5 di mana **semakin tinggi = semakin membutuhkan bantuan**. Dengan begitu **semua kriteria menjadi benefit** terhadap tujuan "prioritas bantuan", sehingga normalisasi seragam memakai rumus benefit. Ini menyederhanakan implementasi dan penjelasan. (Alternatif: pakai nilai mentah dengan pembedaan cost/benefit — hasil setara bila rubrik dirancang benar.)

### 7.3 Langkah 3 — Menghitung Nilai Preferensi (Skor Akhir)

Untuk tiap sekolah *i*:

```
V[i] = Σ ( w[j] × r[i][j] )   untuk j = 1..n
```

dengan `w[j]` = bobot kriteria *j* **(diperoleh dari AHP)**.

### 7.4 Langkah 4 — Perankingan

Urutkan `V[i]` dari **terbesar ke terkecil**. Sekolah dengan `V` tertinggi = **prioritas utama** penerima bantuan. Skor bisa dipetakan ke kategori, mis.:

| Rentang Skor V | Kategori Prioritas |
|---|---|
| 0.70 – 1.00 | **Tinggi** |
| 0.40 – 0.69 | **Sedang** |
| 0.00 – 0.39 | **Rendah** |

*(Ambang kategori dapat disesuaikan kebijakan Balai.)*

---

## 8. Hubungan AHP dan SAW (Alur Gabungan)

```
┌─────────────────────────── TAHAP 1: AHP (Pembobotan) ───────────────────────────┐
│                                                                                  │
│  Balai/Pakar  ──▶  Perbandingan berpasangan antar-KRITERIA (skala Saaty 1–9)     │
│                          │                                                       │
│                          ▼                                                       │
│               Matriks perbandingan ──▶ Normalisasi ──▶ BOBOT (w1..wn)            │
│                          │                                                       │
│                          ▼                                                       │
│               Uji Konsistensi (CR ≤ 10%?) ──[tidak]──▶ perbaiki penilaian        │
│                          │ [ya]                                                  │
└──────────────────────────┼──────────────────────────────────────────────────────┘
                           │  bobot final w1..wn
                           ▼
┌─────────────────────────── TAHAP 2: SAW (Perankingan) ──────────────────────────┐
│                                                                                  │
│  Data sekolah ──▶ Konversi ke skor ──▶ Matriks keputusan X                       │
│                          │                                                       │
│                          ▼                                                       │
│               Normalisasi (R) ──▶ V[i] = Σ (w[j] × r[i][j])                       │
│                          │                                                       │
│                          ▼                                                       │
│               RANKING sekolah + kategori prioritas                               │
└──────────────────────────────────────────────────────────────────────────────────┘
```

**Poin kunci:** keluaran AHP (bobot) menjadi masukan SAW. AHP dijalankan **jarang** (saat Balai menetapkan/mengubah kebijakan bobot), sedangkan SAW dijalankan **tiap periode** untuk merangking sekolah dengan data terbaru.

---

## 9. Penerapan pada emoneva: Kriteria & Konversi Data

### 9.1 Usulan Kriteria (dari data yang sudah ada)

| Kode | Kriteria | Sumber Data | Contoh Bobot (AHP) |
|---|---|---|---|
| C1 | Kondisi listrik | `sekolah_fasilitastik.listrik_status`, `listrik_durasi` | 0.20 |
| C2 | Ketersediaan lab & rasio komputer | `labkom_status`, `jumlah_kom`, `sekolah_fasilitastik_lab.labkom_jumlah_pc`, `jum_siswa_*` | 0.20 |
| C3 | Kondisi internet | `internet_status`, `internet_bandwith`, `internet_kesesuaian` | 0.20 |
| C4 | Riwayat bantuan | `sekolah_bantuan_status.status` | 0.15 |
| C5 | Keterpencilan / aksesibilitas | `sekolah_sosekbud.kondisi_geografis`, `akses_transportasi` | 0.10 |
| C6 | Jumlah siswa terdampak | `jum_siswa_pria + jum_siswa_wanita` | 0.10 |
| C7 | Kesiapan/urgensi UNBK & akreditasi | `unbk_status`, `status_akreditasi` | 0.05 |

> Bobot di atas hanya **contoh**. Bobot final wajib dihitung lewat AHP oleh pihak Balai. Total bobot = 1.00.

### 9.2 Rubrik Konversi Data → Skor Kebutuhan (1–5)

Prinsip: **semakin buruk kondisi / semakin butuh → skor semakin tinggi.**

**C1 — Kondisi Listrik**
| Kondisi | Skor |
|---|---|
| Tidak ada listrik | 5 |
| Ada, durasi sangat terbatas (mis. < 6 jam) | 4 |
| Ada, sering padam / tidak stabil | 3 |
| Ada, cukup stabil | 2 |
| Ada, stabil penuh (PLN 24 jam) | 1 |

**C2 — Lab & Rasio Komputer** (berdasarkan ketersediaan lab dan rasio PC : siswa)
| Kondisi | Skor |
|---|---|
| Tidak ada lab komputer | 5 |
| Ada lab, rasio PC sangat kurang | 4 |
| Ada lab, rasio kurang | 3 |
| Ada lab, rasio cukup | 2 |
| Ada lab, rasio memadai | 1 |

**C3 — Kondisi Internet**
| Kondisi | Skor |
|---|---|
| Tidak ada internet | 5 |
| Ada, bandwidth rendah & tidak sesuai kebutuhan | 4 |
| Ada, kadang tidak sesuai | 3 |
| Ada, cukup sesuai | 2 |
| Ada, memadai & sesuai | 1 |

**C4 — Riwayat Bantuan**
| Kondisi | Skor |
|---|---|
| Belum pernah menerima bantuan | 5 |
| Pernah, sudah lama (mis. > 5 tahun) | 3 |
| Baru saja menerima bantuan | 1 |

**C5 — Keterpencilan / Aksesibilitas**
| Kondisi | Skor |
|---|---|
| Sangat terpencil, akses transportasi sulit | 5 |
| Terpencil / akses terbatas | 3 |
| Mudah diakses / perkotaan | 1 |

**C6 — Jumlah Siswa Terdampak** (bisa langsung numerik lalu dinormalisasi, atau dikelompokkan)
| Jumlah siswa | Skor |
|---|---|
| Sangat banyak (mis. > 500) | 5 |
| Banyak (301–500) | 4 |
| Sedang (151–300) | 3 |
| Sedikit (51–150) | 2 |
| Sangat sedikit (≤ 50) | 1 |

**C7 — Urgensi UNBK / Akreditasi**
| Kondisi | Skor |
|---|---|
| Belum bisa UNBK mandiri & akreditasi rendah | 5 |
| Salah satu terpenuhi | 3 |
| Sudah UNBK mandiri & akreditasi baik | 1 |

> Rubrik ini adalah **titik yang paling perlu disepakati** dengan pembimbing/pihak Balai, karena menentukan validitas hasil. Simpan rubrik di tabel referensi agar mudah diaudit.

---

## 10. Studi Kasus Perhitungan Lengkap (End-to-End)

Contoh disederhanakan menjadi **4 kriteria** (C1 Listrik, C2 Lab/Komputer, C3 Internet, C4 Riwayat Bantuan) dan **3 sekolah** agar aritmetikanya mudah diikuti. Prinsipnya identik untuk 7 kriteria & ratusan sekolah.

### 10.1 TAHAP AHP — Menentukan Bobot

**Matriks perbandingan berpasangan** (penilaian pihak Balai, skala Saaty):

| | C1 | C2 | C3 | C4 |
|---|---|---|---|---|
| **C1** | 1 | 2 | 3 | 4 |
| **C2** | 1/2 | 1 | 2 | 3 |
| **C3** | 1/3 | 1/2 | 1 | 2 |
| **C4** | 1/4 | 1/3 | 1/2 | 1 |

*Membaca:* C1 (listrik) dinilai **sedikit lebih penting** dari C2 (nilai 2), **lebih penting** dari C3 (nilai 3), dst.

**Langkah 1 — Jumlah tiap kolom:**

| | C1 | C2 | C3 | C4 |
|---|---|---|---|---|
| Jumlah | 2.0833 | 3.8333 | 6.5000 | 10.0000 |

**Langkah 2 — Normalisasi (tiap sel ÷ jumlah kolom) & rata-rata baris = bobot:**

| | C1 | C2 | C3 | C4 | **Bobot (rata-rata)** |
|---|---|---|---|---|---|
| **C1** | 0.480 | 0.522 | 0.462 | 0.400 | **0.4658** |
| **C2** | 0.240 | 0.261 | 0.308 | 0.300 | **0.2772** |
| **C3** | 0.160 | 0.130 | 0.154 | 0.200 | **0.1611** |
| **C4** | 0.120 | 0.087 | 0.077 | 0.100 | **0.0960** |

➡ **Bobot final: W = [0.4658, 0.2772, 0.1611, 0.0960]** (total = 1.000)

**Langkah 3 — Uji Konsistensi:**

- Hitung λ untuk tiap baris (perkalian matriks awal × bobot, dibagi bobotnya):
  - Baris C1 → 4.052
  - Baris C2 → 4.041
  - Baris C3 → 4.016
  - Baris C4 → 4.016
- **λmaks** = (4.052 + 4.041 + 4.016 + 4.016) / 4 = **4.031**
- **CI** = (4.031 − 4) / (4 − 1) = 0.031 / 3 = **0.0103**
- **RI** (n=4) = **0.90**
- **CR** = 0.0103 / 0.90 = **0.0115 ≈ 1.15%**

✅ **CR = 1.15% < 10% → penilaian KONSISTEN.** Bobot dapat dipakai.

### 10.2 TAHAP SAW — Merangking Sekolah

**Data 3 sekolah** setelah dikonversi ke skor kebutuhan (1–5), semua kriteria bersifat *benefit* terhadap tujuan:

| Sekolah | C1 | C2 | C3 | C4 |
|---|---|---|---|---|
| **A** (SD terpencil, tanpa listrik & lab, belum pernah dibantu) | 5 | 5 | 5 | 5 |
| **B** (SMP pinggiran, listrik ada tapi tidak stabil) | 3 | 4 | 3 | 5 |
| **C** (SMA kota, sudah pernah dibantu) | 1 | 2 | 1 | 1 |

**Langkah 1 — Nilai maksimum tiap kolom (benefit):** C1=5, C2=5, C3=5, C4=5

**Langkah 2 — Normalisasi (r = x / max):**

| Sekolah | C1 | C2 | C3 | C4 |
|---|---|---|---|---|
| **A** | 1.00 | 1.00 | 1.00 | 1.00 |
| **B** | 0.60 | 0.80 | 0.60 | 1.00 |
| **C** | 0.20 | 0.40 | 0.20 | 0.20 |

**Langkah 3 — Skor V = Σ (bobot × nilai ternormalisasi):**

Bobot W = [0.4658, 0.2772, 0.1611, 0.0960]

- **V(A)** = (0.4658×1) + (0.2772×1) + (0.1611×1) + (0.0960×1) = **1.000**
- **V(B)** = (0.4658×0.60) + (0.2772×0.80) + (0.1611×0.60) + (0.0960×1.00)
  = 0.2795 + 0.2218 + 0.0967 + 0.0960 = **0.694**
- **V(C)** = (0.4658×0.20) + (0.2772×0.40) + (0.1611×0.20) + (0.0960×0.20)
  = 0.0932 + 0.1109 + 0.0322 + 0.0192 = **0.256**

**Langkah 4 — Ranking & Kategori:**

| Peringkat | Sekolah | Skor V | Kategori |
|---|---|---|---|
| 🥇 1 | **Sekolah A** | 1.000 | **Tinggi** |
| 🥈 2 | **Sekolah B** | 0.694 | **Sedang** |
| 🥉 3 | **Sekolah C** | 0.256 | **Rendah** |

➡ **Kesimpulan:** Sekolah A paling diprioritaskan menerima bantuan TIK, disusul B, lalu C. Setiap skor dapat dirinci per kriteria sehingga Kabalai bisa menjelaskan *mengapa* A didahulukan.

---

## 11. Rancangan Integrasi Teknis (High-Level)

> Bagian ini **rancangan**, bukan kode final. Detail implementasi dikerjakan pada tahap berikutnya.

### 11.1 Skema Tabel Baru (Usulan)

**`spk_kriteria`** — menyimpan definisi kriteria & bobot hasil AHP
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| kode | string | C1, C2, … |
| nama | string | mis. "Kondisi Listrik" |
| bobot | decimal(6,4) | hasil AHP (total semua baris = 1) |
| tipe | enum('benefit','cost') | default 'benefit' (pendekatan skor kebutuhan) |
| aktif | boolean | |
| timestamps | | |

**`spk_ahp_perbandingan`** *(opsional, jika bobot dihitung di dalam sistem)* — menyimpan matriks perbandingan berpasangan
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| kriteria_baris_id | FK → spk_kriteria | |
| kriteria_kolom_id | FK → spk_kriteria | |
| nilai | decimal(6,4) | nilai skala Saaty (mis. 2, 0.5) |
| timestamps | | |

**`spk_hasil`** — menyimpan skor & ranking per sekolah per periode
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| sekolah_id | FK → sekolah | |
| periode_id | FK → periode | |
| skor | decimal(8,5) | nilai V hasil SAW |
| peringkat | integer | 1 = tertinggi |
| kategori | enum('tinggi','sedang','rendah') | |
| rincian | json | skor per kriteria (untuk transparansi) |
| dihitung_pada | timestamp | |

### 11.2 Lapisan Service (Usulan)

```
app/Services/SPK/
├── AhpWeightService.php
│     • buildMatriks(), hitungBobot(), hitungKonsistensi() → CR
│     • output: bobot per kriteria + status konsisten/tidak
│
├── KonversiKriteriaService.php
│     • ubah data mentah sekolah (listrik, lab, internet, dst.) → skor 1–5
│     • satu tempat berisi seluruh rubrik konversi
│
└── SawRankingService.php
      • bangun matriks keputusan, normalisasi, hitung V, ranking, kategori
      • simpan ke spk_hasil
```

### 11.3 Controller & Route (Menempel ke grup `Kabalai` yang sudah ada)

```php
// routes/web.php — di dalam grup middleware 'Kabalai'
Route::get('/spk/bobot',   [SpkController::class, 'bobot'])->name('spk.bobot');      // kelola/lihat bobot AHP
Route::post('/spk/bobot',  [SpkController::class, 'simpanBobot'])->name('spk.bobot.simpan');
Route::get('/spk/ranking', [SpkController::class, 'ranking'])->name('spk.ranking');  // tabel hasil SAW
Route::post('/spk/hitung', [SpkController::class, 'hitung'])->name('spk.hitung');    // jalankan perhitungan periode aktif
Route::get('/spk/{sekolah}/detail', [SpkController::class, 'detail'])->name('spk.detail'); // rincian skor per kriteria
```

### 11.4 View (Usulan)

```
resources/views/kabalai/spk/
├── bobot.blade.php     // form perbandingan berpasangan + tampilan bobot & CR
├── ranking.blade.php   // tabel sekolah terurut + grafik + filter kota/tingkatan
└── detail.blade.php    // rincian "mengapa sekolah ini prioritas" per kriteria
```

### 11.5 Sumber Data untuk Perhitungan

- Ambil sekolah dengan `status_verifikasi = terverifikasi` pada `periode` dengan `status = 1` (aktif).
- Eager-load relasi: `fasilitas` (`SekolahFasilitas`) + `labs`, `bantuanStatus`, `sekolah_sosekbud`.
- Lewati/beri catatan untuk sekolah dengan data tidak lengkap agar tidak merusak normalisasi.

---

## 12. Alur Kerja Pengguna (Role Kabalai)

```
1. (Sekali / saat kebijakan berubah)
   Kabalai membuka menu "Bobot Kriteria (AHP)"
      → mengisi perbandingan berpasangan antar-kriteria
      → sistem menghitung bobot + CR
      → jika CR ≤ 10%, bobot disimpan ke spk_kriteria
      → jika CR > 10%, sistem meminta perbaikan penilaian

2. (Tiap periode)
   Kabalai menekan "Hitung Prioritas"
      → sistem mengambil semua sekolah terverifikasi periode aktif
      → mengonversi data → menormalisasi → menghitung V (SAW)
      → menyimpan ranking & kategori ke spk_hasil

3. Kabalai membuka "Ranking Prioritas Bantuan"
      → melihat daftar sekolah terurut + kategori + grafik
      → klik sekolah → melihat rincian skor per kriteria
      → menjadikannya dasar keputusan pemberian bantuan
```

---

## 13. Keunggulan, Batasan, dan Catatan Penting

### 13.1 Keunggulan

- Menyatu dengan data & role yang sudah ada — **tanpa pengumpulan data baru**.
- Objektif, transparan, konsisten, dan akuntabel per periode.
- Mudah dijelaskan pada sidang/laporan karena metodenya populer & terdokumentasi luas.

### 13.2 Batasan / Risiko yang Perlu Diperhatikan

| Risiko | Mitigasi |
|---|---|
| **Rubrik konversi subjektif** (C1–C7) | Sepakati rubrik dengan pembimbing/Balai; dokumentasikan & simpan di sistem |
| **Data sekolah tidak lengkap** | Wajibkan verifikasi lengkap sebelum masuk perhitungan; tandai data kurang |
| **Bobot AHP tidak konsisten** (CR > 10%) | Sistem menolak & meminta revisi perbandingan |
| **Perubahan kebijakan bobot** | Simpan versi bobot per periode agar hasil historis tetap bisa ditelusuri |
| **Skala kriteria berbeda** (mis. jumlah siswa vs skor 1–5) | Selalu normalisasi sebelum penjumlahan SAW |

### 13.3 Catatan Metodologis

- AHP dan SAW keduanya **kompensatoris** — nilai buruk di satu kriteria bisa "tertutup" nilai baik di kriteria lain. Jika ada kriteria yang tidak boleh dikompensasi (mis. "tidak ada listrik" harus selalu prioritas), pertimbangkan aturan tambahan/threshold di luar SAW.
- Untuk validasi, bandingkan hasil ranking SPK dengan penilaian manual beberapa sampel sekolah (uji kesesuaian).

---

## 14. Glosarium & Referensi

### 14.1 Istilah

| Istilah | Arti |
|---|---|
| **SPK / DSS** | Sistem Pendukung Keputusan / Decision Support System |
| **MCDM** | Multi-Criteria Decision Making — pengambilan keputusan multi-kriteria |
| **AHP** | Analytic Hierarchy Process (Saaty, 1980) — metode pembobotan hierarkis |
| **SAW** | Simple Additive Weighting — metode penjumlahan terbobot |
| **Alternatif** | Objek yang dinilai (di sini: sekolah) |
| **Kriteria** | Aspek penilaian (listrik, internet, dll.) |
| **Bobot (weight)** | Tingkat kepentingan tiap kriteria (total = 1) |
| **Normalisasi** | Menyeragamkan skala nilai antar-kriteria (0–1) |
| **Benefit / Cost** | Kriteria yang "semakin besar semakin baik" / "semakin kecil semakin baik" |
| **λmaks** | Eigenvalue maksimum matriks perbandingan (AHP) |
| **CI / CR** | Consistency Index / Consistency Ratio (uji konsistensi AHP) |
| **RI** | Random Index — pembanding konsistensi dari tabel Saaty |

### 14.2 Rumus Ringkas

```
AHP:
  Bobot w_j   = rata-rata baris matriks ternormalisasi
  CI          = (λmaks − n) / (n − 1)
  CR          = CI / RI          → dapat diterima jika CR ≤ 0.10

SAW:
  Benefit r_ij = x_ij / max(x_·j)
  Cost    r_ij = min(x_·j) / x_ij
  Skor    V_i  = Σ_j ( w_j × r_ij )
  Ranking: urutkan V_i menurun
```

### 14.3 Referensi Bacaan

- Saaty, T. L. (1980). *The Analytic Hierarchy Process*. McGraw-Hill.
- Kusumadewi, S., dkk. (2006). *Fuzzy Multi-Attribute Decision Making (Fuzzy MADM)*. Graha Ilmu. — pembahasan SAW & normalisasi.
- Turban, E., Aronson, J. E., & Liang, T. P. *Decision Support Systems and Intelligent Systems*.
- Berbagai publikasi/skripsi SPK "penentuan penerima bantuan" berbasis AHP-SAW (Google Scholar) sebagai pembanding metodologi.

---

## 15. Peta Langkah Implementasi (Untuk Besok)

Urutan pengerjaan yang disarankan:

1. **Finalisasi kriteria & rubrik** (Bagian 9) bersama pembimbing → kunci semua langkah berikutnya.
2. **Buat migrasi tabel** `spk_kriteria`, `spk_hasil` (dan opsional `spk_ahp_perbandingan`).
3. **Model & relasi** untuk tabel baru + relasi ke `Sekolah` dan `Periode`.
4. **`KonversiKriteriaService`** — implementasikan rubrik konversi (Bagian 9.2).
5. **`AhpWeightService`** — perbandingan berpasangan → bobot → CR (Bagian 6 & 10.1).
6. **`SawRankingService`** — matriks → normalisasi → skor V → ranking (Bagian 7 & 10.2).
7. **Controller + route** di grup `Kabalai` (Bagian 11.3).
8. **View**: form bobot AHP, tabel ranking, halaman detail (Bagian 11.4).
9. **Uji** dengan data sampel (bandingkan dengan hitungan manual di Bagian 10).
10. **Seed** bobot awal & rubrik agar sistem bisa langsung dicoba.

> Mulai dari **langkah 1–2** dulu; keduanya menjadi fondasi seluruh modul SPK.

---

> 📌 **Catatan:** Dokumen ini adalah rancangan konseptual & bahan pembelajaran metode **AHP + SAW** untuk penambahan modul SPK pada sistem **emoneva**. Angka bobot dan rubrik yang tercantum bersifat **contoh** dan wajib disepakati bersama pihak Balai/pembimbing sebelum implementasi final.

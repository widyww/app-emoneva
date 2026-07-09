# Deskripsi Sistem — EMONEV

### *e-Monitoring dan Evaluasi Kesiapan Fasilitas Teknologi Informasi & Komunikasi (TIK) Sekolah*

> **Versi Dokumen:** 2.0 (fokus: **fasilitas TIK sekolah**)
> **Basis Kode:** Laravel 11.x (PHP 8.2+)
> **Nama Basis Data:** `emonev`
> **Institusi:** Balai Teknologi Informasi & Komunikasi (BTIK), Dinas Pendidikan Provinsi Maluku
> **Tanggal:** 9 Juli 2026

---

> **Catatan revisi v2.0.** Berdasarkan arahan pembimbing, ruang lingkup sistem **dipersempit menjadi
> monitoring dan evaluasi FASILITAS TIK sekolah saja**. Seluruh modul **kompetensi guru**
> (pendataan guru, kompetensi, sertifikasi, pelatihan, verifikasi & statistik guru, serta peran
> "Guru") **telah dihapus** dari sistem. Jumlah guru (`jum_guru`) tetap dicatat hanya sebagai
> atribut demografis sekolah, setara dengan jumlah siswa.

---

## Daftar Isi

1. [Ringkasan Eksekutif](#1-ringkasan-eksekutif)
2. [Latar Belakang & Tujuan](#2-latar-belakang--tujuan)
3. [Ruang Lingkup Sistem](#3-ruang-lingkup-sistem)
4. [Aktor & Peran Pengguna](#4-aktor--peran-pengguna)
5. [Arsitektur Teknis](#5-arsitektur-teknis)
6. [Modul Fungsional](#6-modul-fungsional)
7. [Model Data (Skema Aktual)](#7-model-data-skema-aktual)
8. [Alur Kerja Verifikasi](#8-alur-kerja-verifikasi)
9. [Modul Monitoring & Analitik (Kabalai)](#9-modul-monitoring--analitik-kabalai)
10. [Autentikasi & Otorisasi](#10-autentikasi--otorisasi)
11. [Impor Data Massal (Excel)](#11-impor-data-massal-excel)
12. [Glosarium](#12-glosarium)

---

## 1. Ringkasan Eksekutif

**EMONEV** adalah aplikasi web untuk melakukan **monitoring dan evaluasi (monev)** kesiapan
**Fasilitas Teknologi Informasi dan Komunikasi (TIK)** pada satuan pendidikan (sekolah) di wilayah
Provinsi Maluku. Fokus sistem adalah memetakan kondisi **kelistrikan, laboratorium komputer, dan
konektivitas internet** sekolah, beserta konteks pendukung (identitas sekolah, kondisi
sosial-ekonomi-budaya, bantuan yang diterima, status akreditasi, dan kesiapan UNBK).

Sistem menjadi alat bantu pengambilan keputusan bagi pimpinan balai (Kepala Balai) dalam menentukan
prioritas intervensi TIK — penyaluran bantuan, pengadaan/penguatan laboratorium komputer, dan
peningkatan jaringan internet/listrik — serta menilai kesiapan sekolah menyelenggarakan asesmen
berbasis komputer (UNBK).

Aplikasi mengadopsi alur **input data oleh sekolah → verifikasi oleh petugas → agregasi & analisis
oleh pimpinan**, sehingga data yang menjadi dasar kebijakan telah tervalidasi. Sistem membedakan
**empat peran** yang dipisahkan secara ketat melalui middleware pada level rute.

---

## 2. Latar Belakang & Tujuan

### Latar Belakang

Perencanaan pengembangan TIK pendidikan pada tingkat wilayah sering terhambat oleh:

- Data kondisi fasilitas TIK sekolah (listrik, laboratorium komputer, internet) yang tersebar dan
  tidak seragam.
- Tidak adanya gambaran menyeluruh mengenai sekolah yang **belum siap** menyelenggarakan asesmen
  berbasis komputer.
- Ketiadaan riwayat **bantuan** yang pernah diterima sekolah, sehingga penyaluran berpotensi tidak
  merata.
- Data yang belum tervalidasi dipakai sebagai dasar kebijakan.

### Tujuan Sistem

1. Menyediakan basis data terpusat identitas dan kondisi fasilitas TIK sekolah per **periode
   (tahun)**.
2. Mendata kondisi **fasilitas TIK**: kelistrikan (status/sumber/durasi), laboratorium komputer
   (status, jumlah komputer, rincian lab beserta jumlah PC), dan konektivitas internet
   (status/sumber/bandwidth/topologi/kesesuaian kuota).
3. Mendata **kondisi sosial-ekonomi-budaya (sosekbud)**, geografis, dan aksesibilitas transportasi
   sekolah sebagai konteks kewilayahan yang memengaruhi pengembangan TIK.
4. Mendata **bantuan** yang pernah/akan diterima sekolah beserta lembaga pemberinya.
5. Menjalankan **alur verifikasi** data sekolah oleh verifikator.
6. Menyajikan **dashboard analitik dan filter** kepada pimpinan (Kabalai) untuk memetakan sekolah
   menurut indikator kesiapan TIK (akreditasi, status bantuan, lab komputer, internet, listrik).
7. Mencatat status kesiapan **UNBK** dan **akreditasi** sekolah.

---

## 3. Ruang Lingkup Sistem

### Termasuk dalam Lingkup (In-Scope)

- Manajemen data master: **Kota/Kabupaten**, **Kecamatan**, **Periode**, **Sekolah**, dan
  **akun pengguna** (Operator Sekolah serta pengguna internal Verifikator/Kabalai).
- Pengisian data sekolah oleh **Operator Sekolah**: identitas, sosekbud, **fasilitas TIK**, dan
  bantuan.
- Pengajuan dan **verifikasi** data sekolah.
- Dashboard & modul **filter/monitoring fasilitas TIK** untuk pimpinan (Kabalai).
- Impor data massal via berkas **Excel/Spreadsheet** (`phpoffice/phpspreadsheet`).

### Di Luar Lingkup (Out-of-Scope)

- **Kompetensi guru** (pendataan guru, kompetensi TIK, sertifikasi, pelatihan, kebutuhan pelatihan,
  verifikasi & statistik guru) — **dihapus** dari sistem sesuai penyempitan fokus.
- Integrasi otomatis dengan Dapodik / SIAKAD eksternal.
- Notifikasi WhatsApp / SMS gateway.
- Aplikasi mobile native.
- Manajemen keuangan/anggaran bantuan (sistem hanya mencatat status & keterangan bantuan).

---

## 4. Aktor & Peran Pengguna

Peran disimpan pada kolom `users.role` dan ditegakkan melalui middleware bernama (alias) di
`bootstrap/app.php`: `Administrator`, `Operator`, `Verifikator`, `Kabalai`.

| Kode | Peran | Middleware | Deskripsi & Kewenangan Utama |
|---|---|---|---|
| `1` | **Administrator** | `Administrator` | Superuser pengelola sistem. Kelola data master (Kota, Kecamatan, Periode), data Sekolah, akun Operator Sekolah, dan manajemen user internal (Verifikator/Kabalai). Melakukan impor massal. |
| `3` | **Operator Sekolah** | `Operator` | Petugas di tingkat sekolah (akun `users` terhubung ke satu `sekolah_id`). Mengisi identitas sekolah, sosekbud, **fasilitas TIK**, dan bantuan. Mengajukan data untuk diverifikasi. |
| `2` | **Verifikator** | `Verifikator` | Memeriksa & memvalidasi data sekolah yang diajukan. Menyetujui/menolak dengan keterangan. Mengakses modul monitoring sekolah. |
| `4` | **Kabalai** (Kepala Balai) | `Kabalai` | Pimpinan. Akses read-only ke dashboard analitik dan modul filter fasilitas TIK untuk memetakan sekolah. |

> **Peran "Guru" (kode 5) telah dihapus** beserta seluruh rute, controller, model, view, dan
> kolom `users.guru_id`. Operator Sekolah login menggunakan **NPSN**; pengguna internal login
> menggunakan **email**.

---

## 5. Arsitektur Teknis

### 5.1 Diagram Lapisan

```
┌───────────────────────────────────────────────────────────────┐
│                       CLIENT (Browser)                        │
│              Blade Views + Tailwind/Bootstrap                 │
│        (Chart dashboard Kabalai via endpoint JSON)            │
└──────────────────────────────┬────────────────────────────────┘
                              │ HTTP
┌──────────────────────────────▼────────────────────────────────┐
│                    APLIKASI (Laravel 11)                      │
│  routes/web.php  →  Middleware Peran  →  Controllers          │
│  ┌────────────┐  ┌───────────────────────────────────────┐   │
│  │  Auth      │  │ Administrator / Operator /            │   │
│  │ (Breeze)   │  │ Verifikator / Kabalai controllers     │   │
│  └────────────┘  └───────────────────────────────────────┘   │
│  Eloquent Models  ·  Import Excel (PhpSpreadsheet)           │
└──────────────────────────────┬────────────────────────────────┘
                              │ Eloquent ORM
┌──────────────────────────────▼────────────────────────────────┐
│                     DATA (MySQL — db: emonev)                 │
│  sekolah · fasilitastik(+lab) · bantuan(+detail) · sosekbud   │
│  periode · kota · kecamatan · users                           │
└───────────────────────────────────────────────────────────────┘
```

### 5.2 Tumpukan Teknologi

| Komponen | Teknologi |
|---|---|
| Framework / Bahasa | Laravel 11.x · PHP 8.2+ |
| Autentikasi | Laravel Breeze (session) + verifikasi email |
| Otorisasi | **Middleware kustom per-peran** (bukan Spatie) |
| Database | MySQL — nama db `emonev` |
| Frontend | Blade, Tailwind CSS, Bootstrap (SB Admin), Vite |
| Chart | ApexCharts (via endpoint JSON) |
| Impor Excel | `phpoffice/phpspreadsheet` ^5.2 |
| Session / Cache / Queue | driver `database` (default) |
| Pengujian | PHPUnit ^10.5 · Mockery |

### 5.3 Struktur Direktori (ringkas, pasca-revisi)

```
app-emoneva/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdministratorController.php
│   │   │   ├── DataSekolahController.php  BantuanSekolahController.php
│   │   │   ├── FasilitasSekolahController.php
│   │   │   ├── UserVerifikatorController.php  VerifikasiProsesController.php
│   │   │   ├── MonitoringSekolahController.php
│   │   │   ├── USerKabalaiController.php
│   │   │   ├── FilterAkreditasiController.php   FilterStatusBantuanController.php
│   │   │   ├── FilterLabkomputerController.php  FilterKuotaInternetController.php
│   │   │   ├── FilterListrikController.php
│   │   │   └── Kota/Kecamatan/Periode/Sekolah/User/ManajemenUserController.php
│   │   └── Middleware/  Administrator · Operator · Verifikator · Kabalai
│   └── Models/
│       ├── User.php  Sekolah.php  Periode.php  Kota.php  Kecamatan.php
│       ├── SekolahSosekbud.php   SekolahFasilitas.php   SekolahFasilitasLab.php
│       └── SekolahBantuanStatus.php   SekolahBantuanDetail.php
├── database/migrations/   (tanpa migrasi guru)
├── resources/views/       (tanpa view guru)
└── routes/  web.php  auth.php  console.php
```

---

## 6. Modul Fungsional

Dikelompokkan menurut peran (sesuai `routes/web.php` pasca-revisi).

### 6.1 Administrator

| Modul | Controller | Aksi |
|---|---|---|
| Dashboard | `AdministratorController` | Ringkasan: jumlah sekolah, menunggu verifikasi, terverifikasi |
| Kota/Kabupaten | `KotaController` | CRUD |
| Kecamatan | `KecamatanController` | CRUD |
| Periode | `PeriodeController` | CRUD + `setAktif` (menetapkan periode aktif) |
| Sekolah | `SekolahController` | CRUD + **import** Excel |
| Operator Sekolah | `UserController` | CRUD akun operator + **import** Excel |
| Manajemen User (Verifikator & Kabalai) | `ManajemenUserController` | CRUD user internal |

### 6.2 Operator Sekolah

| Modul | Controller | Aksi |
|---|---|---|
| Dashboard Operator | `OperatorController` | Ringkasan sekolah |
| Identitas Sekolah | `DataSekolahController@index_identitas / update_identitas` | Lihat & perbarui identitas (termasuk UNBK) |
| Sosekbud | `DataSekolahController@index_sosekbud / update_sosekbud` | Kondisi geografis, sosekbud, transportasi |
| Bantuan Sekolah | `BantuanSekolahController` | Tambah/hapus data bantuan |
| **Fasilitas TIK (Listrik & Internet)** | `FasilitasSekolahController` | Simpan fasilitas + hapus lab komputer |
| Ajukan Verifikasi | `DataSekolahController@ajukanVerifikasi` | `status_verifikasi` → 1 (diajukan) |

### 6.3 Verifikator

| Modul | Controller | Aksi |
|---|---|---|
| Dashboard | `UserVerifikatorController` | Ringkasan antrian verifikasi sekolah |
| Verifikasi Data Sekolah | `VerifikasiProsesController` (resource) | Daftar, detail, setujui/tolak |
| Monev Data Sekolah | `MonitoringSekolahController` (resource) | Pantauan data sekolah |

### 6.4 Kabalai (Kepala Balai) — Dashboard & Filter Fasilitas TIK

Modul read-only untuk analisis. Tiap filter memiliki tiga endpoint: halaman (`index`/`sort`), data
agregat untuk chart (`getData`), dan detail per sekolah (`getDetail`).

| Modul Filter | Controller |
|---|---|
| Dashboard Kabalai | `USerKabalaiController` |
| Akreditasi | `FilterAkreditasiController` |
| Status Bantuan | `FilterStatusBantuanController` |
| Laboratorium Komputer | `FilterLabkomputerController` |
| Kuota / Internet | `FilterKuotaInternetController` |
| Listrik | `FilterListrikController` |

---

## 7. Model Data (Skema Aktual)

Diambil langsung dari berkas migrasi `database/migrations/` (pasca-revisi). Tabel `guru`,
`guru_pelatihan`, `guru_kebutuhan`, dan kolom `users.guru_id` **telah dihapus**.

### 7.1 `users`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| name | string | |
| email | string unik | untuk operator berisi **NPSN** |
| phone | string, nullable | |
| role | string, nullable | `1 Administrator \| 2 Verifikator \| 3 Operator Sekolah \| 4 Kabalai` |
| email_verified_at | timestamp, nullable | |
| password | string | |
| sekolah_id | bigint FK→sekolah, nullable | untuk Operator Sekolah, cascade on delete |
| remember_token, timestamps | | |

### 7.2 `sekolah`
| Kolom | Keterangan |
|---|---|
| id, npsn (unik), tingkatan, nama, alamat, telepon, email, website | identitas |
| foto_sekolah, kepsek_nama, kepsek_hp, kepsek_foto, sk_ijin | identitas & kepala sekolah |
| status_sekolah (`Negeri`/`Swasta`), status_akreditasi, status_tanah | status |
| jum_siswa_pria, jum_siswa_wanita, **jum_guru** | demografi (headcount) |
| unbk_status, unbk_tahun | kesiapan UNBK |
| status_verifikasi, keterangan_verifikasi, tahun | verifikasi & periode |
| kecamatan_id (FK), kota_id (FK) | wilayah |

> `jum_guru` adalah sekadar **jumlah guru** sebagai konteks demografis sekolah (setara
> `jum_siswa`), **bukan** modul kompetensi guru.

### 7.3 `sekolah_sosekbud`
`sekolah_id` (FK cascade), `kondisi_geografis`, `kondisi_sosekbud`, `akses_transportasi` (TEXT).

### 7.4 `sekolah_fasilitastik` (Fasilitas TIK) — *entitas inti*
| Kelompok | Kolom |
|---|---|
| Listrik | `listrik_status` (enum ada/tidak), `listrik_sumber`, `listrik_durasi` |
| Komputer | `jumlah_kom`, `labkom_status` (enum ada/tidak) |
| Internet | `internet_status` (enum), `internet_sumber`, `internet_bandwith`, `topologi_jaringan`, `internet_kesesuaian`, `internet_alasankuota` (text) |
| Saran | `saran_pengembangan` (text) |

### 7.5 `sekolah_fasilitastik_lab`
`sekolah_fasilitastik_id` (FK cascade), `labkom_nama`, `labkom_jumlah_pc`. Satu sekolah dapat
memiliki lebih dari satu lab komputer.

### 7.6 `sekolah_bantuan_status` & `sekolah_bantuan_detail`
- `sekolah_bantuan_status`: `sekolah_id` (FK cascade), `status`.
- `sekolah_bantuan_detail`: `sekolah_bantuan_status_id` (FK cascade), `nama_lembaga`,
  `keterangan_bantuan` (text).

### 7.7 Master Wilayah & Periode
- `kota`: kota/kabupaten. `kecamatan`: kecamatan (berelasi ke kota).
- `periode`: `tahun` (year), `status` (boolean; 1 = periode aktif).

### 7.8 Diagram Relasi (ERD sederhana)

```
kota 1───* kecamatan
kota 1───* sekolah *───1 kecamatan
sekolah 1───1 sekolah_sosekbud
sekolah 1───1 sekolah_fasilitastik 1───* sekolah_fasilitastik_lab
sekolah 1───1 sekolah_bantuan_status 1───* sekolah_bantuan_detail
users *───1 sekolah         (operator)
```

---

## 8. Alur Kerja Verifikasi

Nilai kolom `status_verifikasi` pada `sekolah`:

| Nilai | Makna | Ditetapkan oleh |
|---|---|---|
| `0` / null | Draft / belum diajukan | default |
| `1` | **Diajukan** — menunggu verifikasi | Operator (`ajukanVerifikasi`) |
| `2` | **Disetujui** | Verifikator |
| `3` | **Ditolak** (disertai `keterangan_verifikasi`) | Verifikator |

```
Operator melengkapi: identitas · sosekbud · fasilitas TIK · bantuan
                    │
                    ▼
        Operator "Ajukan Verifikasi"  → status_verifikasi = 1
                    │
                    ▼
   Verifikator membuka daftar (diajukan diprioritaskan di atas)
   membuka detail (identitas + sosekbud + bantuan + fasilitas TIK)
                    │
        ┌───────────┴───────────┐
        ▼                       ▼
   Disetujui (=2)          Ditolak (=3) + keterangan_verifikasi
        │                       │
        ▼                       ▼
  Masuk agregasi          Operator merevisi & mengajukan ulang
  dashboard Kabalai
```

> Pada `VerifikasiProsesController@index`, data diurutkan agar sekolah yang **menunggu verifikasi**
> tampil paling atas.

---

## 9. Modul Monitoring & Analitik (Kabalai)

Dashboard Kabalai menyediakan pemetaan sekolah menurut indikator kesiapan **fasilitas TIK**. Pola
umum tiap filter: **halaman filter** → **endpoint data agregat (chart)** → **endpoint detail per
sekolah**.

| Indikator | Sumber Data | Kegunaan Analitik |
|---|---|---|
| Akreditasi | `sekolah.status_akreditasi` | Sebaran mutu sekolah |
| Status Bantuan | `sekolah_bantuan_status` | Sekolah sudah/belum menerima bantuan |
| Lab Komputer | `sekolah_fasilitastik.labkom_status`, `jumlah_kom`, lab | Kesiapan laboratorium untuk UNBK |
| Internet | `sekolah_fasilitastik.internet_*` | Sekolah dengan/tanpa internet, kesesuaian kuota |
| Listrik | `sekolah_fasilitastik.listrik_*` | Ketersediaan & durasi listrik |

Dashboard Kabalai juga menampilkan **grafik status verifikasi data sekolah** (belum input /
menunggu / terverifikasi) menggunakan ApexCharts.

---

## 10. Autentikasi & Otorisasi

- **Autentikasi:** Laravel Breeze (session), dengan **verifikasi email** wajib (`verified`) pada
  seluruh grup rute berperan.
- **Login:** Operator Sekolah login menggunakan **NPSN** (tersimpan pada kolom `email`); pengguna
  internal (Administrator/Verifikator/Kabalai) login menggunakan **email**. Logika login lama
  berbasis NIP/NUPTK guru telah dihapus.
- **Otorisasi:** middleware per-peran (`Administrator`, `Operator`, `Verifikator`, `Kabalai`)
  diterapkan pada grup rute — pemisahan hak akses tegas per URL. Middleware mengarahkan pengguna ke
  dashboard sesuai perannya.
- **Isolasi data operator:** akun operator terikat `sekolah_id`, membatasi data yang dapat diisi.
- **Integritas referensial:** relasi memakai `onDelete('cascade')` / `set null`; menghapus sekolah
  menghapus fasilitas TIK (+lab), bantuan (+detail), dan sosekbud terkait.
- **Proteksi standar Laravel:** CSRF token pada form, hashing bcrypt (12 rounds), `$fillable` pada
  model, serta rate limiting login (5 percobaan).

---

## 11. Impor Data Massal (Excel)

Menggunakan `phpoffice/phpspreadsheet`. Endpoint impor tersedia untuk:

- **Sekolah** — `POST /sekolah/import` (`SekolahController@import`)
- **Operator Sekolah** — `POST /operator-sekolah/import` (`UserController@import`) — kolom
  Excel: `A=nama, B=NPSN, C=telepon`; operator dibuat dengan `email = NPSN` dan password = NPSN.

Impor memudahkan migrasi data awal dari berkas rekap yang sudah ada di balai.

---

## 12. Glosarium

| Istilah | Arti |
|---|---|
| **EMONEV / emonev** | e-Monitoring dan Evaluasi (nama sistem/basis data) |
| **BTIK** | Balai Teknologi Informasi & Komunikasi, Dinas Pendidikan Provinsi Maluku |
| **Kabalai** | Kepala Balai — pimpinan pengambil keputusan |
| **NPSN** | Nomor Pokok Sekolah Nasional (dipakai Operator untuk login) |
| **Fasilitas TIK** | Kelistrikan, laboratorium komputer, dan konektivitas internet sekolah |
| **Labkom** | Laboratorium Komputer |
| **Sosekbud** | Kondisi Sosial-Ekonomi-Budaya |
| **UNBK** | Ujian Nasional Berbasis Komputer (indikator kesiapan komputerisasi asesmen) |
| **Operator Sekolah** | Petugas pengisi data di tingkat sekolah |
| **Verifikator** | Petugas pemeriksa & pengesah data sekolah |

---

> Dokumen ini disusun berdasarkan **kode sumber aktual** aplikasi `app-emoneva` setelah penyempitan
> fokus ke fasilitas TIK (penghapusan modul guru). Perubahan skema/rute berikutnya perlu
> disinkronkan kembali.

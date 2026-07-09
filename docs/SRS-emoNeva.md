# Software Requirements Specification (SRS) — EMONEV

### *e-Monitoring dan Evaluasi Kesiapan Fasilitas TIK Sekolah*

> Disusun mengikuti kerangka **IEEE 830**.
> **Versi:** 2.0 (fokus fasilitas TIK) · **Tanggal:** 9 Juli 2026 · **Basis:** kode aktual `app-emoneva`

---

> **Revisi v2.0.** Ruang lingkup dipersempit menjadi **fasilitas TIK sekolah**. Modul **kompetensi
> guru** dan peran **Guru** dihapus. SRS ini hanya menyatakan kebutuhan yang benar-benar ada di kode.

---

## 1. Pendahuluan

### 1.1 Tujuan Dokumen
Mendefinisikan kebutuhan perangkat lunak **EMONEV**, aplikasi web untuk monitoring dan evaluasi
kesiapan **fasilitas Teknologi Informasi dan Komunikasi (TIK)** sekolah. Ditujukan bagi pengembang,
penguji, dan pemangku kepentingan BTIK Dinas Pendidikan Provinsi Maluku.

### 1.2 Lingkup Produk
EMONEV memungkinkan sekolah (melalui Operator) mengisi data kondisi **fasilitas TIK** (listrik, lab
komputer, internet) beserta konteks pendukung (identitas, sosekbud, bantuan); verifikator memvalidasi
data; dan pimpinan (Kabalai) menganalisis data agregat. Sistem **tidak** menangani kompetensi guru,
anggaran, integrasi eksternal real-time, maupun notifikasi WA/SMS.

### 1.3 Definisi, Akronim, Singkatan
| Istilah | Arti |
|---|---|
| TIK | Teknologi Informasi dan Komunikasi |
| NPSN | Nomor Pokok Sekolah Nasional |
| UNBK | Ujian Nasional Berbasis Komputer |
| Sosekbud | Kondisi Sosial-Ekonomi-Budaya |
| Kabalai | Kepala Balai (pimpinan) |
| Labkom | Laboratorium Komputer |
| BTIK | Balai Teknologi Informasi & Komunikasi |
| CRUD | Create, Read, Update, Delete |

### 1.4 Referensi
- Kode sumber: `routes/web.php`, `bootstrap/app.php`, `database/migrations/*`, `app/Http/Controllers/*`.
- Kerangka: IEEE Std 830-1998.

---

## 2. Deskripsi Umum

### 2.1 Perspektif Produk
Aplikasi web monolitik **Laravel 11** (Blade + Tailwind/Bootstrap, MySQL `emonev`), autentikasi
**Laravel Breeze**, otorisasi **middleware kustom per-peran** (bukan Spatie). Impor data massal
memakai **PhpSpreadsheet**; chart dashboard memakai **ApexCharts** via endpoint JSON.

```
Browser ──HTTP──> Laravel (Routing→Middleware Peran→Controller→Eloquent) ──> MySQL
```

### 2.2 Fungsi Produk (ringkas)
1. Manajemen master data (kota, kecamatan, periode, sekolah).
2. Manajemen akun (operator, user internal).
3. Pengisian data sekolah (identitas, sosekbud, **fasilitas TIK**, bantuan).
4. Alur verifikasi data sekolah.
5. Dashboard analitik & filter **fasilitas TIK** untuk pimpinan.
6. Impor data Excel.

### 2.3 Karakteristik Pengguna
| Peran | Kode | Hak Akses Ringkas |
|---|---|---|
| Administrator | 1 | Kelola master data & akun; impor |
| Verifikator | 2 | Validasi (setujui/tolak); monitoring sekolah |
| Operator Sekolah | 3 | Isi data fasilitas TIK sekolahnya; ajukan verifikasi |
| Kabalai | 4 | Baca dashboard & filter fasilitas TIK |

### 2.4 Batasan Umum
- Peramban modern; server PHP 8.2+ dan MySQL.
- Bahasa antarmuka: Indonesia.
- Otorisasi pada level rute; satu operator terikat satu `sekolah_id`.
- Operator login via **NPSN**, pengguna internal via **email**.

### 2.5 Asumsi & Ketergantungan
- Data awal dapat diimpor via Excel sesuai template.
- Verifikasi email aktif (middleware `verified`).
- Ambang "kesiapan TIK" bersifat kebijakan (tidak dihitung otomatis pada baseline).

---

## 3. Kebutuhan Spesifik

### 3.1 Kebutuhan Antarmuka Eksternal
- **Antarmuka pengguna:** login (email/NPSN), dashboard per-peran, formulir CRUD & input bertahap
  data sekolah, tampilan chart (dashboard Kabalai).
- **Antarmuka perangkat lunak:** MySQL via Eloquent; PhpSpreadsheet untuk `.xlsx`; endpoint JSON
  internal untuk chart (mis. `sekolah.getakreditasidata`, `labkomputer.getdata`, `internet.getdata`,
  `listrik.getdata`, `bantuan.getdata`).
- **Antarmuka komunikasi:** HTTP/HTTPS; sesi cookie; token CSRF pada form.

### 3.2 Kebutuhan Fungsional (RF)

#### Autentikasi & Otorisasi
| Kode | Kebutuhan |
|---|---|
| RF-01 | Registrasi, login, logout, reset password, verifikasi email. |
| RF-02 | Mengarahkan pengguna ke dashboard sesuai peran setelah login. |
| RF-03 | Menolak akses rute peran lain via middleware; mensyaratkan email terverifikasi. |
| RF-04 | Operator login menggunakan NPSN; pengguna internal menggunakan email. |

#### Administrator — master data & akun
| Kode | Kebutuhan |
|---|---|
| RF-05 | CRUD Kota & Kecamatan. |
| RF-06 | CRUD Periode + `setAktif` (menetapkan periode aktif). |
| RF-07 | CRUD Sekolah + impor Excel. |
| RF-08 | CRUD akun Operator (tertaut `sekolah_id`) + impor Excel (email = NPSN). |
| RF-09 | CRUD user internal (Verifikator & Kabalai). |

#### Operator — input data
| Kode | Kebutuhan |
|---|---|
| RF-10 | Lihat & perbarui identitas sekolah (termasuk `unbk_status`, `unbk_tahun`). |
| RF-11 | Lihat & perbarui data sosekbud. |
| RF-12 | Tambah & hapus data bantuan (status + detail). |
| RF-13 | Simpan data **fasilitas TIK** (listrik, komputer/lab, internet); hapus entri lab komputer. |
| RF-14 | Ajukan verifikasi (`status_verifikasi = 1`). |

#### Verifikator — validasi
| Kode | Kebutuhan |
|---|---|
| RF-15 | Melihat daftar sekolah; entitas "diajukan" ditampilkan paling atas. |
| RF-16 | Melihat detail lengkap sekolah (identitas, sosekbud, bantuan, fasilitas TIK + lab). |
| RF-17 | Menyetujui (=2) atau menolak (=3) + `keterangan_verifikasi`. |
| RF-18 | Mengakses monitoring (monev) data sekolah. |

#### Kabalai — dashboard & filter fasilitas TIK
| Kode | Kebutuhan |
|---|---|
| RF-19 | Dashboard ringkasan + grafik status verifikasi sekolah. |
| RF-20 | Filter & chart **Akreditasi** (+detail sekolah). |
| RF-21 | Filter & chart **Status Bantuan** (+data & detail). |
| RF-22 | Filter & chart **Lab Komputer** (+data & detail). |
| RF-23 | Filter & chart **Internet/Kuota** (+data & detail). |
| RF-24 | Filter & chart **Listrik** (+data & detail). |
| RF-25 | Setiap modul filter menyediakan endpoint data agregat (JSON) & detail per sekolah. |

### 3.3 Kebutuhan Non-Fungsional (RNF)
| Kode | Kategori | Kebutuhan |
|---|---|---|
| RNF-01 | Keamanan | Auth + email terverifikasi; otorisasi per-peran; CSRF; bcrypt 12 rounds; rate limit login (5×). |
| RNF-02 | Keamanan Data | FK cascade/set null; operator terbatas pada `sekolah_id`-nya. |
| RNF-03 | Kinerja | Daftar besar dipaginasi; endpoint chart merespons < 2 detik pada ratusan sekolah. |
| RNF-04 | Skalabilitas | Banyak sekolah per periode; indeks pada kolom filter. |
| RNF-05 | Usabilitas | UI Bahasa Indonesia, responsif; impor Excel. |
| RNF-06 | Keandalan | Validasi server-side; transaksi untuk operasi multi-tabel. |
| RNF-07 | Pemeliharaan | MVC Laravel; migrasi berversi; kode terkelompok per peran. |
| RNF-08 | Kompatibilitas / Audit / Portabilitas | PHP 8.2+/MySQL; timestamp pada semua entitas; lingkungan Laravel standar. |

---

## 4. Model Data (Kebutuhan Basis Data)

Entitas utama (lengkap di *Deskripsi-Sistem-emoNeva.md* §7). Tabel guru & kolom `users.guru_id`
telah dihapus.

| Entitas | Atribut Kunci | Relasi |
|---|---|---|
| `users` | name, email(unik; NPSN utk operator), role, sekolah_id | → sekolah |
| `sekolah` | npsn(unik), nama, status_sekolah, status_akreditasi, status_verifikasi, unbk_status, unbk_tahun, jum_guru, tahun | → kota, → kecamatan |
| `sekolah_sosekbud` | kondisi_geografis, kondisi_sosekbud, akses_transportasi (TEXT) | 1–1 sekolah |
| `sekolah_fasilitastik` | listrik_*, jumlah_kom, labkom_status, internet_*, saran_pengembangan | 1–1 sekolah |
| `sekolah_fasilitastik_lab` | labkom_nama, labkom_jumlah_pc | *–1 fasilitastik |
| `sekolah_bantuan_status` | status | 1–* detail |
| `sekolah_bantuan_detail` | nama_lembaga, keterangan_bantuan | *–1 status |
| `kota`, `kecamatan` | wilayah administratif | kota 1–* kecamatan |
| `periode` | tahun, status(aktif) | — |

**Aturan integritas:** menghapus `sekolah` menghapus (cascade) `sekolah_sosekbud`,
`sekolah_fasilitastik`(+lab), dan `sekolah_bantuan_status`(+detail). Menghapus `kota`/`kecamatan`
menyetel FK sekolah menjadi `null`.

---

## 5. Lampiran

### 5.1 Kamus Nilai Berkode
| Kolom | Nilai | Makna |
|---|---|---|
| `users.role` | 1 / 2 / 3 / 4 | Administrator / Verifikator / Operator Sekolah / Kabalai |
| `sekolah.status_verifikasi` | 0 / 1 / 2 / 3 | Draft / Diajukan / Disetujui / Ditolak |
| `sekolah.status_sekolah` | Negeri / Swasta | Status sekolah |
| `*_fasilitastik.*_status` | ada / tidak | Ketersediaan listrik / lab / internet |
| `periode.status` | 0 / 1 | Tidak aktif / Aktif |

### 5.2 Matriks Ketertelusuran (RF → Aktor → Controller)
| RF | Aktor | Controller (rujukan) |
|---|---|---|
| RF-05..07 | Administrator | Kota/Kecamatan/Periode/SekolahController |
| RF-08..09 | Administrator | UserController, ManajemenUserController |
| RF-10..14 | Operator | DataSekolahController, BantuanSekolahController, FasilitasSekolahController |
| RF-15..18 | Verifikator | VerifikasiProsesController, MonitoringSekolahController |
| RF-19..25 | Kabalai | USerKabalaiController + FilterAkreditasi/StatusBantuan/Labkomputer/KuotaInternet/Listrik |

### 5.3 Skenario Uji (Black-Box)
| No | Skenario | Aktor | Hasil Diharapkan |
|---|---|---|---|
| 1 | Login tiap peran | semua | Diarahkan ke dashboard peran yang benar |
| 2 | Operator akses rute admin | Operator | Ditolak middleware |
| 3 | Operator login via NPSN | Operator | Berhasil masuk dashboard operator |
| 4 | Operator lengkapi & ajukan | Operator | `status_verifikasi` = 1 |
| 5 | Verifikator setujui | Verifikator | `status_verifikasi` = 2 |
| 6 | Verifikator tolak + keterangan | Verifikator | = 3, keterangan tersimpan |
| 7 | Daftar verifikasi | Verifikator | Sekolah "diajukan" tampil paling atas |
| 8 | Set periode aktif | Administrator | Periode ditandai aktif |
| 9 | Impor sekolah/operator Excel | Administrator | Baris valid tersimpan |
| 10 | Filter lab komputer | Kabalai | Chart & detail sesuai data tervalidasi |
| 11 | NPSN duplikat | Administrator | Ditolak (unik) |
| 12 | Hapus sekolah | Administrator | Fasilitas/bantuan/sosekbud ikut terhapus |
| 13 | Akses rute guru lama (mis. `/data-guru`) | semua | 404 (rute sudah dihapus) |

---

> SRS ini diverifikasi terhadap kode aktual `app-emoneva` setelah penyempitan fokus ke fasilitas TIK
> per 9 Juli 2026. Kebutuhan yang belum ada di kode (ekspor laporan, audit trail, notifikasi, skor
> kesiapan otomatis) dicatat sebagai backlog pada PRD.

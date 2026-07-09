# Product Requirements Document (PRD) — EMONEV

### *e-Monitoring dan Evaluasi Kesiapan Fasilitas TIK Sekolah*

> **Versi:** 2.0 · **Status:** Baseline (mengacu pada kode aktual, fokus fasilitas TIK)
> **Pemilik Produk:** Tim Pengembang EMONEV — BTIK Dinas Pendidikan Provinsi Maluku
> **Tanggal:** 9 Juli 2026

---

> **Revisi v2.0.** Ruang lingkup dipersempit menjadi **monitoring & evaluasi fasilitas TIK sekolah**.
> Seluruh fitur **kompetensi guru** dan peran **Guru** dihapus. Dokumen ini hanya mencantumkan
> kebutuhan yang benar-benar ada di kode pasca-revisi.

---

## 1. Ringkasan Produk

**EMONEV** adalah platform web bagi Balai Teknologi Informasi & Komunikasi (BTIK) untuk
**memonitor dan mengevaluasi kesiapan fasilitas TIK** sekolah di Provinsi Maluku — kelistrikan,
laboratorium komputer, dan konektivitas internet — beserta konteks pendukung (identitas, sosekbud,
bantuan, akreditasi, kesiapan UNBK). Data dikumpulkan oleh sekolah, divalidasi oleh verifikator,
lalu diagregasi menjadi dashboard analitik yang membantu pimpinan (Kabalai) menentukan prioritas
intervensi: bantuan, pengadaan lab komputer, dan penguatan internet/listrik.

### Pernyataan Masalah
Perencanaan pengembangan TIK pendidikan tidak akurat karena data kondisi **fasilitas TIK** sekolah
tersebar, tidak terstandar, dan tidak tervalidasi. Pimpinan tidak memiliki gambaran menyeluruh
mengenai sekolah yang belum siap menyelenggarakan asesmen berbasis komputer.

### Visi Produk
Menjadi satu sumber kebenaran (single source of truth) untuk data kesiapan **fasilitas TIK** sekolah
per periode, yang tervalidasi dan siap dijadikan dasar kebijakan.

---

## 2. Tujuan & Metrik Keberhasilan

| Tujuan | Metrik (contoh target) |
|---|---|
| Sentralisasi data fasilitas TIK tervalidasi | ≥ 90% sekolah target terdata & berstatus "Disetujui" per periode |
| Pemetaan kesiapan UNBK/lab komputer | Dashboard menampilkan % sekolah punya lab komputer & internet |
| Percepatan verifikasi | Rata-rata "diajukan → diputuskan" ≤ 5 hari kerja |
| Pemetaan pemerataan bantuan | Daftar sekolah sudah/belum menerima bantuan tersedia & terfilter |
| Kemudahan input | Operator menyelesaikan input satu sekolah dalam satu sesi; tersedia impor Excel |

---

## 3. Persona Pengguna

| Persona | Peran | Kebutuhan Utama | Frekuensi |
|---|---|---|---|
| **Admin Balai** | Administrator | Kelola master data, akun, periode; impor data awal | Sedang |
| **Operator Sekolah** | Operator | Mengisi data fasilitas TIK sekolah dengan mudah & lengkap, lalu mengajukan | Musiman (per periode) |
| **Petugas Verifikasi** | Verifikator | Memeriksa data cepat, menyetujui/menolak dengan catatan | Tinggi saat periode input |
| **Kepala Balai** | Kabalai | Melihat gambaran agregat & memfilter sekolah untuk pengambilan keputusan | Berkala |

---

## 4. Ruang Lingkup Rilis

### 4.1 Sudah Ada (Baseline — tercermin di kode)
- Autentikasi Breeze + verifikasi email; **4 peran** via middleware.
- Login Operator via **NPSN**, pengguna internal via **email**.
- Master data: Kota, Kecamatan, Periode (+ set aktif), Sekolah.
- Manajemen akun: Operator Sekolah, user internal (Verifikator & Kabalai).
- Impor Excel: Sekolah, Operator.
- Input Operator: identitas (+UNBK), sosekbud, **fasilitas TIK** (listrik/lab/internet + multi-lab),
  bantuan; pengajuan verifikasi.
- Verifikasi sekolah (setujui/tolak + keterangan); monitoring sekolah.
- Dashboard Kabalai + **5 modul filter fasilitas TIK** (akreditasi, bantuan, lab komputer, internet,
  listrik) dengan endpoint data & detail; grafik status verifikasi sekolah.
- Kolom kesiapan UNBK (`unbk_status`, `unbk_tahun`) pada sekolah.

### 4.2 Direncanakan (Backlog — belum ada di kode)
- Ekspor laporan (PDF/Excel) dari dashboard Kabalai.
- Audit trail aksi verifikasi.
- Notifikasi in-app/email saat status verifikasi berubah.
- Peta geospasial sebaran sekolah.
- Skor kesiapan TIK terkomputasi otomatis (indeks komposit dari listrik + lab + internet).

### 4.3 Di Luar Lingkup
- **Kompetensi guru** (dihapus dari sistem); integrasi Dapodik/SIAKAD real-time; SMS/WhatsApp
  gateway; aplikasi mobile native; manajemen anggaran bantuan.

---

## 5. Kebutuhan Fungsional per Fitur

### F-1 Manajemen Master Data (Administrator)
- **F-1.1** CRUD Kota/Kabupaten & Kecamatan (tertaut).
- **F-1.2** CRUD Periode dan menetapkan **satu** periode aktif.
- **F-1.3** CRUD Sekolah + impor Excel.
- **Kriteria terima:** menetapkan periode aktif baru; NPSN unik.

### F-2 Manajemen Akun (Administrator)
- **F-2.1** CRUD akun Operator Sekolah (tertaut `sekolah_id`) + impor Excel (email = NPSN).
- **F-2.2** CRUD user internal (Verifikator & Kabalai).
- **Kriteria terima:** email/NPSN unik; operator baru hanya melihat data sekolahnya.

### F-3 Pengisian Data Sekolah (Operator)
- **F-3.1** Isi/perbarui **identitas** sekolah (kepala sekolah, akreditasi, jumlah siswa/guru, UNBK).
- **F-3.2** Isi/perbarui **sosekbud** (geografis, sosekbud, akses transportasi).
- **F-3.3** Kelola **bantuan** (status + detail lembaga & keterangan; tambah/hapus).
- **F-3.4** Kelola **fasilitas TIK**: listrik (status/sumber/durasi), lab komputer (status, jumlah
  komputer, banyak lab dengan nama & jumlah PC), internet (status/sumber/bandwidth/topologi/kesesuaian).
- **F-3.5** **Ajukan verifikasi** (status → "diajukan").
- **Kriteria terima:** field wajib pada identitas & fasilitas tervalidasi; setelah diajukan, status
  tampil "menunggu verifikasi".

### F-4 Verifikasi (Verifikator)
- **F-4.1** Melihat daftar sekolah dengan yang **diajukan diprioritaskan** di atas.
- **F-4.2** Melihat **detail lengkap** (identitas + sosekbud + bantuan + fasilitas TIK).
- **F-4.3** **Menyetujui** atau **menolak** dengan `keterangan_verifikasi`.
- **F-4.4** Modul monitoring (monev) sekolah.
- **Kriteria terima:** status tersimpan (2=disetujui, 3=ditolak); penolakan menganjurkan keterangan.

### F-5 Dashboard & Filter Fasilitas TIK (Kabalai)
- **F-5.1** Dashboard ringkasan + grafik status verifikasi sekolah.
- **F-5.2** Filter & chart: akreditasi, status bantuan, lab komputer, internet, listrik.
- **F-5.3** Tiap filter menyediakan **data agregat** (chart) dan **detail per sekolah**.
- **Kriteria terima:** endpoint mengembalikan JSON valid; hanya data tervalidasi yang relevan
  diagregasi.

---

## 6. Kebutuhan Non-Fungsional

| Kategori | Kebutuhan |
|---|---|
| **Keamanan** | Auth wajib + verifikasi email; otorisasi per-peran via middleware; CSRF; bcrypt; rate limit login. |
| **Privasi** | Data kepala sekolah hanya diakses peran berwenang. |
| **Kinerja** | Halaman daftar & dashboard responsif untuk skala ratusan–ribuan sekolah (paginasi & indeks). |
| **Keandalan** | Integritas relasi via foreign key cascade/set null. |
| **Usabilitas** | UI Blade + Tailwind/Bootstrap, Bahasa Indonesia, responsif; impor Excel. |
| **Kompatibilitas** | Browser modern; PHP 8.2+, MySQL. |
| **Pemeliharaan** | Struktur MVC Laravel standar; migrasi berversi. |

---

## 7. Alur Pengguna Utama

### Alur A — Siklus Data Sekolah
```
Admin buat akun Operator + tautkan Sekolah
    → Operator login (NPSN) → isi identitas, sosekbud, fasilitas TIK, bantuan
    → Operator "Ajukan Verifikasi"
    → Verifikator review → Setujui / Tolak (+keterangan)
    → (jika ditolak) Operator revisi → ajukan ulang
    → (jika disetujui) data masuk agregasi Dashboard Kabalai
```

### Alur B — Pengambilan Keputusan Kabalai
```
Kabalai login → Dashboard → pilih filter (mis. Lab Komputer)
    → lihat chart agregat → drill-down detail sekolah
    → identifikasi sekolah belum siap → rekomendasi intervensi TIK
```

---

## 8. Asumsi & Ketergantungan

- Data awal sekolah dapat disiapkan dalam format Excel sesuai template impor.
- Setiap sekolah memiliki satu Operator sebagai penanggung jawab data.
- Server mendukung PHP 8.2+, MySQL, dan ekstensi untuk PhpSpreadsheet.
- Definisi ambang "kesiapan TIK" disepakati balai secara kebijakan (belum dikomputasi otomatis).

---

## 9. Risiko & Mitigasi

| Risiko | Dampak | Mitigasi |
|---|---|---|
| Kualitas data input rendah | Analitik menyesatkan | Validasi form + wajib verifikasi sebelum agregasi |
| Operator tidak mengisi tepat waktu | Data periode tidak lengkap | Reminder & dashboard kelengkapan *(backlog)* |
| Impor Excel gagal sebagian | Data parsial | Validasi header & laporan baris gagal *(backlog)* |
| Tidak ada audit verifikasi | Sulit telusur keputusan | Tambah audit trail *(backlog)* |
| Beban query dashboard | Lambat pada data besar | Paginasi, indeks kolom filter, cache agregat |

---

## 10. Kriteria Rilis (Definition of Done)

Baseline dianggap siap ketika:
1. Keempat peran dapat login dan diarahkan ke dashboard masing-masing dengan otorisasi benar.
2. Operator dapat menyelesaikan seluruh input sekolah (identitas, sosekbud, fasilitas TIK, bantuan)
   dan mengajukan verifikasi.
3. Verifikator dapat menyetujui/menolak, dan status terefleksi bagi operator.
4. Dashboard Kabalai menampilkan seluruh filter fasilitas TIK dengan data agregat & detail benar.
5. Impor Excel Sekolah/Operator berfungsi.
6. Tidak ada peran yang dapat mengakses rute peran lain.
7. Tidak ada sisa referensi ke modul guru (rute, controller, model, view).

---

> PRD ini merefleksikan kondisi produk pada basis kode `app-emoneva` setelah penyempitan fokus ke
> fasilitas TIK per 9 Juli 2026. Item backlog ditandai eksplisit dan belum terimplementasi.

# Dokumentasi Metodologi Pengembangan Sistem EMONEV
## Perbandingan & Penerapan Tahapan Agile dan Waterfall

Dokumen ini disusun untuk menjelaskan tahapan pengembangan aplikasi **EMONEV (e-Monitoring dan e-Evaluasi Berbasis TIK)** menggunakan dua pendekatan metodologi yang berjalan secara paralel/hibrida berdasarkan alur penelitian: **Agile** (jalur kiri) dan **Waterfall** (jalur kanan).

Hibridisasi kedua metode ini (sering disebut *Water-Scrum-Fall*) sangat efektif untuk penelitian akademis (skripsi). Kerangka kerja **Waterfall** digunakan untuk menjaga struktur tahapan penelitian secara keseluruhan agar tetap terorganisir secara linier, sementara **Agile** digunakan selama proses pengembangan teknis (coding) agar sistem dapat beradaptasi terhadap perubahan kebutuhan secara cepat.

---

## 1. Analisis Alur Penelitian (Flowchart)

Berdasarkan diagram alur penelitian, proses dimulai dari titik **Mulai** (*Start*) dan terbagi menjadi dua jalur metodologi utama sebelum akhirnya bertemu kembali pada tahap penyusunan hasil dan berakhir di **Selesai** (*End*).

```
                      ┌─────────┐
                      │  Mulai  │
                      └────┬────┘
            ┌──────────────┴──────────────┐
            ▼                             ▼
     [ Jalur Agile ]              [ Jalur Waterfall ]
 ┌─────────────────────┐       ┌──────────────────────┐
 │ Perencanaan Sistem  │       │  Analisis Kebutuhan  │
 └──────────┬──────────┘       └──────────┬───────────┘
            ▼                             ▼
 ┌─────────────────────┐       ┌──────────────────────┐
 │ Perancangan Sistem  │       │     Perancangan      │
 └──────────┬──────────┘       └──────────┬───────────┘
            ▼                             ▼
 ┌─────────────────────┐       ┌──────────────────────┐
 │ Pengembangan Sistem │       │     Implementasi     │
 └──────────┬──────────┘       └──────────┬───────────┘
            ▼                             ▼
 ┌─────────────────────┐       ┌──────────────────────┐
 │   Pengujian Sistem  │       │       Pengujian      │
 └──────────┬──────────┘       └──────────┬───────────┘
            │                             ▼
            │                  ┌──────────────────────┐
            │                  │     Pemeliharaan     │
            │                  └──────────┬───────────┘
            └──────────────┬──────────────┘
                           ▼
                      ┌─────────┐
                      │ Selesai │
                      └─────────┘
```

---

## 2. Penjelasan Tahapan Jalur Kiri: Agile (Iterative Development)

Metodologi Agile pada jalur kiri difokuskan pada fleksibilitas pengembangan modul perangkat lunak secara cepat dan berulang (*iterative*). Proses ini dilakukan dalam beberapa siklus pendek (*sprint*) untuk menyelesaikan modul-modul spesifik (seperti Modul Guru Mandiri, Modul Operator, Modul Verifikator, dll.).

### A. Perencanaan Sistem (System Planning)
* **Deskripsi:** Identifikasi awal terhadap kebutuhan pengguna yang dituangkan ke dalam *Product Backlog*.
* **Penerapan pada EMONEV:**
  * Penentuan prioritas fitur utama (misal: pendaftaran guru mandiri harus diselesaikan sebelum verifikator dapat menilai data mereka).
  * Pembuatan rencana kerja jangka pendek (*sprint planning*) berdurasi 1-2 minggu untuk menyelesaikan bagian-bagian kecil dari sistem.
  * Penyusunan daftar tugas (*backlog*) seperti: membuat formulir isian TIK, mengaktifkan fitur upload foto kepala sekolah, dan menyiapkan ekspor Excel.

### B. Perancangan Sistem (System Design)
* **Deskripsi:** Perancangan arsitektur dan antarmuka sistem secara cepat (*rapid prototyping*) untuk setiap backlog terpilih.
* **Penerapan pada EMONEV:**
  * Desain antarmuka pengguna (UI/UX) berbasis SB Admin 2 untuk halaman profil guru dan dashboard verifikator.
  * Perancangan skema database modular melalui Laravel Migrations (seperti tabel `gurus`, `sekolahs`, `guru_pelatihans`, dan `guru_kebutuhans`).
  * Perancangan *Use Case Diagram* per role (khusus untuk Guru, Operator, Verifikator, Kabalai, dan Admin) serta *Sequence Diagram* untuk menggambarkan interaksi antarkomponen sistem.

### C. Pengembangan Sistem (System Development)
* **Deskripsi:** Proses coding atau penulisan program secara inkremental.
* **Penerapan pada EMONEV:**
  * Penulisan kode program menggunakan framework Laravel, HTML5, Javascript, dan MySQL.
  * Implementasi logika bisnis di level Controller (misal: `GuruDashboardController` untuk memproses input kompetensi TIK dan mereset status verifikasi secara otomatis).
  * Pengintegrasian dependensi pihak ketiga seperti SweetAlert2 untuk notifikasi visual yang premium.

### D. Pengujian Sistem (System Testing)
* **Deskripsi:** Verifikasi fungsionalitas modul segera setelah dikembangkan untuk mendeteksi bug sedini mungkin.
* **Penerapan pada EMONEV:**
  * Pengujian unit menggunakan PHPUnit untuk memastikan autentikasi dan middleware (`Guru`, `Operator`, `Verifikator`, `Kabalai`) bekerja sesuai aturan hak akses.
  * Uji coba fungsional masukan form (misal: memastikan input "Sertifikasi = Ya" memvalidasi isian "Tahun Sertifikasi" secara wajib).
  * Jika ditemukan kesalahan, sistem langsung dikembalikan ke tahap perencanaan/perancangan kecil untuk diperbaiki pada iterasi berikutnya.

---

## 3. Penjelasan Tahapan Jalur Ranan: Waterfall (Structured Lifecycle)

Metodologi Waterfall pada jalur kanan diterapkan untuk memastikan proses penelitian skripsi berjalan secara terstruktur, sistematis, dan terdokumentasi dengan baik dari awal hingga akhir. Setiap tahap harus diselesaikan secara penuh sebelum melangkah ke tahap berikutnya.

### A. Analisis Kebutuhan (Requirements Analysis)
* **Deskripsi:** Pengumpulan kebutuhan fungsional dan non-fungsional sistem secara komprehensif di awal proyek.
* **Penerapan pada EMONEV:**
  * Melakukan wawancara dengan BTKI (Balai Teknologi Informasi dan Komunikasi) Dinas Pendidikan Provinsi Maluku mengenai alur monitoring TIK sekolah saat ini.
  * Menganalisis dokumen format isian fisik penilaian TIK sekolah dan kompetensi TIK guru.
  * Merumuskan kebutuhan sistem: dukungan multi-aktor (5 peran) dengan hak akses yang terisolasi secara ketat.

### B. Perancangan (Design)
* **Deskripsi:** Translasi analisis kebutuhan ke dalam desain teknis blueprint sistem sebelum penulisan kode dimulai secara menyeluruh.
* **Penerapan pada EMONEV:**
  * **Desain Database:** Pembuatan Entity Relationship Diagram (ERD) lengkap yang mencakup tabel wilayah, user, sekolah, fasilitas, dan detail kompetensi guru.
  * **Desain Sistem:** Pembuatan UML terpadu seperti *Unified Use Case Diagram* (5 aktor), *Class Diagram*, serta *Sequence Diagram Utama* (Alur Verifikasi Data).
  * **Desain Antarmuka:** Pembuatan mockup (wireframe) halaman web secara utuh.

### C. Implementasi (Implementation)
* **Deskripsi:** Tahap konstruksi di mana seluruh desain diubah menjadi baris program nyata.
* **Penerapan pada EMONEV:**
  * Pembagian modul kode program Laravel secara menyeluruh (pembuatan database seeder, migration, routing di `web.php`, logic Controller, dan view Blade).
  * Penerapan standar penulisan kode terstruktur, integrasi CSS kustom, dan optimalisasi query database (menggunakan Eloquent eager loading untuk mempercepat loading chart).

### D. Pengujian (Testing)
* **Deskripsi:** Pengujian sistem secara komprehensif setelah seluruh modul terintegrasi untuk menilai apakah produk akhir memenuhi kebutuhan awal.
* **Penerapan pada EMONEV:**
  * Melakukan **Black-Box Testing** untuk menguji fungsionalitas tombol, form input, alur unggahan berkas, dan respon validasi error.
  * Uji integrasi data: memastikan pengajuan verifikasi dari Operator Sekolah muncul dengan benar di dashboard Verifikator, dan hasil persetujuan/penolakan ter-update secara *real-time* di dashboard sekolah.
  * Pengujian kegunaan (*System Usability Scale*) kepada calon pengguna sesungguhnya (Guru, Operator, Admin Dinas).

### E. Pemeliharaan (Maintenance)
* **Deskripsi:** Tahapan dukungan berkelanjutan setelah aplikasi EMONEV dideploy (dirilis) di server produksi.
* **Penerapan pada EMONEV:**
  * Penanganan perbaikan bug baru (*bug fixing*) yang ditemukan oleh pengguna pasca-rilis.
  * Pembaruan database secara berkala ketika ada penambahan periode monitoring tahun ajaran baru.
  * Backup data secara rutin dan optimalisasi performa server web.

---

## 4. Hubungan Kedua Metode (Sintesis Hibrida)

| Karakteristik | Pendekatan Agile (Jalur Kiri) | Pendekatan Waterfall (Jalur Ranan) |
| :--- | :--- | :--- |
| **Fokus Utama** | Kecepatan coding, perbaikan bug cepat, adaptasi fitur dinamis. | Dokumentasi penelitian formal, struktur tahapan laporan skripsi, milestones proyek. |
| **Sifat Alur** | Berulang (*Iterative*) & Inkremental. | Sekuensial & Linier (Tahapan Berurutan). |
| **Hasil Tahapan** | Prototipe fitur fungsional siap rilis per *sprint*. | Dokumen laporan formal (Bab 3 Landasan Desain, Bab 4 Pengujian, dst.). |
| **Pengujian** | Dilakukan setiap kali sebuah fitur kecil selesai dibuat. | Dilakukan secara menyeluruh setelah integrasi total seluruh modul selesai. |

### Kesimpulan Penerapan:
Dalam skripsi ini, **Waterfall** bertindak sebagai **"Bingkai Besar Penelitian"** yang menjamin metode penelitian ilmiah terpenuhi (mulai dari Bab I Pendahuluan hingga Bab V Penutup secara runtut). Sementara itu, **Agile** bertindak sebagai **"Mesin Pelaksana Teknis"** yang digunakan di dalam fase konstruksi/pengembangan aplikasi (Bab III & Bab IV) untuk menghasilkan perangkat lunak yang andal, adaptif, dan bebas bug dalam waktu singkat.

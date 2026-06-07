# DOKUMENTASI METODE PENGEMBANGAN WATERFALL
## Penerapan Metode Sekuensial Linier pada Sistem E-MONEVA Maluku

Dokumen ini menjelaskan rancangan proses pengembangan sistem **E-MONEVA (e-Monitoring dan e-Evaluasi Kesiapan TIK & Kompetensi Guru Berbasis Web)** apabila dikerjakan secara murni menggunakan metodologi **Waterfall** (Sekuensial Linier). 

Dokumentasi ini disusun untuk memenuhi kebutuhan akademis (penulisan Bab Metodologi Skripsi), di mana seluruh tahapan berjalan secara runtut dari atas ke bawah (seperti air terjun), dan setiap tahapan harus diselesaikan secara penuh sebelum beralih ke tahapan berikutnya.

---

## 1. Karakteristik & Alasan Pemilihan Metode Waterfall
Metode Waterfall sangat cocok diterapkan pada pengembangan sistem E-MONEVA ini karena beberapa alasan berikut:
1. **Kebutuhan Sistem yang Jelas dan Stabil:** Spesifikasi sistem, peran pengguna (5 Aktor), serta instrumen penilaian kesiapan TIK dan kompetensi guru telah didefinisikan dengan jelas sejak awal berdasarkan pedoman Dinas Pendidikan Provinsi Maluku (BTKI).
2. **Dokumentasi yang Terstruktur:** Sangat mendukung penulisan laporan Skripsi karena setiap fase menghasilkan dokumen *deliverable* yang menjadi dasar bagi fase berikutnya (misalnya, dokumen analisis kebutuhan menjadi dasar pembuatan diagram desain, dan diagram desain menjadi acuan pemrograman).
3. **Kemudahan Manajemen Proyek:** Setiap tahap memiliki pintu masuk (*entry gate*) dan pintu keluar (*exit gate*) serta target luaran (*milestones*) yang terdefinisi secara ketat.

```
┌──────────────────────────────────────────────┐
│  Requirements Analysis (Analisis Kebutuhan)   │
└──────────────────────┬───────────────────────┘
                       ▼
         ┌──────────────────────────────┐
         │     System Design (Desain)   │
         └─────────────┬────────────────┘
                       ▼
                ┌──────────────────────────────┐
                │ Implementation (Coding)      │
                └──────────────┬───────────────┘
                               ▼
                       ┌──────────────────────────────┐
                       │     Testing (Pengujian)      │
                       └──────────────┬───────────────┘
                                      ▼
                              ┌──────────────────────────────┐
                              │  Maintenance (Pemeliharaan)  │
                              └──────────────────────────────┘
```

---

## 2. Tahapan Detail Penerapan Waterfall pada Sistem E-MONEVA

### TAHAP 1: Analisis Kebutuhan (Requirements Analysis)
Pada tahap awal ini, dilakukan pengumpulan dan analisis seluruh kebutuhan sistem secara menyeluruh sebelum merancang sistem. 

*   **Aktivitas Utama:**
    *   **Studi Literatur & Kebijakan:** Menganalisis peraturan Dinas Pendidikan mengenai standar sarana prasarana TIK sekolah dan standar kompetensi TIK guru.
    *   **Wawancara Pemangku Kepentingan:** Melakukan wawancara dengan Kepala BTKI (Kabalai) dan staf Dinas Pendidikan Maluku untuk memetakan alur verifikasi data dan kebutuhan pelaporan statistik.
    *   **Identifikasi Pengguna (5 Aktor):**
        1.  *Administrator:* Mengelola data master (wilayah, periode aktif), sekolah, dan akun pengguna.
        2.  *Operator Sekolah:* Menginput data fasilitas sekolah (listrik, internet, lab komputer, bantuan TIK) dan data guru internal sekolah.
        3.  *Guru Mandiri:* Menginput data profil, kompetensi TIK secara mandiri, riwayat pelatihan, dan mengajukan kebutuhan pelatihan.
        4.  *Verifikator:* Memeriksa kesesuaian berkas pendukung, memvalidasi data sekolah/guru, dan memberikan rekomendasi hasil Monev.
        5.  *Kabalai (Kepala BTKI):* Mengakses grafik statistik tingkat tinggi (real-time) sebagai bahan pengambilan kebijakan.
    *   **Kebutuhan Non-Fungsional:**
        *   Sistem harus berbasis web (Laravel) agar mudah diakses dari berbagai wilayah di Maluku.
        *   Keamanan data terisolasi menggunakan Middleware (hanya aktor yang memiliki role sesuai yang dapat mengakses rute tertentu) agar integritas data terjamin.

*   **Luaran Dokumen (Deliverable):** Dokumen **SRS (Software Requirements Specification)** yang memuat deskripsi lengkap kebutuhan fungsional (22 Use Cases) dan non-fungsional.

---

### TAHAP 2: Perancangan Sistem (System Design)
Desain diterjemahkan dari dokumen SRS. Di tahap ini, seluruh arsitektur sistem dirancang secara logis dan fisik sebelum masuk ke penulisan kode.

*   **Aktivitas Utama:**
    *   **Perancangan Struktur Data (Database Design):**
        *   Merancang ERD (Entity Relationship Diagram) yang memetakan hubungan antara 13 tabel utama (seperti `users`, `sekolahs`, `gurus`, `sekolah_fasilitas`, `guru_pelatihans`, `kotas`, `kecamatans`, dan `periodes`).
        *   Menentukan relasi kardinalitas (misal: satu sekolah memiliki satu fasilitas komputer, satu guru memiliki banyak riwayat pelatihan).
    *   **Perancangan Proses (UML Diagrams):**
        *   *Use Case Diagram:* Memetakan hak akses 5 aktor terhadap 22 fitur utama.
        *   *Sequence Diagram:* Menggambarkan urutan pertukaran pesan antar objek saat Guru/Operator mengajukan data hingga diverifikasi oleh Verifikator.
        *   *Class Diagram:* Mendefinisikan class model Eloquent beserta atribut dan metodenya.
    *   **Perancangan Antarmuka (UI/UX Design):**
        *   Merancang mockup antarmuka halaman login, dashboard statistik Kabalai, form isian data TIK Operator, dan halaman verifikasi Guru menggunakan desain responsif berbasis template SB Admin 2.

*   **Luaran Dokumen (Deliverable):** Dokumen **SDD (Software Design Document)** yang memuat rancangan ERD, Diagram UML (Use Case, Sequence, Class, Activity), dan Mockup Antarmuka.

---

### TAHAP 3: Implementasi (Implementation / Coding)
Setelah rancangan sistem disetujui secara penuh, tim pengembang mulai menerjemahkan dokumen desain menjadi kode program. Pada metode Waterfall, penulisan kode dilakukan secara menyeluruh untuk semua modul.

*   **Aktivitas Utama:**
    *   **Inisialisasi Proyek & Database:**
        *   Membuat migrasi database (`Laravel Migrations`) untuk 13 tabel berbasis MySQL.
        *   Membuat Seeder untuk wilayah Kota/Kecamatan di Provinsi Maluku dan akun uji coba 5 aktor awal.
    *   **Pengembangan Sisi Server (Backend Development):**
        *   Mengimplementasikan route di [web.php](file:///c:/Documents/SKRIPSI/app-emoneva/routes/web.php).
        *   Membangun Controller utama seperti `GuruController`, `DataSekolahController`, `VerifikasiProsesController`, dan `FilterAkreditasiController`.
        *   Mengaktifkan Middleware autentikasi di `Administrator.php` dan file middleware kustom lainnya.
    *   **Pengembangan Sisi Klien (Frontend Development):**
        *   Implementasi template Blade Laravel menggunakan integrasi CSS kustom dan javascript interaktif.
        *   Mengintegrasikan visualisasi grafik (Chart.js) untuk statistik kesiapan TIK dan kompetensi guru di dashboard Kabalai.
        *   Menambahkan notifikasi menggunakan SweetAlert2.

*   **Luaran Dokumen (Deliverable):** Source code lengkap aplikasi E-MONEVA yang sudah terintegrasi dan siap diuji secara keseluruhan.

---

### TAHAP 4: Pengujian (Testing)
Pengujian pada metode Waterfall baru dilakukan setelah seluruh modul selesai dikodekan dan diintegrasikan. Tahapan ini bertujuan untuk memastikan sistem berjalan tanpa cela dan sesuai dengan spesifikasi awal di Tahap 1.

*   **Aktivitas Utama:**
    *   **Pengujian Unit (Unit Testing):** Menguji fungsi-fungsi spesifik (seperti enkripsi password, kalkulasi skor kompetensi, filter query wilayah) menggunakan PHPUnit.
    *   **Pengujian Black-Box (Fungsional):** 
        *   Menguji fungsionalitas seluruh form input, tombol, alur pengunggahan berkas bukti dukung, dan validasi data.
        *   Memastikan alur bisnis utama: Operator mengajukan verifikasi data sekolah -> Verifikator memeriksa -> Dashboard Kabalai menampilkan statistik terbaru secara real-time.
    *   **Pengujian Pengguna (User Acceptance Testing - UAT):** Mengundang calon pengguna (operator sekolah, guru, perwakilan dinas) untuk menguji aplikasi dan mengukur kenyamanan menggunakan instrumen **System Usability Scale (SUS)**.

*   **Luaran Dokumen (Deliverable):** Dokumen **Test Plan & Test Reports** (Laporan Hasil Pengujian) yang mendokumentasikan skenario uji coba, status keberhasilan (Pass/Fail), dan skor SUS.

---

### TAHAP 5: Operasional & Pemeliharaan (Operations & Maintenance)
Tahap ini dimulai setelah aplikasi E-MONEVA dideploy secara resmi di server hosting BTKI Dinas Pendidikan Provinsi Maluku dan digunakan secara nyata oleh sekolah-sekolah.

*   **Aktivitas Utama:**
    *   **Deployment:** Mengunggah file project ke server produksi, mengonfigurasi file `.env` produksi, mengaktifkan SSL, dan melakukan migrasi database akhir.
    *   **Koreksi Bug (Bug Fixing):** Memperbaiki kesalahan-kesalahan kecil yang baru terdeteksi setelah sistem menghadapi data nyata di lapangan.
    *   **Penyesuaian Konfigurasi:** Mengubah parameter kunci periode input data ketika ada pergantian tahun ajaran/evaluasi.
    *   **Backup & Security:** Melakukan pencadangan (backup) database MySQL secara berkala dan memantau log keamanan server agar data sekolah/guru tidak bocor.

*   **Luaran Dokumen (Deliverable):** Laporan pemeliharaan sistem berkala dan log pembaruan patch (*changelog*).

---

## 3. Analisis Kelebihan dan Kelemahan Penerapan Waterfall pada Sistem E-MONEVA

| Aspek | Kelebihan Penerapan Waterfall | Kelemahan Penerapan Waterfall |
| :--- | :--- | :--- |
| **Manajemen Dokumen** | Menghasilkan dokumentasi akademis yang sangat lengkap, rapi, dan sistematis. Memudahkan penulisan bab 3, 4, dan 5 pada Skripsi. | Membutuhkan waktu lama di awal hanya untuk menulis dokumen spesifikasi sebelum coding bisa dimulai. |
| **Keterlibatan Pengguna** | Pengguna (Dinas Pendidikan) hanya perlu terlibat intensif di awal (analisis) dan di akhir (pengujian UAT). | Jika pengguna menyadari adanya perubahan kebutuhan di tengah jalan (misal: penambahan kolom isian baru), perubahan tersebut sangat sulit dimasukkan tanpa mengulang proses dari awal. |
| **Kejelasan Proyek** | Milestones proyek sangat jelas. Persentase progres pengembangan mudah diukur (misal: "Tahap Desain sudah 100% selesai"). | Risiko kegagalan sistem terdeteksi terlambat. Jika ada kesalahan logika pada tahap analisis/desain, bug tersebut baru akan diketahui di tahap pengujian (akhir proyek). |
| **Kualitas Kode** | Karena arsitektur database (13 tabel) telah dirancang matang di awal, kode program cenderung lebih rapi dan minim tambal sulam. | Tim pengembang tidak dapat menghasilkan prototipe fungsional yang bisa dicoba langsung oleh klien di pertengahan waktu pengembangan. |

---

## 4. Kesimpulan untuk Penulisan Skripsi
Metode **Waterfall** sangat direkomendasikan jika penelitian Skripsi Anda menuntut **kedisiplinan metodologi yang kaku** dan **dokumentasi ilmiah yang lengkap**. 

Dengan menggunakan pendekatan Waterfall secara penuh pada sistem E-MONEVA:
1. Anda meminimalkan risiko terjadinya *scope creep* (perluasan fitur sistem di tengah jalan yang membuat skripsi tidak kunjung selesai).
2. Anda memiliki dasar teori yang kuat untuk menyusun Laporan Skripsi secara linier (Bab 3: Analisis & Perancangan, Bab 4: Implementasi & Pengujian, Bab 5: Kesimpulan).


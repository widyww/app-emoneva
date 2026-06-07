# PANDUAN CLASS DIAGRAM SISTEM EMONEV

Class Diagram digunakan untuk merancang struktur basis data relasional pada MySQL sekaligus memetakan objek model dalam kerangka kerja perangkat lunak. Diagram ini memvisualisasikan atribut, operasi, dan kardinalitas antar-entitas utama penyusun sistem, yang secara garis besar meliputi entitas User, Sekolah, Guru, SekolahFasilitas, SekolahSosekbud, SekolahBantuanStatus, GuruPelatihan, GuruKebutuhan, Kota, Kecamatan, dan Periode.

File diagram Draw.io dapat diakses di: **[class_diagram.drawio](file:///c:/Documents/SKRIPSI/app-emoneva/class_diagram.drawio)**

---

## 1. STRUKTUR ARSITEKTUR KELAS (13 MODEL)
Sistem EMONEV dirancang secara modular dengan total **13 model data** yang dikelompokkan ke dalam beberapa area fungsional:

### A. Core Entities (Entitas Utama)
*   **[User](file:///c:/Documents/SKRIPSI/app-emoneva/app/Models/User.php)**: Mengelola kredensial otentikasi login pengguna dengan role pembagian hak akses (*Admin, Operator, Verifikator, Kabalai, Guru*).
*   **[Sekolah](file:///c:/Documents/SKRIPSI/app-emoneva/app/Models/Sekolah.php)**: Representasi data profil sekolah, rekapitulasi data siswa/guru, status verifikasi berkas sekolah, serta akreditasi.
*   **[Guru](file:///c:/Documents/SKRIPSI/app-emoneva/app/Models/Guru.php)**: Mengelola profil lengkap pendidik, kompetensi TIK (Word, Excel, PPT, Pemrograman, Jaringan, Multimedia), status sertifikasi, dan status verifikasi berkas guru.

### B. Sub-Entitas Sekolah (Fasilitas & Penunjang)
*   **[SekolahFasilitas](file:///c:/Documents/SKRIPSI/app-emoneva/app/Models/SekolahFasilitas.php)**: Penilaian kelayakan sarana TIK seperti ketersediaan listrik, bandwidth internet, sumber kuota, dan topologi jaringan.
*   **[SekolahFasilitasLab](file:///c:/Documents/SKRIPSI/app-emoneva/app/Models/SekolahFasilitasLab.php)**: Rincian jumlah laboratorium komputer di masing-masing sekolah beserta kondisi kelayakannya.
*   **[SekolahSosekbud](file:///c:/Documents/SKRIPSI/app-emoneva/app/Models/SekolahSosekbud.php)**: Catatan faktor sosial, ekonomi, budaya, potensi wilayah, dan hambatan geografis yang memengaruhi kondisi sekolah.
*   **[SekolahBantuanStatus](file:///c:/Documents/SKRIPSI/app-emoneva/app/Models/SekolahBantuanStatus.php)**: Status penerimaan bantuan pemerintah di tingkat sekolah.
*   **[SekolahBantuanDetail](file:///c:/Documents/SKRIPSI/app-emoneva/app/Models/SekolahBantuanDetail.php)**: Rincian jenis bantuan, tahun terima, dan tingkat pemanfaatannya di sekolah.

### C. Sub-Entitas Guru (Riwayat & Kebutuhan)
*   **[GuruPelatihan](file:///c:/Documents/SKRIPSI/app-emoneva/app/Models/GuruPelatihan.php)**: Daftar riwayat pelatihan TIK yang pernah diikuti oleh guru.
*   **[GuruKebutuhan](file:///c:/Documents/SKRIPSI/app-emoneva/app/Models/GuruKebutuhan.php)**: Rencana pelatihan TIK yang paling dibutuhkan guru berdasarkan skala prioritas.

### D. Wilayah & Konfigurasi Sistem
*   **[Kota](file:///c:/Documents/SKRIPSI/app-emoneva/app/Models/Kota.php)**: Daftar Kabupaten/Kota di wilayah Provinsi Maluku.
*   **[Kecamatan](file:///c:/Documents/SKRIPSI/app-emoneva/app/Models/Kecamatan.php)**: Daftar Kecamatan yang menginduk pada Kabupaten/Kota.
*   **[Periode](file:///c:/Documents/SKRIPSI/app-emoneva/app/Models/Periode.php)**: Manajemen tahun ajaran monitoring yang sedang aktif (misal: Periode 2026/2027).

---

## 2. RELASI ANTAR KELAS (RELATIONSHIPS)
Relasi antarmodel Eloquent didefinisikan secara tegas untuk mendukung keutuhan referensi data (*data integrity*):

1.  **Wilayah ke Sekolah:**
    *   `Kota` hasMany `Kecamatan`, `Kecamatan` belongsTo `Kota` (`kota_id`).
    *   `Kota` hasMany `Sekolah`, `Kecamatan` hasMany `Sekolah`.
    *   `Sekolah` belongsTo `Kota` & `Kecamatan`.
2.  **Otentikasi & Profil Utama:**
    *   `User` belongsTo `Sekolah` (`sekolah_id`) dan `Guru` (`guru_id`).
    *   `Guru` belongsTo `Sekolah` (`sekolah_id`).
    *   `Guru` hasOne `User` (untuk akun klaim login mandiri).
3.  **Sekolah ke Sub-Data:**
    *   `Sekolah` hasOne `SekolahFasilitas`, yang kemudian hasMany `SekolahFasilitasLab`.
    *   `Sekolah` hasOne `SekolahSosekbud`.
    *   `Sekolah` hasOne `SekolahBantuanStatus`, yang kemudian hasMany `SekolahBantuanDetail`.
4.  **Guru ke Sub-Data:**
    *   `Guru` hasMany `GuruPelatihan`.
    *   `Guru` hasMany `GuruKebutuhan`.

# PANDUAN SEQUENCE DIAGRAM SISTEM EMONEV

Dokumen ini menjelaskan alur pesan (*message exchange*) dan urutan aktivitas antar-komponen dalam sistem **EMONEV (e-Monitoring dan e-Evaluasi)**. Dokumentasi ini mencakup diagram sekuensial utama yang merepresentasikan interaksi sistem secara *end-to-end*.

---

## 1. Sequence Diagram Utama: Alur Pengisian & Verifikasi Data (EMONEV)
Diagram ini memvisualisasikan bagaimana data kompetensi yang diinput oleh Guru/Operator diproses oleh sistem, dinilai oleh Verifikator, hingga statusnya diperbarui secara dinamis pada dashboard pengguna.

File diagram Draw.io dapat diakses di: **[sequence_diagram.drawio](file:///c:/Documents/SKRIPSI/app-emoneva/sequence_diagram.drawio)**

### Penjelasan Alur Sistem:
Sequence Diagram berfungsi memvisualisasikan pertukaran pesan (*message exchange*) antar-komponen sistem secara sekuensial. Untuk merepresentasikan keseluruhan proses secara (*end-to-end*), diagram dirancang melibatkan aktor Guru/Operator, Verifikator, antarmuka web (Blade View), Laravel Controller, Model Eloquent, dan Database MySQL. Alur aktivitas dimulai dari Guru/Operator yang melakukan input data kompetensi TIK dan mengeklik Simpan pada Form/Dashboard UI, dilanjutkan oleh pemrosesan sistem di mana Laravel Controller mengeksekusi logika penyimpanan ke database melalui Model Eloquent, hingga status pengajuan diset sebagai 'Menunggu Verifikasi'. Verifikator kemudian mengambil alih alur dengan melakukan peninjauan berkas bukti dukung melalui antarmuka detail verifikasi, di mana keputusan akhir (Setuju/Tolak + Catatan) dikirimkan kembali untuk memperbarui database, hingga sistem menutup aktivitas dengan menyajikan pembaruan status terbaru kepada Guru/Operator saat membuka halaman dashboard.


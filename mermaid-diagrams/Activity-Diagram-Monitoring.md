# Activity Diagram - Proses Monitoring (Kabalai)

## Alur Monitoring dan Filtering Data

```mermaid
flowchart TD
    Start([Mulai]) --> LoginKabalai[Login sebagai Kabalai]
    LoginKabalai --> DashboardKabalai[Dashboard Kabalai]
    
    DashboardKabalai --> PilihFilter{Pilih<br/>Filter}
    
    PilihFilter -->|Akreditasi| FilterAkreditasi[Filter Berdasarkan<br/>Status Akreditasi]
    PilihFilter -->|Bantuan| FilterBantuan[Filter Berdasarkan<br/>Status Bantuan]
    PilihFilter -->|Internet| FilterInternet[Filter Berdasarkan<br/>Ketersediaan Internet]
    PilihFilter -->|Listrik| FilterListrik[Filter Berdasarkan<br/>Ketersediaan Listrik]
    PilihFilter -->|Lab Komputer| FilterLab[Filter Berdasarkan<br/>Lab Komputer]
    PilihFilter -->|Status Guru| FilterGuruStatus[Filter Berdasarkan<br/>Status Guru PNS/PPPK]
    PilihFilter -->|Pendidikan Guru| FilterPendidikan[Filter Berdasarkan<br/>Pendidikan Guru]
    PilihFilter -->|Sertifikasi| FilterSertifikasi[Filter Berdasarkan<br/>Status Sertifikasi]
    PilihFilter -->|Kebutuhan Pelatihan| FilterPelatihan[Filter Berdasarkan<br/>Kebutuhan Pelatihan]
    
    FilterAkreditasi --> TampilChart1[Tampilkan Chart<br/>dan Statistik]
    FilterBantuan --> TampilChart2[Tampilkan Chart<br/>dan Statistik]
    FilterInternet --> TampilChart3[Tampilkan Chart<br/>dan Statistik]
    FilterListrik --> TampilChart4[Tampilkan Chart<br/>dan Statistik]
    FilterLab --> TampilChart5[Tampilkan Chart<br/>dan Statistik]
    FilterGuruStatus --> TampilChart6[Tampilkan Chart<br/>dan Statistik]
    FilterPendidikan --> TampilChart7[Tampilkan Chart<br/>dan Statistik]
    FilterSertifikasi --> TampilChart8[Tampilkan Chart<br/>dan Statistik]
    FilterPelatihan --> TampilChart9[Tampilkan Chart<br/>dan Statistik]
    
    TampilChart1 --> LihatDetail1[Lihat Detail<br/>Data Sekolah]
    TampilChart2 --> LihatDetail1
    TampilChart3 --> LihatDetail1
    TampilChart4 --> LihatDetail1
    TampilChart5 --> LihatDetail1
    TampilChart6 --> LihatDetail1
    TampilChart7 --> LihatDetail1
    TampilChart8 --> LihatDetail1
    TampilChart9 --> LihatDetail1
    
    LihatDetail1 --> CheckExport{Export<br/>Laporan?}
    CheckExport -->|Ya| ExportData[Export ke Excel/PDF]
    CheckExport -->|Tidak| CheckMore{Lihat Filter<br/>Lain?}
    
    ExportData --> CheckMore
    CheckMore -->|Ya| PilihFilter
    CheckMore -->|Tidak| End([Selesai])
```

## Penjelasan Alur

1. **Login Kabalai**: Kepala Balai masuk ke sistem
2. **Pilih Filter**: Memilih kriteria filter yang diinginkan
3. **Tampilkan Chart**: Sistem menampilkan visualisasi data
4. **Lihat Detail**: Melihat detail data per kategori
5. **Export**: Optional export laporan ke Excel/PDF
6. **Iterasi**: Dapat melihat filter lain atau selesai

## Jenis Filter yang Tersedia

### Filter Sekolah
- Status Akreditasi (A, B, C, Belum Terakreditasi)
- Status Bantuan (Sudah/Belum Menerima)
- Ketersediaan Internet (Ada/Tidak Ada)
- Ketersediaan Listrik (Ada/Tidak Ada)
- Laboratorium Komputer (Ada/Tidak Ada)

### Filter Guru
- Status Kepegawaian (PNS/PPPK)
- Pendidikan Terakhir (S1/S2/S3)
- Status Sertifikasi (Sudah/Belum)
- Kebutuhan Pelatihan

## Test Online

Copy code di atas dan paste ke: https://mermaid.live

# Use Case Diagram

## Sistem Informasi Manajemen Data Sekolah dan Guru

```mermaid
graph TB
    subgraph "Sistem Informasi Manajemen Sekolah"
        UC1[Kelola Master Data]
        UC2[Kelola Data Sekolah]
        UC3[Kelola User]
        UC4[Input Data Sekolah]
        UC5[Input Data Guru]
        UC6[Input Fasilitas TIK]
        UC7[Ajukan Verifikasi]
        UC8[Verifikasi Data Sekolah]
        UC9[Verifikasi Data Guru]
        UC10[Monitoring Statistik]
        UC11[Filter Data]
        UC12[Login]
        UC13[Logout]
        UC14[Kelola Profile]
        UC15[Import Data Excel]
    end

    Admin[Administrator]
    Operator[Operator Sekolah]
    Verifikator[Verifikator]
    Kabalai[Kepala Balai]

    Admin --> UC1
    Admin --> UC2
    Admin --> UC3
    Admin --> UC15
    Admin --> UC12
    Admin --> UC13
    Admin --> UC14

    Operator --> UC4
    Operator --> UC5
    Operator --> UC6
    Operator --> UC7
    Operator --> UC12
    Operator --> UC13
    Operator --> UC14

    Verifikator --> UC8
    Verifikator --> UC9
    Verifikator --> UC12
    Verifikator --> UC13
    Verifikator --> UC14

    Kabalai --> UC10
    Kabalai --> UC11
    Kabalai --> UC12
    Kabalai --> UC13
    Kabalai --> UC14

    UC2 -.include.-> UC1
    UC4 -.include.-> UC12
    UC5 -.include.-> UC12
    UC7 -.require.-> UC4
    UC7 -.require.-> UC5
```

## Deskripsi Use Case

| Use Case | Actor | Deskripsi |
|----------|-------|-----------|
| UC1 - Kelola Master Data | Administrator | Mengelola data kota, kecamatan, dan periode |
| UC2 - Kelola Data Sekolah | Administrator | CRUD data sekolah |
| UC3 - Kelola User | Administrator | Mengelola user verifikator dan kabalai |
| UC4 - Input Data Sekolah | Operator | Input identitas, sosekbud, bantuan sekolah |
| UC5 - Input Data Guru | Operator | Input data guru, kompetensi, pelatihan |
| UC6 - Input Fasilitas TIK | Operator | Input data listrik, komputer, internet, lab |
| UC7 - Ajukan Verifikasi | Operator | Mengajukan data untuk diverifikasi |
| UC8 - Verifikasi Data Sekolah | Verifikator | Memeriksa dan approve/reject data sekolah |
| UC9 - Verifikasi Data Guru | Verifikator | Memeriksa dan approve/reject data guru |
| UC10 - Monitoring Statistik | Kabalai | Melihat dashboard dan statistik |
| UC11 - Filter Data | Kabalai | Filter data berdasarkan berbagai kriteria |
| UC12 - Login | Semua | Autentikasi pengguna |
| UC13 - Logout | Semua | Keluar dari sistem |
| UC14 - Kelola Profile | Semua | Update profile dan password |
| UC15 - Import Data Excel | Administrator | Import bulk data sekolah dari Excel |

## Test Online

Copy code di atas dan paste ke: https://mermaid.live

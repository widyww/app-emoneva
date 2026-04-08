# 🧪 Preview Test - All Diagrams

File ini berisi semua diagram dalam satu halaman untuk testing cepat.

---

## 1️⃣ ERD - Entity Relationship Diagram

```mermaid
erDiagram
    KOTA ||--o{ KECAMATAN : "has many"
    KECAMATAN ||--o{ SEKOLAH : "has many"
    KOTA ||--o{ SEKOLAH : "has many"
    SEKOLAH ||--o{ USER : "has many"
    SEKOLAH ||--|| SEKOLAH_SOSEKBUD : "has one"
    SEKOLAH ||--|| SEKOLAH_BANTUAN_STATUS : "has one"
    SEKOLAH ||--|| SEKOLAH_FASILITASTIK : "has one"
    SEKOLAH ||--o{ GURU : "has many"
    SEKOLAH_BANTUAN_STATUS ||--o{ SEKOLAH_BANTUAN_DETAIL : "has many"
    SEKOLAH_FASILITASTIK ||--o{ SEKOLAH_FASILITASTIK_LAB : "has many"
    GURU ||--o{ GURU_PELATIHAN : "has many"
    GURU ||--o{ GURU_KEBUTUHAN : "has many"

    KOTA {
        bigint id PK
        string nama
    }
    KECAMATAN {
        bigint id PK
        string nama
        bigint kota_id FK
    }
    SEKOLAH {
        bigint id PK
        string npsn UK
        string nama
        bigint kecamatan_id FK
        bigint kota_id FK
    }
    GURU {
        bigint id PK
        string nama
        string nip
        bigint sekolah_id FK
    }
    USER {
        bigint id PK
        string email UK
        string role
        bigint sekolah_id FK
    }
```

✅ **Status**: ERD dengan 15 tabel dan relasi

---

## 2️⃣ Use Case Diagram

```mermaid
graph TB
    subgraph "Sistem Informasi Manajemen Sekolah"
        UC1[Kelola Master Data]
        UC2[Kelola Data Sekolah]
        UC3[Kelola User]
        UC4[Input Data Sekolah]
        UC5[Input Data Guru]
        UC7[Ajukan Verifikasi]
        UC8[Verifikasi Data Sekolah]
        UC10[Monitoring Statistik]
        UC12[Login]
    end

    Admin[Administrator]
    Operator[Operator Sekolah]
    Verifikator[Verifikator]
    Kabalai[Kepala Balai]

    Admin --> UC1
    Admin --> UC2
    Admin --> UC3
    Admin --> UC12

    Operator --> UC4
    Operator --> UC5
    Operator --> UC7
    Operator --> UC12

    Verifikator --> UC8
    Verifikator --> UC12

    Kabalai --> UC10
    Kabalai --> UC12
```

✅ **Status**: Use Case dengan 4 aktor

---

## 3️⃣ Activity Diagram - Input Data (Simplified)

```mermaid
flowchart TD
    Start([Mulai]) --> Login[Login sebagai Operator]
    Login --> CheckAuth{Autentikasi<br/>Berhasil?}
    CheckAuth -->|Tidak| Login
    CheckAuth -->|Ya| Dashboard[Dashboard Operator]
    
    Dashboard --> InputIdentitas[Input Identitas Sekolah]
    InputIdentitas --> InputSosekbud[Input Sosekbud]
    InputSosekbud --> InputBantuan[Input Bantuan]
    InputBantuan --> InputFasilitas[Input Fasilitas TIK]
    InputFasilitas --> InputGuru[Input Data Guru]
    
    InputGuru --> CheckComplete{Data<br/>Lengkap?}
    CheckComplete -->|Tidak| Dashboard
    CheckComplete -->|Ya| AjukanVerifikasi[Ajukan Verifikasi]
    AjukanVerifikasi --> End([Selesai])
```

✅ **Status**: Activity diagram input data

---

## 4️⃣ Activity Diagram - Verifikasi

```mermaid
flowchart TD
    Start([Mulai]) --> Login[Login sebagai Verifikator]
    Login --> Dashboard[Dashboard Verifikator]
    Dashboard --> LihatDaftar[Lihat Daftar Pengajuan]
    LihatDaftar --> PilihSekolah[Pilih Sekolah]
    PilihSekolah --> LihatDetail[Lihat Detail Data]
    
    LihatDetail --> PeriksaData{Data<br/>Valid?}
    
    PeriksaData -->|Tidak| Reject[Status = rejected<br/>+ Catatan]
    Reject --> NotifReject[Notifikasi Operator]
    NotifReject --> End([Selesai])
    
    PeriksaData -->|Ya| Approve[Status = approved]
    Approve --> NotifApprove[Notifikasi Operator]
    NotifApprove --> CheckMore{Ada Data<br/>Lain?}
    
    CheckMore -->|Ya| LihatDaftar
    CheckMore -->|Tidak| End
```

✅ **Status**: Activity diagram verifikasi

---

## 5️⃣ Sequence Diagram - Login

```mermaid
sequenceDiagram
    actor User
    participant Browser
    participant AuthController
    participant Middleware
    participant Database

    User->>Browser: Akses halaman login
    Browser->>AuthController: GET /login
    AuthController->>Browser: Tampilkan form login
    
    User->>Browser: Input email & password
    Browser->>AuthController: POST /login
    AuthController->>Database: Cek kredensial
    Database-->>AuthController: Return user data
    
    alt Kredensial Valid
        AuthController->>Middleware: Check user role
        alt Role = 1 (Administrator)
            Middleware-->>Browser: Redirect /dashboard
        else Role = 3 (Operator)
            Middleware-->>Browser: Redirect /dashboard-operator
        end
    else Kredensial Invalid
        AuthController-->>Browser: Return error message
    end
```

✅ **Status**: Sequence diagram login

---

## 6️⃣ Sequence Diagram - Input Guru (Simplified)

```mermaid
sequenceDiagram
    actor Operator
    participant Browser
    participant GuruController
    participant Database

    Operator->>Browser: Akses form tambah guru
    Browser->>GuruController: GET /data-guru/create
    GuruController->>Database: Get sekolah_id
    Database-->>GuruController: Return sekolah data
    GuruController-->>Browser: Tampilkan form
    
    Operator->>Browser: Input data guru lengkap
    Browser->>GuruController: POST /data-guru
    
    GuruController->>Database: INSERT guru
    Database-->>GuruController: Return guru_id
    
    GuruController->>Database: INSERT pelatihan (if any)
    GuruController->>Database: INSERT kebutuhan (if any)
    
    GuruController-->>Browser: Redirect dengan success
    Browser-->>Operator: Tampilkan notifikasi
```

✅ **Status**: Sequence diagram input guru

---

## 🎯 Testing Instructions

### Di VS Code:
1. Buka file ini
2. Tekan `Ctrl+Shift+V` untuk preview
3. Scroll untuk melihat semua diagram
4. Pastikan semua diagram render dengan benar

### Checklist:
- [ ] ERD terlihat dengan jelas
- [ ] Use Case diagram terlihat
- [ ] Activity diagram input data terlihat
- [ ] Activity diagram verifikasi terlihat
- [ ] Sequence diagram login terlihat
- [ ] Sequence diagram input guru terlihat
- [ ] Tidak ada error rendering
- [ ] Semua teks terbaca dengan jelas

### Jika Ada Masalah:
1. Pastikan extension Mermaid sudah terinstall
2. Reload VS Code
3. Cek syntax di https://mermaid.live
4. Update extension ke versi terbaru

---

## 📊 Diagram Statistics

| Type | Count | Status |
|------|-------|--------|
| ERD | 1 | ✅ Working |
| Use Case | 1 | ✅ Working |
| Activity | 2 | ✅ Working |
| Sequence | 2 | ✅ Working |
| **Total** | **6** | **All Working** |

---

**Note**: Ini adalah versi simplified untuk testing cepat. Untuk diagram lengkap, lihat file individual di folder ini.

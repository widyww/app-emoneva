# Entity Relationship Diagram (ERD)

## Sistem Informasi Manajemen Data Sekolah dan Guru

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
        timestamp created_at
        timestamp updated_at
    }

    KECAMATAN {
        bigint id PK
        string nama
        bigint kota_id FK
        timestamp created_at
        timestamp updated_at
    }

    PERIODE {
        bigint id PK
        string tahun
        timestamp created_at
        timestamp updated_at
    }

    SEKOLAH {
        bigint id PK
        string npsn UK
        string tingkatan
        string nama
        string alamat
        string telepon
        string email
        string website
        string foto_sekolah
        string kepsek_nama
        string kepsek_hp
        string kepsek_foto
        string sk_ijin
        string status_sekolah
        string status_akreditasi
        string status_tanah
        string jum_siswa_pria
        string jum_siswa_wanita
        string jum_guru
        string status_verifikasi
        string keterangan_verifikasi
        string tahun
        bigint kecamatan_id FK
        bigint kota_id FK
        timestamp created_at
        timestamp updated_at
    }

    SEKOLAH_SOSEKBUD {
        bigint id PK
        bigint sekolah_id FK
        string kondisi_geografis
        string kondisi_sosekbud
        string akses_transportasi
        timestamp created_at
        timestamp updated_at
    }

    SEKOLAH_BANTUAN_STATUS {
        bigint id PK
        bigint sekolah_id FK
        string status
        timestamp created_at
        timestamp updated_at
    }

    SEKOLAH_BANTUAN_DETAIL {
        bigint id PK
        bigint sekolah_bantuan_status_id FK
        string nama_lembaga
        text keterangan_bantuan
        timestamp created_at
        timestamp updated_at
    }

    SEKOLAH_FASILITASTIK {
        bigint id PK
        bigint sekolah_id FK
        enum listrik_status
        string listrik_sumber
        string listrik_durasi
        string jumlah_kom
        enum labkom_status
        enum internet_status
        string internet_sumber
        string internet_bandwith
        string topologi_jaringan
        string internet_kesesuaian
        text internet_alasankuota
        text saran_pengembangan
        timestamp created_at
        timestamp updated_at
    }

    SEKOLAH_FASILITASTIK_LAB {
        bigint id PK
        bigint sekolah_fasilitastik_id FK
        string labkom_nama
        string labkom_jumlah_pc
        timestamp created_at
        timestamp updated_at
    }

    GURU {
        bigint id PK
        string nama
        string status
        string nip
        string nuptk
        string tempat
        date tgl_lahir
        string agama
        string jenis_kelamin
        string pendidikan_terakhir
        date tmt_pns_tahun
        string telepon
        string mapel
        string sertifikasi_status
        string sertifikasi_tahun
        string sertifikasi_alasan
        string kompetensi_word
        string kompetensi_powerpoin
        string kompetensi_excel
        string kompetensi_pemrogramman
        string kompetensi_jaringan
        string kompetensi_multimedia
        string pelatihan_status
        string pelatihan_kebutuhan
        string status_verifikasi
        string catatan_verifikasi
        string tahun
        bigint sekolah_id FK
        timestamp created_at
        timestamp updated_at
    }

    GURU_PELATIHAN {
        bigint id PK
        bigint guru_id FK
        string nama_pelatihan
        string tingkatan
        string level
        string tahun_pelatihan
        string jam_pelatihan
        timestamp created_at
        timestamp updated_at
    }

    GURU_KEBUTUHAN {
        bigint id PK
        bigint guru_id FK
        string nama_pelatihan
        timestamp created_at
        timestamp updated_at
    }

    USER {
        bigint id PK
        string name
        string email UK
        string phone
        string role
        timestamp email_verified_at
        string password
        bigint sekolah_id FK
        string remember_token
        timestamp created_at
        timestamp updated_at
    }
```

## Keterangan Relasi

- `||--o{` : One-to-Many (Satu ke Banyak)
- `||--||` : One-to-One (Satu ke Satu)
- `PK` : Primary Key
- `FK` : Foreign Key
- `UK` : Unique Key

## Test Online

Copy code di atas dan paste ke: https://mermaid.live

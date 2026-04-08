# Sequence Diagram - Filter dan Monitoring (Kabalai)

## Alur Filtering dan Export Data

```mermaid
sequenceDiagram
    actor Kabalai
    participant Browser
    participant FilterController
    participant Database
    participant ChartService

    Kabalai->>Browser: Akses halaman filter
    Browser->>FilterController: GET /sort-akreditasi
    FilterController-->>Browser: Tampilkan halaman filter
    
    Kabalai->>Browser: Pilih kriteria filter
    Browser->>FilterController: GET /api/akreditasi-data?filter=A
    FilterController->>Database: SELECT COUNT(*) GROUP BY status_akreditasi
    Database-->>FilterController: Return aggregated data
    
    FilterController->>ChartService: Format data untuk chart
    ChartService-->>FilterController: Return chart data (JSON)
    FilterController-->>Browser: Return JSON response
    
    Browser->>Browser: Render chart dengan JavaScript
    Browser-->>Kabalai: Tampilkan visualisasi data
    
    Kabalai->>Browser: Klik detail kategori
    Browser->>FilterController: GET /api/sekolah-detail?akreditasi=A
    FilterController->>Database: SELECT sekolah WHERE status_akreditasi=A
    Database-->>FilterController: Return list sekolah
    FilterController-->>Browser: Return JSON data
    Browser-->>Kabalai: Tampilkan tabel detail
    
    opt Export Laporan
        Kabalai->>Browser: Klik tombol export
        Browser->>FilterController: GET /export/akreditasi?format=excel
        FilterController->>Database: SELECT data untuk export
        Database-->>FilterController: Return data
        FilterController->>FilterController: Generate Excel file
        FilterController-->>Browser: Download file Excel
        Browser-->>Kabalai: File terdownload
    end
```

## Penjelasan Alur

1. **Load Filter Page**: Kabalai membuka halaman filter
2. **Select Criteria**: Memilih kriteria filter (contoh: Akreditasi A)
3. **Fetch Aggregated Data**: System query data agregat dari database
4. **Format for Chart**: Data diformat untuk visualisasi chart
5. **Render Chart**: Browser render chart menggunakan JavaScript
6. **View Details**: Klik kategori untuk melihat detail data
7. **Export (Optional)**: Export data ke Excel/PDF

## API Endpoints untuk Monitoring

### Filter Sekolah
| Endpoint | Deskripsi |
|----------|-----------|
| GET /sort-akreditasi | Filter berdasarkan akreditasi |
| GET /api/akreditasi-data | Data chart akreditasi |
| GET /status-bantuan | Filter status bantuan |
| GET /sort/internet | Filter ketersediaan internet |
| GET /sort/listrik | Filter ketersediaan listrik |
| GET /status-labkomputer | Filter lab komputer |

### Filter Guru
| Endpoint | Deskripsi |
|----------|-----------|
| GET /sort-gurustatus | Filter status guru (PNS/PPPK) |
| GET /sort-gurupendidikan | Filter pendidikan guru |
| GET /sort-gurusertifikasi | Filter sertifikasi guru |
| GET /sort-gurupelatihan | Filter kebutuhan pelatihan |

## Response Format (JSON)

### Chart Data
```json
{
  "labels": ["A", "B", "C", "Belum Terakreditasi"],
  "data": [45, 32, 18, 5],
  "total": 100
}
```

### Detail Data
```json
{
  "data": [
    {
      "id": 1,
      "npsn": "12345678",
      "nama": "SMA Negeri 1",
      "status_akreditasi": "A",
      "kota": "Jakarta",
      "kecamatan": "Menteng"
    }
  ],
  "total": 45
}
```

## Visualisasi yang Tersedia

- Bar Chart (untuk perbandingan kategori)
- Pie Chart (untuk distribusi persentase)
- Line Chart (untuk trend data)
- Table (untuk detail data)

## Test Online

Copy code di atas dan paste ke: https://mermaid.live

# Activity Diagram - Proses Verifikasi Data

## Alur Verifikasi oleh Verifikator

```mermaid
flowchart TD
    Start([Mulai]) --> LoginVerif[Login sebagai Verifikator]
    LoginVerif --> DashboardVerif[Dashboard Verifikator]
    
    DashboardVerif --> LihatDaftar[Lihat Daftar<br/>Pengajuan Verifikasi]
    LihatDaftar --> PilihSekolah[Pilih Sekolah<br/>untuk Diverifikasi]
    
    PilihSekolah --> LihatDetail[Lihat Detail Data:<br/>- Identitas Sekolah<br/>- Sosekbud<br/>- Bantuan<br/>- Fasilitas<br/>- Data Guru]
    
    LihatDetail --> PeriksaData{Data<br/>Valid?}
    
    PeriksaData -->|Tidak Valid| InputCatatan[Input Catatan<br/>Perbaikan]
    InputCatatan --> Reject[Status = rejected<br/>Simpan Catatan]
    Reject --> NotifOperatorReject[Notifikasi Operator<br/>untuk Perbaikan]
    NotifOperatorReject --> End([Selesai])
    
    PeriksaData -->|Valid| Approve[Status = approved]
    Approve --> UpdateVerifikasi[Update:<br/>status_verifikasi<br/>keterangan_verifikasi]
    UpdateVerifikasi --> NotifOperatorApprove[Notifikasi Operator<br/>Data Disetujui]
    NotifOperatorApprove --> CheckMore{Ada Data<br/>Lain?}
    
    CheckMore -->|Ya| LihatDaftar
    CheckMore -->|Tidak| End
```

## Penjelasan Alur

1. **Login Verifikator**: Verifikator masuk ke sistem
2. **Lihat Daftar**: Melihat sekolah yang mengajukan verifikasi (status = pending)
3. **Review Data**: Memeriksa kelengkapan dan kebenaran data
4. **Keputusan**:
   - **Approved**: Data valid, status diubah menjadi approved
   - **Rejected**: Data tidak valid, dikembalikan dengan catatan perbaikan
5. **Notifikasi**: Operator mendapat notifikasi hasil verifikasi

## Status Verifikasi

- `pending`: Menunggu verifikasi
- `approved`: Data disetujui
- `rejected`: Data ditolak, perlu perbaikan

## Test Online

Copy code di atas dan paste ke: https://mermaid.live

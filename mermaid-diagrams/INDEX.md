# 📊 Index Diagram Mermaid

## Quick Navigation

Klik link di bawah untuk membuka diagram:

### 🗄️ Database Design
- [**ERD - Entity Relationship Diagram**](./ERD.md) - Struktur database lengkap dengan 15 tabel

### 👥 Use Case
- [**Use Case Diagram**](./UseCase-Diagram.md) - 4 aktor, 15 use case

### 🔄 Activity Diagrams
- [**Activity: Input Data Sekolah**](./Activity-Diagram-Input-Data.md) - Alur input data oleh operator
- [**Activity: Verifikasi Data**](./Activity-Diagram-Verifikasi.md) - Alur approve/reject oleh verifikator
- [**Activity: Monitoring Data**](./Activity-Diagram-Monitoring.md) - Alur filtering oleh Kabalai

### 📨 Sequence Diagrams
- [**Sequence: Login & Autentikasi**](./Sequence-Diagram-Login.md) - Role-based authentication
- [**Sequence: Input Data Guru**](./Sequence-Diagram-Input-Guru.md) - Input dengan relasi multiple
- [**Sequence: Verifikasi Sekolah**](./Sequence-Diagram-Verifikasi.md) - Workflow verifikasi
- [**Sequence: Filter & Monitoring**](./Sequence-Diagram-Monitoring.md) - API filtering & export

---

## 🎨 Preview di IDE

Dengan extension Mermaid yang sudah terinstall:

### VS Code
1. Buka file diagram (`.md`)
2. Tekan `Ctrl+Shift+V` (Windows) atau `Cmd+Shift+V` (Mac)
3. Atau klik icon preview di kanan atas

### Shortcut Keyboard
- `Ctrl+K V` - Open preview to the side
- `Ctrl+Shift+V` - Open preview

---

## 🧪 Testing Checklist

Gunakan checklist ini untuk memastikan semua diagram berfungsi:

- [ ] ERD - Entity Relationship Diagram
- [ ] Use Case Diagram
- [ ] Activity Diagram - Input Data
- [ ] Activity Diagram - Verifikasi
- [ ] Activity Diagram - Monitoring
- [ ] Sequence Diagram - Login
- [ ] Sequence Diagram - Input Guru
- [ ] Sequence Diagram - Verifikasi
- [ ] Sequence Diagram - Monitoring

---

## 📝 Quick Reference

### Diagram Types

| Type | File Count | Purpose |
|------|------------|---------|
| ERD | 1 | Database structure |
| Use Case | 1 | System functionality |
| Activity | 3 | Business process flow |
| Sequence | 4 | Interaction between components |
| **Total** | **9** | Complete system documentation |

### Actors in System

1. **Administrator** (Role 1)
   - Kelola master data
   - Kelola sekolah
   - Kelola user
   - Import data Excel

2. **Operator Sekolah** (Role 3)
   - Input data sekolah
   - Input data guru
   - Ajukan verifikasi

3. **Verifikator** (Role 2)
   - Verifikasi data sekolah
   - Verifikasi data guru
   - Approve/Reject

4. **Kepala Balai** (Role 4)
   - Monitoring statistik
   - Filter multi-kriteria
   - Export laporan

---

## 🔗 External Links

- [Mermaid Live Editor](https://mermaid.live) - Test online
- [Mermaid Documentation](https://mermaid.js.org/) - Official docs
- [Mermaid Cheat Sheet](https://jojozhuang.github.io/tutorial/mermaid-cheat-sheet/) - Quick reference

---

## 💡 Tips

1. **Preview Side-by-Side**: Buka file `.md` dan preview secara bersamaan
2. **Zoom In/Out**: Gunakan `Ctrl +` / `Ctrl -` di preview
3. **Export**: Right-click pada preview → Export to PNG/SVG
4. **Edit Real-time**: Edit code, preview auto-update
5. **Dark Mode**: Preview mengikuti theme IDE

---

## 🚀 Next Steps

1. ✅ Preview semua diagram di IDE
2. ✅ Pastikan semua diagram render dengan benar
3. ✅ Export diagram yang diperlukan ke PNG untuk presentasi
4. ✅ Gunakan diagram dalam dokumentasi proyek
5. ✅ Update diagram sesuai perubahan sistem

---

**Last Updated**: 2026-02-15

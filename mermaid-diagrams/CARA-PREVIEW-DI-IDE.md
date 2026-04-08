# 🎨 Cara Preview Diagram Mermaid di IDE

## ✅ Extension yang Diperlukan

### VS Code
Install salah satu extension berikut:

1. **Markdown Preview Mermaid Support** (Recommended)
   - ID: `bierner.markdown-mermaid`
   - Auto-render Mermaid di Markdown preview

2. **Mermaid Markdown Syntax Highlighting**
   - ID: `bpruitt-goddard.mermaid-markdown-syntax-highlighting`
   - Syntax highlighting untuk code Mermaid

3. **Mermaid Editor** (Optional)
   - ID: `tomoyukim.vscode-mermaid-editor`
   - Editor khusus untuk Mermaid

---

## 🚀 Cara Preview

### Method 1: Markdown Preview (Paling Mudah)

1. **Buka file diagram** (contoh: `ERD.md`)
2. **Tekan shortcut**:
   - Windows/Linux: `Ctrl + Shift + V`
   - Mac: `Cmd + Shift + V`
3. **Preview muncul** di tab baru

### Method 2: Preview Side-by-Side

1. **Buka file diagram**
2. **Tekan shortcut**:
   - Windows/Linux: `Ctrl + K` lalu `V`
   - Mac: `Cmd + K` lalu `V`
3. **Preview muncul** di samping editor

### Method 3: Klik Icon

1. **Buka file diagram**
2. **Klik icon** 📖 di kanan atas editor
3. **Pilih** "Open Preview" atau "Open Preview to the Side"

---

## 🎯 Quick Test

### Test 1: Buka File Test
```bash
# Buka file ini di IDE:
mermaid-diagrams/PREVIEW-TEST.md
```

Tekan `Ctrl+Shift+V` dan lihat apakah semua diagram muncul.

### Test 2: Buka ERD
```bash
# Buka file ini:
mermaid-diagrams/ERD.md
```

Preview side-by-side dengan `Ctrl+K V`.

### Test 3: Edit Real-time
1. Buka `PREVIEW-TEST.md`
2. Preview side-by-side
3. Edit text di diagram
4. Lihat preview auto-update

---

## 🔧 Troubleshooting

### ❌ Diagram Tidak Muncul

**Solusi 1**: Install Extension
```
1. Tekan Ctrl+Shift+X
2. Search "Markdown Preview Mermaid Support"
3. Install extension
4. Reload VS Code
```

**Solusi 2**: Reload Window
```
1. Tekan Ctrl+Shift+P
2. Ketik "Reload Window"
3. Enter
```

**Solusi 3**: Update Extension
```
1. Buka Extensions (Ctrl+Shift+X)
2. Cari extension Mermaid
3. Klik "Update" jika ada
```

### ❌ Preview Tidak Auto-Update

**Solusi**: Enable Auto Refresh
```json
// settings.json
{
  "markdown.preview.scrollPreviewWithEditor": true,
  "markdown.preview.scrollEditorWithPreview": true
}
```

### ❌ Syntax Error di Diagram

**Solusi**: Test di Mermaid Live
1. Copy code diagram
2. Buka https://mermaid.live
3. Paste dan lihat error message
4. Fix syntax error
5. Copy kembali ke file

---

## ⚙️ Settings Recommended

Tambahkan ke `settings.json` (Ctrl+,):

```json
{
  // Mermaid Settings
  "markdown.preview.breaks": true,
  "markdown.preview.fontSize": 14,
  "markdown.preview.lineHeight": 1.6,
  
  // Auto Save
  "files.autoSave": "afterDelay",
  "files.autoSaveDelay": 1000,
  
  // Preview Settings
  "markdown.preview.scrollPreviewWithEditor": true,
  "markdown.preview.scrollEditorWithPreview": true
}
```

---

## 🎨 Customization

### Zoom In/Out Preview
- **Zoom In**: `Ctrl + +` (atau `Ctrl + Scroll Up`)
- **Zoom Out**: `Ctrl + -` (atau `Ctrl + Scroll Down`)
- **Reset Zoom**: `Ctrl + 0`

### Dark Mode
Preview mengikuti theme VS Code:
- File → Preferences → Color Theme
- Pilih Dark/Light theme

### Font Size
```json
{
  "markdown.preview.fontSize": 16  // Ubah sesuai keinginan
}
```

---

## 📤 Export Diagram

### Method 1: Screenshot
1. Preview diagram
2. Tekan `Windows + Shift + S` (Windows)
3. Atau `Cmd + Shift + 4` (Mac)
4. Select area diagram
5. Save

### Method 2: Copy dari Mermaid Live
1. Copy code diagram
2. Buka https://mermaid.live
3. Paste code
4. Klik "Actions" → "PNG" atau "SVG"
5. Download

### Method 3: Extension Export (Jika ada)
Beberapa extension punya fitur export:
1. Right-click di preview
2. Pilih "Export to PNG/SVG"
3. Save file

---

## 🎓 Tips & Tricks

### 1. Multi-File Preview
Buka beberapa file sekaligus:
```
1. Split editor (Ctrl+\)
2. Buka file 1 di kiri
3. Buka file 2 di kanan
4. Preview masing-masing
```

### 2. Quick Navigation
```
Ctrl+P → Ketik nama file → Enter
```

### 3. Search in Files
```
Ctrl+Shift+F → Search "mermaid" → Enter
```

### 4. Fold/Unfold Code
```
Ctrl+Shift+[ → Fold
Ctrl+Shift+] → Unfold
```

### 5. Format Document
```
Shift+Alt+F → Auto format
```

---

## 📋 Keyboard Shortcuts Cheat Sheet

| Action | Windows/Linux | Mac |
|--------|---------------|-----|
| Preview | `Ctrl+Shift+V` | `Cmd+Shift+V` |
| Preview Side | `Ctrl+K V` | `Cmd+K V` |
| Command Palette | `Ctrl+Shift+P` | `Cmd+Shift+P` |
| Quick Open | `Ctrl+P` | `Cmd+P` |
| Split Editor | `Ctrl+\` | `Cmd+\` |
| Zoom In | `Ctrl++` | `Cmd++` |
| Zoom Out | `Ctrl+-` | `Cmd+-` |
| Toggle Sidebar | `Ctrl+B` | `Cmd+B` |
| Find | `Ctrl+F` | `Cmd+F` |
| Replace | `Ctrl+H` | `Cmd+H` |

---

## 🎬 Video Tutorial (Simulasi)

### Step-by-Step:

**1. Install Extension**
```
Extensions (Ctrl+Shift+X)
→ Search "Markdown Preview Mermaid"
→ Install
→ Reload
```

**2. Open Diagram**
```
Explorer (Ctrl+Shift+E)
→ Navigate to mermaid-diagrams/
→ Click ERD.md
```

**3. Preview**
```
Press Ctrl+Shift+V
→ Diagram appears!
```

**4. Edit & See Changes**
```
Edit text in diagram
→ Preview auto-updates
→ Save (Ctrl+S)
```

---

## ✅ Checklist Setup

Gunakan checklist ini untuk memastikan setup benar:

- [ ] Extension Mermaid sudah terinstall
- [ ] Bisa preview dengan `Ctrl+Shift+V`
- [ ] Bisa preview side-by-side dengan `Ctrl+K V`
- [ ] Preview auto-update saat edit
- [ ] Semua diagram di `PREVIEW-TEST.md` terlihat
- [ ] Bisa zoom in/out di preview
- [ ] Bisa export diagram (screenshot/mermaid.live)

---

## 🆘 Need Help?

### Resources:
- **Mermaid Docs**: https://mermaid.js.org/
- **VS Code Docs**: https://code.visualstudio.com/docs
- **Mermaid Live**: https://mermaid.live

### Common Issues:
1. **Diagram tidak render** → Install extension
2. **Syntax error** → Test di mermaid.live
3. **Preview tidak update** → Reload window
4. **Extension tidak ada** → Update VS Code

---

## 🎉 Selamat!

Anda sekarang bisa:
- ✅ Preview diagram Mermaid di IDE
- ✅ Edit diagram real-time
- ✅ Export diagram ke gambar
- ✅ Navigasi antar diagram dengan mudah

**Next**: Buka `INDEX.md` untuk navigasi ke semua diagram!

---

**Last Updated**: 2026-02-15

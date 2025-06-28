# 📷 Setup Gambar Background MYKOST

## 📁 Lokasi File Gambar

**Letakkan gambar background kost Anda di:**
```
public/images/kost-background.jpg
```

### Alternatif Format yang Didukung:
- `public/images/kost-background.jpg` (JPG/JPEG)
- `public/images/kost-background.png` (PNG)
- `public/images/kost-background.webp` (WebP untuk kualitas terbaik)

## 📝 Instruksi Setup:

1. **Buat folder images** (jika belum ada):
   ```
   public/
   └── images/
       └── kost-background.jpg  <- Letakkan gambar Anda di sini
   ```

2. **Nama file harus persis:** `kost-background.jpg`

3. **Rekomendasi gambar:**
   - Resolusi minimal: 1920x1080px
   - Format: JPG atau PNG
   - Ukuran file: Maksimal 2MB untuk performa optimal
   - Gambar kost yang menampilkan suasana nyaman dan modern

## 🎨 Implementasi Kode

Kode sudah diupdate di file berikut:

### ✅ `resources/views/layouts/guest.blade.php`
```css
.auth-bg-image {
    background-image: url('{{ asset('images/kost-background.jpg') }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
}
```

### 📱 Halaman yang Menggunakan Background Image:
- ✅ Login (`/login`)
- ✅ Register (`/register`) 
- ✅ Forgot Password (`/forgot-password`)
- ✅ Reset Password (`/password/reset`)
- ✅ Confirm Password (`/confirm-password`)
- ✅ Verify Email (`/email/verify`)

## 🔧 Testing

Setelah menempatkan gambar:

1. Refresh browser di `http://127.0.0.1:8000/login`
2. Gambar background kost akan muncul di panel kanan (desktop) atau atas (mobile)
3. Overlay gradient biru transparan akan memberikan efek yang cantik

## 🚨 Troubleshooting

Jika gambar tidak muncul:
1. Pastikan nama file persis: `kost-background.jpg`
2. Pastikan lokasi: `public/images/kost-background.jpg`
3. Clear browser cache
4. Refresh halaman

## 📐 Fitur Responsif

- **Desktop**: Background image di panel kanan
- **Mobile**: Background image tersembunyi untuk optimasi ruang
- **Tablet**: Menyesuaikan dengan layout responsif

---

✨ **Setelah setup, semua halaman authentication akan menampilkan gambar kost Anda sebagai background yang cantik!** 
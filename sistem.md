# MYKOST - Sistem Manajemen Kost Terpadu

## Overview
MYKOST adalah aplikasi berbasis web menggunakan framework Laravel yang berfungsi sebagai sistem manajemen kost terpadu. Aplikasi ini dirancang untuk membantu pemilik kost mengelola properti dan mempermudah penyewa dalam mencari serta memesan kamar kost.

## Status Development ✅
- ✅ **Phase 1**: Core Setup & Database - COMPLETED
- ✅ **Phase 2**: Authentication & Middleware - COMPLETED  
- 🚧 **Phase 3**: User Interface Foundation - IN PROGRESS
- 📋 **Phase 4+**: Remaining phases pending

**Current Completion:** **Step 8 - Route Structure Setup** ✅ 
**Next:** Step 9 - Layout & Design System (UI Foundation)

## Masalah yang Diselesaikan
- Pemilik kost kesulitan memantau pemesanan kamar, mengelola data penyewa, dan mencatat pemasukan secara efisien
- Penyewa mengalami kebingungan dalam memilih kamar sesuai kebutuhan atau menyampaikan keluhan kepada pengelola
- Sistem manual yang tidak terintegrasi dan rentan error

---

## Database Structure (Final Implementation)

### **Core Tables & Relationships**

**1. Users Table**
```sql
- id (BIGINT UNSIGNED PRIMARY KEY)
- nama (VARCHAR 255) -- Full name
- email (VARCHAR 255 UNIQUE)
- email_verified_at (TIMESTAMP NULLABLE)
- password (VARCHAR 255)
- remember_token (VARCHAR 100 NULLABLE)
- no_hp (VARCHAR 20 NULLABLE) -- Indonesian phone number
- role (ENUM: 'Admin','User') DEFAULT 'User'
- created_at, updated_at (TIMESTAMP)
```

**2. Tipe Kamar Table**
```sql
- id_tipe_kamar (INT PRIMARY KEY AUTO_INCREMENT)
- tipe_kamar (ENUM: 'Standar','Elite','Exclusive')
- fasilitas (TEXT) -- Detailed facilities description
- created_at, updated_at (TIMESTAMP)
```

**3. Paket Kamar Table**
```sql
- id_paket_kamar (INT PRIMARY KEY AUTO_INCREMENT)
- id_tipe_kamar (INT, FOREIGN KEY)
- jenis_paket (ENUM: 'Mingguan','Bulanan','Tahunan')
- kapasitas_kamar (ENUM: '1','2') -- Physical room capacity
- jumlah_penghuni (ENUM: '1','2') -- Number of occupants
- harga (DECIMAL 12,2) -- Price in IDR
- created_at, updated_at (TIMESTAMP)
```

**4. Kamar Table**
```sql
- id_kamar (INT PRIMARY KEY AUTO_INCREMENT)
- id_tipe_kamar (INT, FOREIGN KEY)
- status (ENUM: 'Kosong','Dipesan','Terisi') DEFAULT 'Kosong'
- no_kamar (VARCHAR 50 UNIQUE) -- Room number
- foto_kamar1, foto_kamar2, foto_kamar3 (LONGBLOB) -- Base64 images
- deskripsi (TEXT) -- Room description
- created_at, updated_at (TIMESTAMP)
```

**5. Penghuni Table**
```sql
- id_penghuni (INT PRIMARY KEY AUTO_INCREMENT)
- id_user (BIGINT UNSIGNED, FOREIGN KEY)
- status_penghuni (ENUM: 'Aktif','Non-aktif') DEFAULT 'Aktif'
- created_at, updated_at (TIMESTAMP)
```

**6. Booking Table**
```sql
- id_booking (INT PRIMARY KEY AUTO_INCREMENT)
- id_penghuni (INT, FOREIGN KEY) -- Primary tenant
- id_teman (INT, FOREIGN KEY, NULLABLE) -- Secondary tenant
- id_kamar (INT, FOREIGN KEY)
- id_paket_kamar (INT, FOREIGN KEY)
- tanggal_mulai (DATETIME)
- tanggal_selesai (DATETIME)
- total_durasi (VARCHAR 255, NULLABLE) -- Duration description
- status_booking (ENUM: 'Aktif','Selesai','Dibatalkan') DEFAULT 'Aktif'
- created_at, updated_at (TIMESTAMP)
```

**7. Pembayaran Table**
```sql
- id_pembayaran (INT PRIMARY KEY AUTO_INCREMENT)
- id_user (BIGINT UNSIGNED, FOREIGN KEY)
- id_booking (INT, FOREIGN KEY)
- id_kamar (INT, FOREIGN KEY)
- tanggal_pembayaran (DATETIME)
- status_pembayaran (ENUM: 'Belum bayar','Gagal','Lunas') DEFAULT 'Belum bayar'
- jumlah_pembayaran (DECIMAL 12,2)
- payment_type (ENUM: 'Booking','Extension','Additional') DEFAULT 'Booking'
- midtrans_order_id (VARCHAR 255, NULLABLE) -- Midtrans order ID
- midtrans_transaction_id (VARCHAR 255, NULLABLE) -- Midtrans transaction ID
- created_at, updated_at (TIMESTAMP)
```

**8. Pengaduan Table**
```sql
- id_pengaduan (INT PRIMARY KEY AUTO_INCREMENT)
- id_penghuni (INT, FOREIGN KEY)
- id_kamar (INT, FOREIGN KEY)
- judul_pengaduan (VARCHAR 255)
- isi_pengaduan (TEXT)
- status (ENUM: 'Menunggu','Diproses','Selesai') DEFAULT 'Menunggu'
- foto_pengaduan (LONGBLOB, NULLABLE) -- Base64 image
- tanggal_pengaduan (DATETIME)
- response_admin (TEXT, NULLABLE)
- tanggal_response (DATETIME, NULLABLE)
- created_at, updated_at (TIMESTAMP)
```

**9. Advance Booking Table**
```sql
- id_advance (INT PRIMARY KEY AUTO_INCREMENT)
- id_kamar (INT, FOREIGN KEY)
- id_user (BIGINT UNSIGNED, FOREIGN KEY)
- tanggal_mulai (DATETIME)
- tanggal_selesai (DATETIME)
- status (ENUM: 'Active','Cancelled','Completed') DEFAULT 'Active'
- created_at, updated_at (TIMESTAMP)
```

### **Sample Data Overview**
- **10 Users**: 1 Admin (Pak Gilberth) + 9 regular users
- **3 Room Types**: Standar, Elite, Exclusive with detailed facilities
- **27 Package Combinations**: All combinations of types, durations, and occupancy
- **12 Rooms**: Mixed types and statuses for testing
- **6 Tenants**: Active and inactive statuses
- **6 Bookings**: Various statuses including multi-tenant scenarios
- **7 Payments**: Different payment statuses and Midtrans integration ready
- **5 Advance Bookings**: Future reservations with different statuses

---

## Entitas Sistem

### 1. Admin (Pemilik Kost)
- Memiliki akses penuh ke seluruh sistem
- Dapat mengelola semua data kamar, penghuni, dan transaksi
- Role: `Admin`
- Akses route: `/admin/*`
- **Middleware**: `['auth', 'verified', 'admin']` ✅

### 2. User (Pengguna Terdaftar)
- Pengguna yang sudah melakukan sign up
- Dapat melihat informasi kamar, fasilitas, dan melakukan booking
- Role: `User`
- Akses route: `/user/*`
- **Middleware**: `['auth', 'verified', 'user']` ✅

### 3. Penghuni
- User yang statusnya berubah setelah berhasil melakukan booking dan pembayaran
- Dapat melakukan perpanjangan booking, pengaduan, dan mengakses history
- Role: masih `User` tapi dengan status penghuni aktif (via `hasActivePenghuni()` method)
- Akses route: `/user/*` + `/penghuni/*`
- **Middleware**: `['auth', 'verified', 'penghuni']` ✅

---

## Fitur Utama

### 1. Pemesanan Kamar Kost
- Pengguna dapat memilih kamar berdasarkan 3 tipe: **Standar**, **Elite**, **Exclusive**
- Setiap tipe memiliki deskripsi fasilitas yang berbeda
- Booking dapat dilakukan untuk hari yang sama jika kamar available

### 2. Pilihan Paket Sewa
- **Durasi**: Mingguan, Bulanan, Tahunan
- **Kapasitas**: 1 atau 2 orang
- **Pricing Structure**: 
  - Kamar kapasitas 1: hanya untuk 1 orang
  - Kamar kapasitas 2: bisa untuk 1 orang atau 2 orang (harga berbeda)

### 3. Sistem Pengaduan
- Penghuni dapat mengirimkan pengaduan dengan foto (LONGBLOB base64)
- Admin dapat memberikan response satu kali (no follow-up)
- Status: Menunggu, Diproses, Selesai
- Penghuni dapat melihat status dan response pengaduan

### 4. Manajemen Kamar (CRUD)
- Admin dapat menambah, edit, hapus, dan melihat kamar
- Status kamar: Kosong, Dipesan, Terisi
- Setiap kamar dapat memiliki 3 foto (disimpan dalam database MySQL sebagai **LONGBLOB dengan base64 encoding**, max 2MB per foto)

### 5. Pengelolaan Pemasukan Otomatis
- Sistem mencatat semua transaksi pembayaran dengan integrasi Midtrans
- Laporan dapat di-export dalam format PDF
- Filter laporan: mingguan, bulanan, tahunan
- Support untuk payment types: Booking, Extension, Additional

---

## Sistem Booking

### Advance Booking Rules
- **Kamar Available**: Maximum advance booking 3 bulan ke depan
- **Kamar Non-Available**: TIDAK bisa advance booking
- **Minimum**: 1 hari (H-1)
- **Warning System**: Jika kamar sudah ada advance booking, user baru akan diberikan warning batas waktu booking

### Booking Process
1. User memilih kamar dan paket
2. User melakukan pembayaran langsung (via Midtrans QR Code)
3. Setelah pembayaran berhasil, status user berubah menjadi penghuni
4. Jika tidak bayar dalam waktu tertentu, booking otomatis dibatalkan

### Multi-Tenant Booking (2 Orang dalam 1 Kamar)

#### Scenario A: Pre-booking Join
1. User pertama mengisi form booking
2. User pertama input ID user kedua di form yang sama
3. User pertama bayar full amount untuk 2 orang
4. Kedua user langsung menjadi penghuni

#### Scenario B: Post-booking Add
1. User pertama sudah menjadi penghuni (kamar kapasitas 2, ditempati 1 orang)
2. User pertama dapat menambah user kedua melalui fitur "Add Penghuni"
3. User pertama memilih paket baru (dari "1 orang" ke "2 orang")
4. Sistem menghitung biaya tambahan: (sisa bulan) × (selisih harga per bulan)
5. User pertama bayar tambahan
6. User kedua otomatis menjadi penghuni
7. Kedua user memiliki akses ke history dan pengaduan yang sama

**Contoh Perhitungan:**
- User 1 booking paket 1 tahun sendiri: 12 juta (sudah dibayar)
- Di bulan ke-2 mau add User 2
- Sisa: 10 bulan
- Selisih harga: 1.5 juta - 1 juta = 500rb per bulan
- Tagihan tambahan: 10 × 500rb = 5 juta

---

## Sistem Perpanjangan

### Process
1. Sistem mengirim email reminder H-3 sebelum masa sewa habis
2. Email dikirim ke semua penghuni kamar
3. Salah satu penghuni dapat melakukan perpanjangan
4. Yang melakukan perpanjangan yang melakukan pembayaran
5. Jika tidak diperpanjang, status penghuni otomatis berubah menjadi user
6. Kamar otomatis berubah status menjadi "Kosong"

### Perpanjangan untuk Multi-Tenant
- Siapa saja dari kedua penghuni dapat melakukan perpanjangan
- Yang menekan tombol perpanjangan yang bertanggung jawab untuk pembayaran
- Email konfirmasi dikirim ke kedua penghuni

---

## Manajemen Penghuni

### Keluar dari Kamar (Multi-Tenant)
1. Penghuni kedua dapat memilih "keluar" dari fitur history
2. Sistem menghapus data penghuni kedua dari kamar
3. Tidak ada pengembalian dana
4. Penghuni kedua kembali menjadi status user
5. Penghuni pertama tetap di kamar dengan biaya yang sama

### Membuat Booking Baru
- Setelah masa sewa habis, penghuni otomatis menjadi user
- Mereka dapat membuat booking baru dengan harga yang sesuai paket terbaru
- Ini lebih menguntungkan dibanding sistem add penghuni di tengah masa sewa

---

## Sistem Pembayaran

### Payment Gateway
- **Provider**: Midtrans (test mode)
- **Method**: QR Code scanning only
- **Timing**: Pembayaran langsung saat booking (no grace period)
- **Multi-tenant**: User pertama yang booking membayar penuh
- **Transaction Tracking**: midtrans_order_id dan midtrans_transaction_id

### Payment Tracking
- Semua pembayaran tercatat dalam tabel pembayaran
- Status: Belum bayar, Gagal, Lunas
- Payment Types: Booking, Extension, Additional
- History pembayaran dapat dilihat di fitur history penghuni
- Pembayaran tambahan (add penghuni) digabung dalam satu record dengan total amount yang di-update

---

## Admin Dashboard

### Statistik Box (Real-time dari Database)
- Total Kamar
- Kamar Tersedia
- Kamar Terisi  
- Total Penghuni Aktif
- Pengaduan Pending
- Revenue Bulan Ini

### Fitur Pengaduan untuk Admin
- Melihat semua pengaduan dalam tabel
- Akses detail setiap pengaduan dengan foto (base64 LONGBLOB)
- Memberikan response satu kali
- Export laporan pengaduan ke PDF

### Fitur Transaksi untuk Admin
- Melihat semua transaksi/pembayaran
- Filter berdasarkan periode (minggu, bulan, tahun)
- Export laporan transaksi ke PDF
- Integrasi dengan Midtrans transaction tracking

### Laporan Okupansi
- Laporan okupansi kamar per periode
- Filter: minggu, bulan, tahun
- Export ke PDF

### CRUD Management
1. **Data Kamar**: Create, Read, Update, Delete dengan foto upload (base64 LONGBLOB)
2. **Data Tipe Kamar**: CRUD dengan fasilitas lengkap
3. **Data Paket Kamar**: CRUD dengan pricing structure yang kompleks

### Manajemen Penghuni
- Tabel informasi semua penghuni dengan status aktif/non-aktif
- Filter berdasarkan status, kamar, tanggal masuk
- Export data penghuni ke PDF

---

## Technical Specifications

### Database Features
- **Image Storage**: LONGBLOB fields for base64 encoded images (max 2MB per image)
- **Foreign Key Constraints**: Proper CASCADE and SET NULL relationships
- **Indexing**: Optimized indexes for dates, status fields, and foreign keys
- **Data Types**: Appropriate field types with proper constraints

### Laravel Integration
- **Eloquent Models**: Custom primary keys and relationship definitions
- **Middleware System**: Role-based access control
- **Seeding System**: Comprehensive sample data for testing
- **Migration System**: Properly structured database migrations

### Payment Integration
- **Midtrans Ready**: Order ID and transaction ID tracking
- **Payment States**: Comprehensive payment status management
- **Extension Support**: Built-in support for booking extensions and additional payments

---

## Security & Performance

### Access Control
- Role-based middleware (Admin, User, Penghuni)
- Email verification required
- Session management via Laravel Breeze

### Data Integrity
- Foreign key constraints prevent orphaned records
- Enum fields ensure data consistency
- Proper validation on all user inputs

### Performance Optimization
- Database indexes on frequently queried fields
- Efficient relationship queries via Eloquent
- Base64 image caching strategies (to be implemented)

---

## Development Phases

### ✅ Phase 1: Core Setup (COMPLETED)
1. Laravel installation dengan Breeze ✅
2. Database migration dan seeding ✅
3. Basic authentication dan middleware ✅

### ✅ Phase 2: User Management (COMPLETED)
1. User registration/login ✅
2. Profile management ✅
3. Role-based access control ✅

### 🚧 Phase 3: Room & Booking System (IN PROGRESS)
1. Room browsing dan filtering 📋 PENDING
2. Booking process 📋 PENDING  
3. Midtrans integration 📋 PENDING

### 📋 Phase 4: Penghuni Features (PENDING)
1. History/invoice view
2. Extension system
3. Pengaduan system

### 📋 Phase 5: Admin Features (PENDING)
1. Dashboard statistics
2. CRUD management
3. Reporting dan PDF export

### 📋 Phase 6: Advanced Features (PENDING)
1. Email notifications
2. Advance booking system
3. Multi-tenant management

### 📋 Phase 7: Testing & Deployment (PENDING)
1. Unit testing
2. Feature testing
3. UI/UX refinement

---

*Dokumen ini telah diupdate untuk mencerminkan status development terkini MYKOST. Sistem sudah memiliki foundation yang solid dengan authentication, middleware, dan database schema yang lengkap.* 

**Ready for Next Phase**: Step 8 - Route Structure Setup (Controller Implementation) 
# MYKOST - Detailed Step by Step Development Plan

## **PRE-DEVELOPMENT PREPARATION**

### **IMPORTANT DESIGN WORKFLOW** 🎨
**UI Framework & Design Reference Protocol:**
- **Framework**: Tailwind CSS akan digunakan untuk styling
- **Design Reference**: User sudah memiliki UI prototype untuk setiap fitur
- **Critical Process**: Ketika sampai pada step pembuatan tampilan UI, WAJIB meminta referensi design kepada User terlebih dahulu

**UI Development Steps yang Memerlukan Design Reference:**
- Step 6: Enhanced Authentication System UI (LOGIN/REGISTER) ✅ COMPLETED - Design implemented
- Step 9: Layout & Design System
- Step 10: Component Development  
- Step 11: Admin Dashboard UI
- Step 12: CRUD Management UI
- Step 18: Room Browsing UI
- Step 19: Booking Process UI
- Step 21: History & Invoice UI
- Dan semua step UI lainnya...

**Design-First Approach Protocol:**
> "Sebelum saya implementasikan [nama fitur], bisa tolong berikan referensi design UI prototype untuk fitur ini?"

### **Step 1: Environment Setup** ✅
1. **Laragon Setup** ✅
   - ✅ Laragon already installed at C:\laragon
   - ✅ PHP 8.3.13 verified working (exceeds PHP 8.2+ requirement)
   - ✅ MySQL 8.0.30 verified working
   - ✅ Composer 2.8.9 verified working

2. **Database Preparation** ✅
   - ✅ Created new database schema `koskosan1.sql` with all required tables
   - ✅ Enhanced schema includes Laravel Breeze compatibility, Midtrans integration, advance booking system
   - ✅ Complete with sample data (27 package combinations, 12 rooms, users, bookings, payments, complaints)
   - ✅ Database imported and tested successfully
   - ✅ Database schema fully aligned with Laravel migrations

3. **Development Tools** ✅
   - ✅ VS Code with Laravel extensions (assumed available)
   - ✅ Git repository structure ready for version control
   - ✅ Development environment fully prepared

---

## **PHASE 1: CORE SETUP & DATABASE**

### **Step 2: Laravel Project Installation** ✅
1. **Create New Laravel Project** ✅
   ```bash
   composer create-project laravel/laravel koskosan1
   cd koskosan1
   ```

2. **Install Laravel Breeze** ✅
   ```bash
   composer require laravel/breeze --dev
   php artisan breeze:install blade
   npm install && npm run build
   ```

3. **Environment Configuration** ✅
   - Configure `.env` file for database connection
   - Set up mail configuration for notifications
   - Configure session and cache settings

### **Step 3: Enhanced Database Schema Creation** ✅
1. **Update User Migration** ✅
   - Add `nama` field (VARCHAR 255)
   - Add `no_hp` field (VARCHAR 20)
   - Add `role` enum('Admin','User') DEFAULT 'User'
   - Keep Breeze fields (`email_verified_at`, `remember_token`)

2. **Create Core Migrations** ✅
   ```bash
   php artisan make:migration create_tipe_kamar_table
   php artisan make:migration create_paket_kamar_table
   php artisan make:migration create_kamar_table
   php artisan make:migration create_penghuni_table
   php artisan make:migration create_booking_table
   php artisan make:migration create_pembayaran_table
   php artisan make:migration create_pengaduan_table
   php artisan make:migration create_advance_booking_table
   ```

3. **Define Migration Structures** ✅

   **Table: tipe_kamar**
   ```sql
   - id_tipe_kamar (INT PRIMARY KEY AUTO_INCREMENT)
   - tipe_kamar (ENUM: 'Standar','Elite','Exclusive')
   - fasilitas (TEXT)
   - created_at, updated_at (TIMESTAMP)
   ```

   **Table: paket_kamar**
   ```sql
   - id_paket_kamar (INT PRIMARY KEY AUTO_INCREMENT)
   - id_tipe_kamar (INT, FOREIGN KEY)
   - jenis_paket (ENUM: 'Mingguan','Bulanan','Tahunan')
   - kapasitas_kamar (ENUM: '1','2') -- Physical room capacity
   - jumlah_penghuni (ENUM: '1','2') -- Number of occupants
   - harga (DECIMAL 12,2)
   - created_at, updated_at (TIMESTAMP)
   ```

   **Table: kamar**
   ```sql
   - id_kamar (INT PRIMARY KEY AUTO_INCREMENT)
   - id_tipe_kamar (INT, FOREIGN KEY)
   - status (ENUM: 'Kosong','Dipesan','Terisi') DEFAULT 'Kosong'
   - no_kamar (VARCHAR 50 UNIQUE)
   - foto_kamar1, foto_kamar2, foto_kamar3 (LONGBLOB) -- For base64 images
   - deskripsi (TEXT)
   - created_at, updated_at (TIMESTAMP)
   ```

   **Table: penghuni**
   ```sql
   - id_penghuni (INT PRIMARY KEY AUTO_INCREMENT)
   - id_user (BIGINT UNSIGNED, FOREIGN KEY to users.id)
   - status_penghuni (ENUM: 'Aktif','Non-aktif') DEFAULT 'Aktif'
   - created_at, updated_at (TIMESTAMP)
   ```

   **Table: booking**
   ```sql
   - id_booking (INT PRIMARY KEY AUTO_INCREMENT)
   - id_penghuni (INT, FOREIGN KEY) -- Primary tenant
   - id_teman (INT, FOREIGN KEY, NULLABLE) -- Secondary tenant
   - id_kamar (INT, FOREIGN KEY)
   - id_paket_kamar (INT, FOREIGN KEY)
   - tanggal_mulai (DATETIME)
   - tanggal_selesai (DATETIME)
   - total_durasi (VARCHAR 255, NULLABLE)
   - status_booking (ENUM: 'Aktif','Selesai','Dibatalkan') DEFAULT 'Aktif'
   - created_at, updated_at (TIMESTAMP)
   ```

   **Table: pembayaran**
   ```sql
   - id_pembayaran (INT PRIMARY KEY AUTO_INCREMENT)
   - id_user (BIGINT UNSIGNED, FOREIGN KEY)
   - id_booking (INT, FOREIGN KEY)
   - id_kamar (INT, FOREIGN KEY)
   - tanggal_pembayaran (DATETIME)
   - status_pembayaran (ENUM: 'Belum bayar','Gagal','Lunas') DEFAULT 'Belum bayar'
   - jumlah_pembayaran (DECIMAL 12,2)
   - payment_type (ENUM: 'Booking','Extension','Additional') DEFAULT 'Booking'
   - midtrans_order_id (VARCHAR 255, NULLABLE) -- Midtrans transaction ID
   - midtrans_transaction_id (VARCHAR 255, NULLABLE)
   - created_at, updated_at (TIMESTAMP)
   ```

   **Table: pengaduan**
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

   **Table: advance_booking**
   ```sql
   - id_advance (INT PRIMARY KEY AUTO_INCREMENT)
   - id_kamar (INT, FOREIGN KEY)
   - id_user (BIGINT UNSIGNED, FOREIGN KEY)
   - tanggal_mulai (DATETIME)
   - tanggal_selesai (DATETIME)
   - status (ENUM: 'Active','Cancelled','Completed') DEFAULT 'Active'
   - created_at, updated_at (TIMESTAMP)
   ```

4. **Set Foreign Key Constraints** ✅
   ```sql
   -- tipe_kamar relationships
   paket_kamar.id_tipe_kamar -> tipe_kamar.id_tipe_kamar (CASCADE)
   kamar.id_tipe_kamar -> tipe_kamar.id_tipe_kamar (CASCADE)
   
   -- user relationships
   penghuni.id_user -> users.id (CASCADE)
   pembayaran.id_user -> users.id (CASCADE)
   advance_booking.id_user -> users.id (CASCADE)
   
   -- kamar relationships
   booking.id_kamar -> kamar.id_kamar (CASCADE)
   pembayaran.id_kamar -> kamar.id_kamar (CASCADE)
   pengaduan.id_kamar -> kamar.id_kamar (CASCADE)
   advance_booking.id_kamar -> kamar.id_kamar (CASCADE)
   
   -- penghuni relationships
   booking.id_penghuni -> penghuni.id_penghuni (CASCADE)
   booking.id_teman -> penghuni.id_penghuni (SET NULL)
   pengaduan.id_penghuni -> penghuni.id_penghuni (CASCADE)
   
   -- other relationships
   booking.id_paket_kamar -> paket_kamar.id_paket_kamar (CASCADE)
   pembayaran.id_booking -> booking.id_booking (CASCADE)
   ```

### **Step 4: Model Creation & Relationships** ✅
1. **Create Eloquent Models** ✅
   ```bash
   php artisan make:model TipeKamar
   php artisan make:model PaketKamar
   php artisan make:model Kamar
   php artisan make:model Penghuni
   php artisan make:model Booking
   php artisan make:model Pembayaran
   php artisan make:model Pengaduan
   php artisan make:model AdvanceBooking
   ```

2. **Define Model Relationships** ✅
   - **User**: hasMany(Penghuni), hasMany(Pembayaran), hasMany(AdvanceBooking)
   - **TipeKamar**: hasMany(Kamar), hasMany(PaketKamar)
   - **PaketKamar**: belongsTo(TipeKamar), hasMany(Booking)
   - **Kamar**: belongsTo(TipeKamar), hasMany(Booking), hasMany(Pengaduan), hasMany(AdvanceBooking)
   - **Penghuni**: belongsTo(User), hasMany(Booking), hasMany(Pengaduan)
   - **Booking**: belongsTo(Penghuni), belongsTo(Penghuni as teman), belongsTo(Kamar), belongsTo(PaketKamar), hasMany(Pembayaran)
   - **Pembayaran**: belongsTo(User), belongsTo(Booking), belongsTo(Kamar)
   - **Pengaduan**: belongsTo(Penghuni), belongsTo(Kamar)
   - **AdvanceBooking**: belongsTo(Kamar), belongsTo(User)

3. **Define Model Attributes** ✅
   - Set fillable properties for mass assignment
   - Define casting for enums and dates
   - Add mutators/accessors for special formatting
   - **Primary Key Configuration**: Custom integer primary keys for all models
   - **Base64 Image Handling**: Methods for LONGBLOB foto fields conversion

### **Step 5: Database Seeding** ✅
1. **Create Seeders** ✅
   ```bash
   php artisan make:seeder UserSeeder
   php artisan make:seeder TipeKamarSeeder
   php artisan make:seeder PaketKamarSeeder
   php artisan make:seeder KamarSeeder
   php artisan make:seeder PenghuniSeeder
   ```

2. **Seed Data Structure** ✅
   
   **Users (10 total)**
   - ID 1: Pak Gilberth (Admin)
   - ID 2-10: 9 regular users (John Doe, Jane Smith, Ahmad Rahman, dll.)

   **TipeKamar (3 types)**
   - ID 1: Standar - Fasilitas dasar: tempat tidur, lemari, meja belajar, kamar mandi dalam, AC, WiFi
   - ID 2: Elite - Fasilitas lengkap: queen bed, lemari besar, TV 32", minibar, dll.
   - ID 3: Exclusive - Premium: king bed, walk-in closet, TV 43", bathtub, dapur kecil

   **PaketKamar (27 combinations)**
   - 3 tipe × 3 durasi × 3 occupancy scenarios
   - Pricing: Standar (500k-30jt), Elite (750k-45jt), Exclusive (1.2jt-65jt)

   **Kamar (12 rooms total)**
   - 5 Standar, 4 Elite, 3 Exclusive
   - Mix of statuses: Kosong, Dipesan, Terisi

   **Penghuni (6 total)**
   - 4 Aktif, 2 Non-aktif
   - Linked to user IDs 2-7

   **Sample Bookings (6 total)**
   - Mix of active, completed, and cancelled bookings
   - Include multi-tenant scenarios

   **Sample Payments (7 total)**
   - Various payment statuses and types
   - Midtrans integration ready

   **Sample Advance Bookings (5 total)**
   - Future bookings with different statuses

3. **Run Migrations & Seeders** ✅
   ```bash
   php artisan migrate --seed
   ```
   - ✅ All tables created successfully
   - ✅ All relationships properly established
   - ✅ Sample data populated correctly
   - ✅ Database ready for development

---

## **PHASE 2: AUTHENTICATION & MIDDLEWARE**

### **Step 6: Enhanced Authentication System** ✅
1. **Customize Breeze Registration** ✅
   - ✅ Add `nama` and `no_hp` fields to registration form
   - ✅ Update validation rules with Indonesian phone number regex
   - ✅ Set default role as 'User'

2. **Customize Breeze Login** ✅
   - ✅ Keep standard email/password login
   - ✅ Add role-based redirect after login (Admin -> admin.dashboard, User -> user.dashboard)

3. **Email Verification Setup** ✅
   - ✅ Enabled MustVerifyEmail interface on User model
   - ✅ Email verification flow ready
   - ✅ Customized verification email templates with Indonesian language

**✅ DESIGN IMPLEMENTED:**
- ✅ Login page UI design - Modern split-screen layout with MYKOST branding
- ✅ Register page UI design - Consistent design with login page (flipped layout)
- ✅ Email verification page UI design - Enhanced with icons and better UX
- ✅ Dashboard page UI design - Modern card-based design for both Admin & User views
- ✅ Forgot/Reset password pages - Consistent with overall design system
- ✅ Confirm password page - Security-focused design
- ✅ Navigation bar - Updated with MYKOST branding and user avatar

### **Step 7: Role-Based Middleware** ✅
1. **Create Custom Middleware** ✅
   ```bash
   php artisan make:middleware AdminMiddleware
   php artisan make:middleware UserMiddleware
   php artisan make:middleware PenghuniMiddleware
   ```

2. **Middleware Logic** ✅
   - **AdminMiddleware**: Check role = 'Admin' and authenticated ✅
   - **UserMiddleware**: Check role = 'User' AND authenticated ✅  
   - **PenghuniMiddleware**: Check user has active penghuni status using `hasActivePenghuni()` method ✅

3. **Register Middleware** ✅
   - Add to `bootstrap/app.php` with aliases: 'admin', 'user', 'penghuni' ✅
   - Create route groups for different access levels ✅
   - **Route Structure**: 
     - Admin routes: `/admin/*` with middleware `['auth', 'verified', 'admin']` ✅
     - User routes: `/user/*` with middleware `['auth', 'verified', 'user']` ✅
     - Penghuni routes: `/penghuni/*` with middleware `['auth', 'verified', 'penghuni']` ✅

### **Step 8: Route Structure Setup** ✅
1. **Admin Routes** (`/admin/*`) ✅
   - ✅ Dashboard with statistics
   - ✅ CRUD management (kamar, tipe_kamar, paket_kamar)
   - ✅ Pengaduan management
   - ✅ Pembayaran/transaksi reports (placeholder methods)
   - ✅ Penghuni management with force checkout
   - ✅ Export functions (placeholder methods for Phase 8)

2. **User Routes** (`/user/*`) ✅
   - ✅ Room browsing and filtering
   - ✅ Booking process with validation
   - ✅ Payment routes (placeholder methods for Phase 5)
   - ✅ Profile management (inherited from Breeze)

3. **Penghuni Routes** (`/penghuni/*`) ✅
   - ✅ History/invoice view with access control
   - ✅ Extension booking (placeholder methods for Phase 7)
   - ✅ Add penghuni features (placeholder methods for Phase 7)
   - ✅ Pengaduan submission
   - ✅ Checkout functionality (placeholder methods for Phase 7)

**✅ IMPLEMENTATION COMPLETED:**
- ✅ All controller classes created with proper namespacing
- ✅ Resource routes implemented for CRUD operations
- ✅ Middleware protection applied to all route groups
- ✅ Basic controller methods implemented with business logic
- ✅ Placeholder methods added for future phases
- ✅ Proper access control and validation in place
- ✅ Database relationships utilized in queries
- ✅ Error handling and user feedback implemented

---

## **PHASE 3: USER INTERFACE FOUNDATION**

### **Step 9: Layout & Design System** ✅ COMPLETED
1. **Create Base Layouts** ✅
   - ✅ `layouts/admin.blade.php` - Admin sidebar-based layout with Material Design
   - ✅ `layouts/user.blade.php` - User top navigation layout  
   - ✅ `layouts/guest.blade.php` - Enhanced with landing page support

2. **UI Framework & Design System** ✅
   - ✅ Tailwind CSS already included in Breeze
   - ✅ Material Design styling implementation
   - ✅ Consistent MYKOST branding (orange #f97316 + blue #1e40af)
   - ✅ Custom CSS for kost-specific styling

3. **Navigation Components** ✅
   - ✅ Admin sidebar with all menu items and active states
   - ✅ User top navigation with role-based menu
   - ✅ Mobile-responsive hamburger menu
   - ✅ Logo consistency across all layouts
   - ✅ Time display and user greeting
   - ✅ Session status notifications

**✅ IMPLEMENTATION COMPLETED:**
- ✅ Admin layout: Sidebar-based navigation with blue gradient background
- ✅ User layout: Top navigation with clean horizontal menu
- ✅ Guest layout: Landing page with hero section, features, and footer
- ✅ Consistent color scheme maintained from auth views
- ✅ Material Design principles applied
- ✅ Mobile responsive design
- ✅ Active state indicators for navigation
- ✅ Breadcrumb support for admin pages
- ✅ Add button support in admin header
- ✅ Welcome page updated to use new guest layout

### **Step 10: Component Development** ✅ COMPLETED
1. **Reusable Blade Components** ✅
   ```bash
   php artisan make:component StatBox
   php artisan make:component RoomCard
   php artisan make:component DataTable
   php artisan make:component FormInput
   php artisan make:component Modal
   ```

2. **Component Functionality** ✅
   - **StatBox**: Dashboard statistics display with gradient colors, icons, and hover effects ✅
   - **RoomCard**: Room display in browsing with image support, status badges, and booking buttons ✅
   - **DataTable**: Admin data tables with pagination, actions (view/edit/delete), and empty states ✅
   - **FormInput**: Consistent form styling with validation, multiple input types, and error handling ✅
   - **Modal**: Pop-up dialogs (already implemented from Breeze) ✅

**✅ IMPLEMENTATION COMPLETED:**
- ✅ StatBox: Gradient backgrounds, multiple icon support, subtitle option, hover animations
- ✅ RoomCard: Image display (base64 support), status badges, price ranges, booking integration
- ✅ DataTable: Responsive design, action buttons, pagination, empty states, confirmation dialogs
- ✅ FormInput: Multiple input types (text, select, textarea, file, checkbox, radio), validation, help text
- ✅ Modal: Already fully implemented with Alpine.js and transitions
- ✅ All components follow MYKOST design system with orange/blue color scheme
- ✅ Components are reusable and customizable with props
- ✅ Consistent Material Design styling applied
- ✅ Mobile responsive design implemented

---

## **PHASE 4: ADMIN FEATURES DEVELOPMENT**

### **Step 11: Admin Dashboard** ✅
1. **Dashboard Controller** ✅
   ```bash
   php artisan make:controller Admin/DashboardController
   ```

2. **Statistics Implementation** ✅
   - ✅ Total Kamar (count from kamar table)
   - ✅ Kamar Tersedia (status = 'Kosong')
   - ✅ Kamar Terisi (status = 'Terisi')
   - ✅ Total Penghuni Aktif (status_penghuni = 'Aktif')
   - ✅ Pengaduan Pending (status = 'Menunggu')
   - ✅ Revenue Bulan Ini (sum pembayaran current month)
   - ✅ Added percentage changes and trends
   - ✅ Implemented occupancy rates
   - ✅ Added complaint resolution rates

3. **Real-time Data Updates** ✅
   - ✅ Cache frequently accessed statistics (5-minute TTL)
   - ✅ Implemented recent activities feed
   - ✅ Added real-time status indicators
   - ✅ Enhanced UI with Material Design

### **Step 12: CRUD Management System** ✅
1. **Kamar Management** ✅
   ```bash
   php artisan make:controller Admin/KamarController --resource
   ```
   - ✅ **Index**: List all rooms with search/filter
   - ✅ **Create**: Form for new room (with image upload)
   - ✅ **Store**: Save new room with validation
   - ✅ **Show**: Room details view
   - ✅ **Edit**: Edit room form
   - ✅ **Update**: Update room data
   - ✅ **Destroy**: Delete room (with confirmation)
   - ✅ Added bulk delete functionality
   - ✅ Enhanced validation and error handling
   - ✅ Added transaction support
   - ✅ Implemented dependency checks

2. **Tipe Kamar Management** ✅
   ```bash
   php artisan make:controller Admin/TipeKamarController --resource
   ```
   - ✅ CRUD for room types
   - ✅ Manage facilities description
   - ✅ Validation for unique types
   - ✅ Added search and filtering
   - ✅ Enhanced error handling
   - ✅ Added bulk delete functionality
   - ✅ Implemented dependency checks

3. **Paket Kamar Management** ✅
   ```bash
   php artisan make:controller Admin/PaketKamarController --resource
   ```
   - ✅ CRUD for pricing packages
   - ✅ Complex form for all combinations
   - ✅ Price validation and formatting
   - ✅ Added search and filtering
   - ✅ Enhanced validation messages
   - ✅ Added bulk delete functionality
   - ✅ Implemented dependency checks
   - ✅ Added price change protection for active bookings

### **Step 13: Image Upload System** ✅
1. **File Upload Service** ✅
   ```bash
   php artisan make:service ImageUploadService
   ```
   - ✅ Service class created with comprehensive image handling
   - ✅ Registered in AppServiceProvider as singleton
   - ✅ Created HasImages trait for model integration

2. **Upload Implementation** ✅
   - ✅ File type validation (JPG, JPEG, PNG)
   - ✅ Size validation (max 2MB)
   - ✅ Base64 conversion for LONGBLOB storage
   - ✅ Multiple image handling support
   - ✅ Error handling and validation messages

3. **Image Display Helper** ✅
   - ✅ Base64 to data URL conversion
   - ✅ Mime type detection for proper display
   - ✅ Null handling for missing images
   - ✅ Integration with Kamar and Pengaduan models

### **Step 14: Pengaduan Management** ✅
1. **Pengaduan Controller** ✅
   ```bash
   php artisan make:controller Admin/PengaduanController
   ```

2. **Features Implementation** ✅
   - ✅ **Index**: List all complaints with advanced filters (search, status, date range, room type, response status)
   - ✅ **Show**: Detailed complaint view with timeline and full information
   - ✅ **Respond**: Admin response form (one-time only with validation)
   - ✅ **UpdateStatus**: Change complaint status with business logic validation
   - ✅ **Export**: PDF export functionality (placeholder for Phase 8)
   - ✅ **BulkUpdateStatus**: Bulk status update functionality
   - ✅ **Statistics**: Comprehensive statistics and caching

3. **Response System** ✅
   - ✅ Validate admin can only respond once
   - ✅ Update status to 'Diproses' when responding
   - ✅ Send email notification to penghuni (placeholder for Phase 9)
   - ✅ Mark as 'Selesai' when appropriate with validation
   - ✅ Database transactions for data integrity
   - ✅ Cache management for performance

**✅ IMPLEMENTATION COMPLETED:**
- ✅ Enhanced Admin PengaduanController with comprehensive filtering and search
- ✅ Advanced filtering: search, status, date range, room type, response status
- ✅ Bulk operations with JavaScript validation
- ✅ Statistics dashboard with caching (5-minute TTL)
- ✅ Detailed complaint view with timeline and full information
- ✅ One-time response system with proper validation
- ✅ Status management with business logic validation
- ✅ Image modal for complaint photos
- ✅ Database transactions and error handling
- ✅ Cache management for performance optimization
- ✅ Routes for export and bulk operations
- ✅ Responsive UI with Material Design principles
- ✅ Sorting and pagination support
- ✅ Mobile-responsive design
- ✅ Fixed model route key name for proper routing

---

## **PHASE 5: PAYMENT INTEGRATION**

### **Step 15: Midtrans Setup**
1. **Install Midtrans Package**
   ```bash
   composer require midtrans/midtrans-php
   ```

2. **Configuration**
   - Add Midtrans credentials to `.env`
   - Set to sandbox/test mode
   - Configure server key and client key

3. **Payment Service**
   ```bash
   php artisan make:service MidtransService
   ```

### **Step 16: Payment Controller**
1. **Payment Controller Creation**
   ```bash
   php artisan make:controller PaymentController
   ```

2. **Payment Methods**
   - **createPayment**: Generate Midtrans token
   - **handleCallback**: Process payment notification
   - **paymentSuccess**: Handle successful payment
   - **paymentFailed**: Handle failed payment

3. **QR Code Implementation**
   - Generate QR payment URL
   - Display QR code to user
   - Handle real-time payment status

### **Step 17: Booking Payment Flow**
1. **Integration Points**
   - Link booking form to payment
   - Create pembayaran record
   - Update user status to penghuni
   - Update kamar status
   - Send confirmation email

2. **Payment Validation**
   - Verify payment amount matches booking
   - Validate payment status from Midtrans
   - Handle payment expiration
   - Implement payment retry mechanism

---

## **PHASE 6: USER BOOKING SYSTEM**

### **Step 18: Room Browsing**
1. **Room Display Controller**
   ```bash
   php artisan make:controller User/RoomController
   ```

2. **Browsing Features**
   - **Index**: Display available rooms
   - **Filter**: By type, price range, capacity
   - **Search**: By room number or features
   - **Sort**: By price, type, availability

3. **Room Details**
   - **Show**: Detailed room view with all photos
   - Display facilities and pricing
   - Show availability calendar
   - Check advance booking conflicts

### **Step 19: Booking Process**
1. **Booking Controller**
   ```bash
   php artisan make:controller User/BookingController
   ```

2. **Booking Flow**
   - **Create**: Booking form with room/package selection
   - **ValidateAvailability**: Check room availability
   - **CalculatePrice**: Dynamic price calculation
   - **Store**: Create booking record
   - **Payment**: Redirect to payment gateway

3. **Multi-Tenant Booking**
   - **Pre-booking**: Form with friend ID input
   - **Validation**: Check friend exists and available
   - **PriceCalculation**: Adjust for 2-person package

### **Step 20: Advance Booking System**
1. **Advance Booking Logic**
   - Check 3-month maximum rule
   - Validate room availability
   - Create advance booking record
   - Display warnings for conflicting bookings

2. **Availability Calendar**
   - Visual calendar component
   - Show booked/available dates
   - Highlight advance bookings
   - Interactive date selection

---

## **PHASE 7: PENGHUNI FEATURES**

### **Step 21: History & Invoice System**
1. **History Controller**
   ```bash
   php artisan make:controller Penghuni/HistoryController
   ```

2. **History Features**
   - **Index**: Current and past bookings
   - **Show**: Detailed booking information
   - **PaymentHistory**: All payment records
   - **InvoiceView**: Formatted invoice display

3. **Data Organization**
   - Group by booking periods
   - Show payment timeline
   - Display room details and packages
   - Include extension history

### **Step 22: Extension System**
1. **Extension Controller**
   ```bash
   php artisan make:controller Penghuni/ExtensionController
   ```

2. **Extension Process**
   - **Create**: Extension form with package selection
   - **Calculate**: Pro-rated pricing
   - **Payment**: Integration with Midtrans
   - **Update**: Extend booking dates

3. **Email Reminders**
   - **Mail Class**: Create extension reminder mail
   - **Scheduler**: Set up H-3 notifications
   - **Queue**: Background email processing

### **Step 23: Add Penghuni Feature**
1. **Add Penghuni Controller**
   ```bash
   php artisan make:controller Penghuni/AddPenghuniController
   ```

2. **Post-booking Addition**
   - **Form**: Input friend ID and new package
   - **Calculate**: Additional payment needed
   - **Validation**: Check friend availability
   - **Payment**: Process additional charges
   - **Update**: Add friend to booking

3. **Pricing Logic**
   - Calculate remaining duration
   - Find price difference per period
   - Compute total additional cost
   - Update payment records

### **Step 24: Pengaduan System**
1. **Pengaduan Controller**
   ```bash
   php artisan make:controller Penghuni/PengaduanController
   ```

2. **Complaint Features**
   - **Index**: List penghuni's complaints
   - **Create**: Submit new complaint with photo
   - **Show**: View complaint details and admin response
   - **Status**: Track complaint progress

3. **File Upload**
   - Image upload for complaints
   - File validation and storage
   - Display uploaded images
   - Optimize image size

---

## **PHASE 8: REPORTING & EXPORT**

### **Step 25: PDF Export System**
1. **Install PDF Package**
   ```bash
   composer require barryvdh/laravel-dompdf
   ```

2. **PDF Service**
   ```bash
   php artisan make:service PDFExportService
   ```

3. **Export Templates**
   - Create blade templates for PDF layouts
   - Design report headers and footers
   - Format tables and data presentation

### **Step 26: Report Controllers**
1. **Transaction Reports**
   ```bash
   php artisan make:controller Admin/TransactionReportController
   ```
   - **Index**: Transaction list with filters
   - **Filter**: By date range, room, type
   - **Export**: PDF generation
   - **Statistics**: Revenue summaries

2. **Occupancy Reports**
   ```bash
   php artisan make:controller Admin/OccupancyReportController
   ```
   - **Index**: Occupancy data by period
   - **Charts**: Visual occupancy trends
   - **Export**: Detailed PDF reports

3. **Complaint Reports**
   - Export complaint data
   - Filter by status and date
   - Include admin responses
   - Summary statistics

---

## **PHASE 9: EMAIL NOTIFICATION SYSTEM**

### **Step 27: Mail Classes**
1. **Create Mail Classes**
   ```bash
   php artisan make:mail BookingConfirmation
   php artisan make:mail ExtensionReminder
   php artisan make:mail ExtensionConfirmation
   php artisan make:mail PengaduanResponse
   php artisan make:mail ForceCheckout
   ```

2. **Mail Templates**
   - Design professional email layouts
   - Include booking details and links
   - Add company branding
   - Mobile-responsive design

### **Step 28: Notification Triggers**
1. **Event-Based Notifications**
   - **BookingConfirmed**: After successful payment
   - **ExtensionNeeded**: H-3 before expiry
   - **ExtensionConfirmed**: After extension payment
   - **ComplaintResponded**: Admin response notification
   - **ForcedCheckout**: Admin action notification

2. **Queue Setup**
   ```bash
   php artisan queue:table
   php artisan migrate
   ```
   - Configure queue driver
   - Set up background job processing
   - Handle failed notifications

### **Step 29: Scheduled Tasks**
1. **Task Scheduler**
   - Daily check for expiring bookings
   - Send extension reminders
   - Update booking statuses
   - Clean up expired advance bookings

2. **Cron Job Setup**
   ```bash
   php artisan make:command CheckBookingExpiry
   php artisan make:command SendExtensionReminders
   php artisan make:command UpdateBookingStatuses
   ```

---

## **PHASE 10: ADVANCED FEATURES**

### **Step 30: Search & Filter System**
1. **Advanced Search**
   - Full-text search implementation
   - Multiple filter combinations
   - Search suggestions
   - Save search preferences

2. **Filter Components**
   - Price range sliders
   - Facility checkboxes
   - Date range pickers
   - Sorting options

### **Step 31: Status Tracking System**
1. **Audit Trail**
   - Track all status changes
   - Log user actions
   - Record admin interventions
   - Maintain change history

2. **Real-time Updates**
   - WebSocket integration (optional)
   - Live booking status updates
   - Real-time availability changes
   - Push notifications

### **Step 32: Admin Management Features**
1. **Force Checkout**
   - Admin interface for manual checkout
   - Confirmation dialogs
   - Reason logging
   - Automatic status updates

2. **User Management**
   - View all users and penghuni
   - User activity logs
   - Account status management
   - Communication tools

---

## **PHASE 11: TESTING & OPTIMIZATION**

### **Step 33: Testing Implementation**
1. **Unit Tests**
   ```bash
   php artisan make:test UserRegistrationTest
   php artisan make:test BookingProcessTest
   php artisan make:test PaymentIntegrationTest
   ```

2. **Feature Tests**
   - End-to-end booking flow
   - Admin CRUD operations
   - Payment processing
   - Email notifications

3. **Database Testing**
   - Relationship integrity
   - Data validation
   - Performance queries
   - Migration rollbacks

### **Step 34: Performance Optimization**
1. **Database Optimization**
   - Add proper indexes
   - Optimize complex queries
   - Implement database caching
   - Query performance monitoring

2. **Application Optimization**
   - Route caching
   - View caching
   - Configuration caching
   - Asset optimization

### **Step 35: Security Hardening**
1. **Security Measures**
   - Input sanitization
   - CSRF protection
   - SQL injection prevention
   - File upload security

2. **Access Control**
   - Role-based permissions
   - API rate limiting
   - Session security
   - Password policies

---

## **PHASE 12: DEPLOYMENT PREPARATION**

### **Step 36: Production Setup**
1. **Environment Configuration**
   - Production `.env` setup
   - Database configuration
   - Mail server setup
   - Payment gateway production keys

2. **Server Requirements**
   - PHP version compatibility
   - Required extensions
   - Memory and storage requirements
   - Backup strategies

### **Step 37: Documentation**
1. **User Manuals**
   - Admin user guide
   - Penghuni user guide
   - Troubleshooting guide
   - FAQ compilation

2. **Technical Documentation**
   - API documentation
   - Database schema documentation
   - Deployment instructions
   - Maintenance procedures

### **Step 38: Final Testing**
1. **User Acceptance Testing**
   - Admin workflow testing
   - User booking process testing
   - Payment integration testing
   - Email notification testing

2. **Load Testing**
   - Concurrent user simulation
   - Database performance under load
   - Payment gateway stress testing
   - Email queue processing

---

## **POST-DEPLOYMENT**

### **Step 39: Launch Preparation**
1. **Data Migration**
   - Import existing data if any
   - Verify data integrity
   - Set up initial admin accounts
   - Configure system settings

2. **Training & Support**
   - Admin training sessions
   - User onboarding materials
   - Support ticket system
   - Feedback collection

### **Step 40: Monitoring & Maintenance**
1. **System Monitoring**
   - Application performance monitoring
   - Database performance tracking
   - Error logging and alerting
   - User activity analytics

2. **Maintenance Schedule**
   - Regular backups
   - Security updates
   - Performance optimization
   - Feature enhancement planning

---

## **DEVELOPMENT TIMELINE ESTIMATE**

### **Phase 1-2: Foundation (Week 1-2)**
- Core setup, database, authentication

### **Phase 3-4: Admin Features (Week 3-4)**
- UI foundation, admin dashboard, CRUD

### **Phase 5-6: Payment & Booking (Week 5-6)**
- Midtrans integration, user booking system

### **Phase 7-8: Penghuni Features (Week 7-8)**
- History, extensions, reports

### **Phase 9-10: Advanced Features (Week 9-10)**
- Notifications, search, admin management

### **Phase 11-12: Testing & Deployment (Week 11-12)**
- Testing, optimization, deployment

**Total Estimated Development Time: 12 weeks**

---

## **RISK MITIGATION**

### **Technical Risks**
- **Payment Integration Issues**: Extensive testing with Midtrans sandbox
- **Image Storage Performance**: Implement caching and optimization
- **Complex Booking Logic**: Thorough unit testing and validation
- **Email Delivery**: Backup email providers and queue monitoring

### **Business Logic Risks**
- **Pricing Calculation Errors**: Multiple validation layers
- **Status Synchronization**: Atomic database transactions
- **Multi-tenant Conflicts**: Comprehensive booking validation
- **Date/Time Issues**: Timezone handling and validation

---

*This detailed plan provides a comprehensive roadmap for developing the MYKOST system from initial setup through deployment and maintenance.* 
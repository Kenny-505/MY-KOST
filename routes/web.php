<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KamarController as AdminKamarController;
use App\Http\Controllers\Admin\TipeKamarController as AdminTipeKamarController;
use App\Http\Controllers\Admin\PaketKamarController as AdminPaketKamarController;
use App\Http\Controllers\Admin\PengaduanController as AdminPengaduanController;
use App\Http\Controllers\Admin\PenghuniController as AdminPenghuniController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\RoomController as UserRoomController;
use App\Http\Controllers\User\BookingController as UserBookingController;
use App\Http\Controllers\Penghuni\HistoryController as PenghuniHistoryController;
use App\Http\Controllers\Penghuni\PengaduanController as PenghuniPengaduanController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/dashboard', function () {
    // Redirect to role-specific dashboards
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    
    $user = Auth::user();
    
    if ($user->role === 'Admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'User') {
        return redirect()->route('user.dashboard');
    } else {
        // Fallback for unknown roles
        Auth::logout();
        return redirect()->route('login')->withErrors(['role' => 'Invalid user role.']);
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes Group - Protected by admin middleware
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Kamar Management
    Route::resource('kamar', AdminKamarController::class);
    
    // Tipe Kamar Management
    Route::resource('tipe-kamar', AdminTipeKamarController::class);
    
    // Paket Kamar Management
    Route::resource('paket-kamar', AdminPaketKamarController::class);
    
    // Pengaduan Management
    Route::get('pengaduan/export', [AdminPengaduanController::class, 'export'])->name('pengaduan.export');
    Route::post('pengaduan/bulk-update-status', [AdminPengaduanController::class, 'bulkUpdateStatus'])->name('pengaduan.bulkUpdateStatus');
    Route::resource('pengaduan', AdminPengaduanController::class)->only(['index', 'show']);
    Route::post('pengaduan/{pengaduan}/respond', [AdminPengaduanController::class, 'respond'])->name('pengaduan.respond');
    Route::patch('pengaduan/{pengaduan}/status', [AdminPengaduanController::class, 'updateStatus'])->name('pengaduan.updateStatus');
    
    // Penghuni Management
    Route::get('penghuni', [AdminPenghuniController::class, 'index'])->name('penghuni.index');
    Route::get('penghuni/{penghuni}', [AdminPenghuniController::class, 'show'])->name('penghuni.show');
    Route::post('penghuni/{penghuni}/force-checkout', [AdminPenghuniController::class, 'forceCheckout'])->name('penghuni.forceCheckout');
    
    // Reports & Export Routes
    Route::get('/reports/transactions', [AdminDashboardController::class, 'transactionReports'])->name('reports.transactions');
    Route::get('/reports/occupancy', [AdminDashboardController::class, 'occupancyReports'])->name('reports.occupancy');
    Route::get('/reports/complaints', [AdminDashboardController::class, 'complaintReports'])->name('reports.complaints');
    
    // Export Routes
    Route::get('/export/transactions', [AdminDashboardController::class, 'exportTransactions'])->name('export.transactions');
    Route::get('/export/occupancy', [AdminDashboardController::class, 'exportOccupancy'])->name('export.occupancy');
    Route::get('/export/complaints', [AdminDashboardController::class, 'exportComplaints'])->name('export.complaints');
    Route::get('/export/penghuni', [AdminPenghuniController::class, 'export'])->name('export.penghuni');
});

// User Routes Group - Protected by user middleware
Route::middleware(['auth', 'verified', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    // Room Routes
    Route::get('/rooms', [UserRoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/{room}', [UserRoomController::class, 'show'])->name('rooms.show');
    Route::post('/rooms/{room}/check-availability', [UserRoomController::class, 'checkAvailability'])
        ->name('rooms.check-availability');
    
    // Booking Process
    Route::get('/booking/create', [UserBookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [UserBookingController::class, 'store'])->name('booking.store');
    Route::post('/validate-friend-email', [UserBookingController::class, 'validateFriendEmail'])->name('booking.validateFriendEmail');
    
    // Payment Routes (will be implemented in Phase 5)
    Route::get('/payment/create/{pembayaran}', [UserBookingController::class, 'createPayment'])->name('payment.create');
    Route::post('/payment/process', [UserBookingController::class, 'processPayment'])->name('payment.process');
    Route::get('/payment/success', [UserBookingController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment/failed', [UserBookingController::class, 'paymentFailed'])->name('payment.failed');
});

// Penghuni Routes Group - Protected by penghuni middleware (active penghuni only)
Route::middleware(['auth', 'verified', 'penghuni'])->prefix('penghuni')->name('penghuni.')->group(function () {
    // History & Booking Management
    Route::get('/history', [PenghuniHistoryController::class, 'index'])->name('history.index');
    Route::get('/history/{booking}', [PenghuniHistoryController::class, 'show'])->name('history.show');
    Route::get('/payments', [PenghuniHistoryController::class, 'payments'])->name('payments.index');
    
    // Extension Routes (will be implemented in Phase 7)
    Route::get('/extension/create/{booking}', [PenghuniHistoryController::class, 'createExtension'])->name('extension.create');
    Route::post('/extension/{booking}', [PenghuniHistoryController::class, 'storeExtension'])->name('extension.store');
    
    // Add Penghuni Routes (will be implemented in Phase 7)
    Route::get('/add-penghuni/{booking}', [PenghuniHistoryController::class, 'addPenghuniForm'])->name('addPenghuni.form');
    Route::post('/add-penghuni/{booking}', [PenghuniHistoryController::class, 'addPenghuni'])->name('addPenghuni.store');
    
    // Checkout Routes (will be implemented in Phase 7)
    Route::post('/checkout/{booking}', [PenghuniHistoryController::class, 'checkout'])->name('checkout');
    
    // Pengaduan System
    Route::resource('pengaduan', PenghuniPengaduanController::class)->only(['index', 'create', 'store', 'show']);
    Route::post('pengaduan/{pengaduan}/mark-completed', [PenghuniPengaduanController::class, 'markAsCompleted'])->name('pengaduan.markCompleted');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Payment Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/payment/form/{booking}', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
    Route::post('/payment/create', [PaymentController::class, 'createPayment'])->name('payment.create');
    Route::post('/payment/callback', [PaymentController::class, 'handleCallback'])->name('payment.callback');
    Route::get('/payment/success/{orderId}', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment/failed/{orderId}', [PaymentController::class, 'paymentFailed'])->name('payment.failed');
});

require __DIR__.'/auth.php';
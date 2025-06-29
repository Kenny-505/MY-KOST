<?php
// Script to fix expired active bookings
// Run this to automatically complete expired bookings

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables');

use App\Models\Booking;
use App\Models\Kamar;
use Carbon\Carbon;

// Update expired active bookings to 'Selesai'
$expiredBookings = Booking::where('status_booking', 'Aktif')
    ->where('tanggal_selesai', '<', Carbon::now())
    ->get();

echo "Found " . $expiredBookings->count() . " expired active bookings\n";

foreach ($expiredBookings as $booking) {
    $booking->update(['status_booking' => 'Selesai']);
    echo "Updated booking ID: " . $booking->id_booking . " to Selesai\n";
    
    // Update room status back to available if no other active bookings
    $activeBookingsForRoom = Booking::where('id_kamar', $booking->id_kamar)
        ->where('status_booking', 'Aktif')
        ->count();
    
    if ($activeBookingsForRoom == 0) {
        $kamar = Kamar::find($booking->id_kamar);
        if ($kamar && $kamar->status != 'Kosong') {
            $kamar->update(['status' => 'Kosong']);
            echo "Updated room " . $kamar->no_kamar . " to Kosong\n";
        }
    }
}

echo "Cleanup completed!\n";
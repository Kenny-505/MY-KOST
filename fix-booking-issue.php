<?php
// Script to fix active booking issue for netlucky user
// Run this file directly to clean up expired bookings

require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel application
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Booking;
use App\Models\Kamar;
use App\Models\User;
use App\Models\Penghuni;
use Carbon\Carbon;

echo "Starting booking cleanup for netlucky user...\n";

// Find netlucky user
$user = User::where('email', 'netlucky@gmail.com')->first();
if (!$user) {
    echo "User netlucky@gmail.com not found!\n";
    exit;
}

echo "Found user: {$user->nama} ({$user->email})\n";

// Find penghuni record for this user
$penghuni = Penghuni::where('id_user', $user->id)->first();
if (!$penghuni) {
    echo "No penghuni record found for this user\n";
    exit;
}

echo "Found penghuni ID: {$penghuni->id_penghuni}\n";

// Find all active bookings for this user
$activeBookings = Booking::where('id_penghuni', $penghuni->id_penghuni)
    ->where('status_booking', 'Aktif')
    ->get();

echo "Found {$activeBookings->count()} active bookings\n";

foreach ($activeBookings as $booking) {
    echo "\nBooking ID: {$booking->id_booking}\n";
    echo "Room: {$booking->id_kamar}\n";
    echo "Start: {$booking->tanggal_mulai}\n";
    echo "End: {$booking->tanggal_selesai}\n";
    echo "Status: {$booking->status_booking}\n";
    
    // Check if booking is expired
    $endDate = Carbon::parse($booking->tanggal_selesai);
    $now = Carbon::now();
    
    if ($endDate->lt($now)) {
        echo "Booking is expired. Updating to 'Selesai'...\n";
        $booking->update(['status_booking' => 'Selesai']);
        
        // Update room status if no other active bookings
        $otherActiveBookings = Booking::where('id_kamar', $booking->id_kamar)
            ->where('status_booking', 'Aktif')
            ->where('id_booking', '!=', $booking->id_booking)
            ->count();
            
        if ($otherActiveBookings == 0) {
            $kamar = Kamar::find($booking->id_kamar);
            if ($kamar) {
                $kamar->update(['status' => 'Kosong']);
                echo "Updated room {$kamar->no_kamar} to Kosong\n";
            }
        }
    } else {
        echo "Booking is still valid. Manually setting to 'Selesai' anyway...\n";
        $booking->update(['status_booking' => 'Selesai']);
        
        // Update room status
        $kamar = Kamar::find($booking->id_kamar);
        if ($kamar) {
            $kamar->update(['status' => 'Kosong']);
            echo "Updated room {$kamar->no_kamar} to Kosong\n";
        }
    }
}

echo "\nCleanup completed! You can now make new bookings.\n";
?> 
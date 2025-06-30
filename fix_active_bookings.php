<?php
// Fix Active Bookings Status Script
// Run this from your project root: php fix_active_bookings.php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Booking;
use App\Models\Kamar;
use Illuminate\Support\Facades\DB;

echo "Starting booking status fix...\n";

try {
    DB::transaction(function () {
        $activeBookings = Booking::where('status_booking', 'Aktif')->get();
        
        if ($activeBookings->isEmpty()) {
            echo "No active bookings found. No changes needed.\n";
            return;
        }

        echo "Found " . $activeBookings->count() . " active bookings.\n";

        $updatedKamarIds = [];

        foreach ($activeBookings as $booking) {
            $kamar = Kamar::find($booking->id_kamar);
            if ($kamar && $kamar->status !== 'Dipesan') {
                $kamar->status = 'Dipesan';
                $kamar->save();
                $updatedKamarIds[] = $kamar->id_kamar;
                echo "Updated Kamar ID: " . $kamar->id_kamar . " (No: " . $kamar->no_kamar . ") to 'Dipesan'.\n";
            }
        }

        if (empty($updatedKamarIds)) {
            echo "All active bookings already have the correct 'Dipesan' room status.\n";
        } else {
            echo "Successfully updated " . count($updatedKamarIds) . " room statuses.\n";
        }
    });
} catch (\Exception $e) {
    echo "An error occurred: " . $e->getMessage() . "\n";
}

echo "Script finished.\n";
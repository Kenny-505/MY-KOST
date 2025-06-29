<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Models\Kamar;
use Carbon\Carbon;

class CleanupExpiredBookings extends Command
{
    protected $signature = 'booking:cleanup-expired';
    protected $description = 'Cleanup expired active bookings and update room status';

    public function handle()
    {
        $this->info('Starting cleanup of expired bookings...');

        // Find expired active bookings
        $expiredBookings = Booking::where('status_booking', 'Aktif')
            ->where('tanggal_selesai', '<', Carbon::now())
            ->get();

        $this->info("Found {$expiredBookings->count()} expired active bookings");

        $updatedRooms = 0;
        
        foreach ($expiredBookings as $booking) {
            // Update booking status
            $booking->update(['status_booking' => 'Selesai']);
            $this->line("✓ Updated booking ID: {$booking->id_booking} to Selesai");
            
            // Check if room should be set to available
            $activeBookingsForRoom = Booking::where('id_kamar', $booking->id_kamar)
                ->where('status_booking', 'Aktif')
                ->count();
            
            if ($activeBookingsForRoom == 0) {
                $kamar = Kamar::find($booking->id_kamar);
                if ($kamar && $kamar->status != 'Kosong') {
                    $kamar->update(['status' => 'Kosong']);
                    $this->line("✓ Updated room {$kamar->no_kamar} to Kosong");
                    $updatedRooms++;
                }
            }
        }

        $this->info("Cleanup completed!");
        $this->info("- Updated {$expiredBookings->count()} bookings to 'Selesai'");
        $this->info("- Updated {$updatedRooms} rooms to 'Kosong'");

        return 0;
    }
} 
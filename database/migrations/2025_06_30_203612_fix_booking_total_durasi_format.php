<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get all bookings with total_durasi that needs formatting
        $bookings = DB::table('booking')->whereNotNull('total_durasi')->get();
        
        foreach ($bookings as $booking) {
            if (!empty($booking->total_durasi)) {
                // Split the duration into number and unit (e.g., "1.5 bulan" -> ["1.5", "bulan"])
                $parts = explode(' ', $booking->total_durasi);
                
                if (count($parts) >= 2 && is_numeric($parts[0])) {
                    $number = (float) $parts[0];
                    $unit = $parts[1];
                    
                    // Format number with 3 decimal places, removing trailing zeros
                    $formattedNumber = rtrim(rtrim(number_format($number, 3, '.', ''), '0'), '.');
                    $newTotalDurasi = $formattedNumber . ' ' . $unit;
                    
                    // Update only if the format has changed
                    if ($newTotalDurasi !== $booking->total_durasi) {
                        DB::table('booking')
                            ->where('id_booking', $booking->id_booking)
                            ->update(['total_durasi' => $newTotalDurasi]);
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration cannot be reversed as we're formatting existing data
        // The original long decimal format cannot be restored
    }
};

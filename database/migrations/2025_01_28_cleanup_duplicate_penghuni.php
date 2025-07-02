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
        // Cleanup duplicate penghuni records
        $this->cleanupDuplicatePenghuni();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cannot reverse this migration as it involves data cleanup
    }

    /**
     * Cleanup duplicate penghuni records
     */
    private function cleanupDuplicatePenghuni(): void
    {
        DB::transaction(function () {
            // Find users with multiple penghuni records
            $duplicateUsers = DB::table('penghuni')
                ->select('id_user', DB::raw('COUNT(*) as count'))
                ->groupBy('id_user')
                ->having('count', '>', 1)
                ->get();

            foreach ($duplicateUsers as $duplicate) {
                $userId = $duplicate->id_user;
                
                // Get all penghuni records for this user, ordered by id (oldest first)
                $penghunis = DB::table('penghuni')
                    ->where('id_user', $userId)
                    ->orderBy('id_penghuni', 'asc')
                    ->get();

                $originalPenghuni = $penghunis->first(); // Keep the oldest record
                $duplicates = $penghunis->skip(1); // Get the duplicates

                foreach ($duplicates as $duplicatePenghuni) {
                    // Update all bookings that reference the duplicate to point to original
                    DB::table('booking')
                        ->where('id_penghuni', $duplicatePenghuni->id_penghuni)
                        ->update(['id_penghuni' => $originalPenghuni->id_penghuni]);
                    
                    DB::table('booking')
                        ->where('id_teman', $duplicatePenghuni->id_penghuni)
                        ->update(['id_teman' => $originalPenghuni->id_penghuni]);

                    // Update all pengaduan that reference the duplicate
                    DB::table('pengaduan')
                        ->where('id_penghuni', $duplicatePenghuni->id_penghuni)
                        ->update(['id_penghuni' => $originalPenghuni->id_penghuni]);

                    // Delete the duplicate penghuni record
                    DB::table('penghuni')
                        ->where('id_penghuni', $duplicatePenghuni->id_penghuni)
                        ->delete();

                    echo "Merged penghuni ID {$duplicatePenghuni->id_penghuni} into {$originalPenghuni->id_penghuni} for user {$userId}\n";
                }

                // Ensure the original penghuni is active if they have active bookings
                $hasActiveBookings = DB::table('booking')
                    ->where(function ($query) use ($originalPenghuni) {
                        $query->where('id_penghuni', $originalPenghuni->id_penghuni)
                              ->orWhere('id_teman', $originalPenghuni->id_penghuni);
                    })
                    ->where('status_booking', 'Aktif')
                    ->exists();

                if ($hasActiveBookings) {
                    DB::table('penghuni')
                        ->where('id_penghuni', $originalPenghuni->id_penghuni)
                        ->update(['status_penghuni' => 'Aktif']);
                }
            }
        });
    }
}; 
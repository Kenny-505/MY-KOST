<?php

namespace Database\Seeders;

use App\Models\Penghuni;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenghuniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penghuni = [
            // Link some users to active rooms (based on "Terisi" status rooms)
            [
                'id_user' => 2, // John Doe - linked to S003 (Terisi)
                'status_penghuni' => 'Aktif',
            ],
            [
                'id_user' => 3, // Jane Smith - linked to E002 (Terisi)
                'status_penghuni' => 'Aktif',
            ],
            [
                'id_user' => 4, // Ahmad Rahman - linked to X003 (Terisi)
                'status_penghuni' => 'Aktif',
            ],
            [
                'id_user' => 5, // Siti Nurhaliza - Non-aktif (former tenant)
                'status_penghuni' => 'Non-aktif',
            ],
        ];

        foreach ($penghuni as $p) {
            Penghuni::create($p);
        }
    }
}

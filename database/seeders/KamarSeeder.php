<?php

namespace Database\Seeders;

use App\Models\Kamar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KamarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kamars = [
            // Standar Rooms
            [
                'id_tipe_kamar' => 1,
                'status' => 'Kosong',
                'no_kamar' => 'S001',
                'deskripsi' => 'Kamar standar lantai 1 dengan akses mudah ke fasilitas umum.',
            ],
            [
                'id_tipe_kamar' => 1,
                'status' => 'Kosong',
                'no_kamar' => 'S002',
                'deskripsi' => 'Kamar standar lantai 1 dengan pemandangan taman.',
            ],
            [
                'id_tipe_kamar' => 1,
                'status' => 'Terisi',
                'no_kamar' => 'S003',
                'deskripsi' => 'Kamar standar lantai 2 yang nyaman dan tenang.',
            ],
            [
                'id_tipe_kamar' => 1,
                'status' => 'Kosong',
                'no_kamar' => 'S004',
                'deskripsi' => 'Kamar standar lantai 2 dengan ventilasi baik.',
            ],
            [
                'id_tipe_kamar' => 1,
                'status' => 'Kosong',
                'no_kamar' => 'S005',
                'deskripsi' => 'Kamar standar lantai 3 dengan pemandangan kota.',
            ],

            // Elite Rooms
            [
                'id_tipe_kamar' => 2,
                'status' => 'Kosong',
                'no_kamar' => 'E001',
                'deskripsi' => 'Kamar elite lantai 2 dengan fasilitas premium dan balkon kecil.',
            ],
            [
                'id_tipe_kamar' => 2,
                'status' => 'Terisi',
                'no_kamar' => 'E002',
                'deskripsi' => 'Kamar elite lantai 2 yang luas dengan area kerja yang nyaman.',
            ],
            [
                'id_tipe_kamar' => 2,
                'status' => 'Kosong',
                'no_kamar' => 'E003',
                'deskripsi' => 'Kamar elite lantai 3 dengan pemandangan menawan.',
            ],
            [
                'id_tipe_kamar' => 2,
                'status' => 'Kosong',
                'no_kamar' => 'E004',
                'deskripsi' => 'Kamar elite lantai 3 dengan desain modern dan elegan.',
            ],

            // Exclusive Rooms
            [
                'id_tipe_kamar' => 3,
                'status' => 'Kosong',
                'no_kamar' => 'X001',
                'deskripsi' => 'Kamar exclusive premium dengan fasilitas mewah dan ruang tamu kecil.',
            ],
            [
                'id_tipe_kamar' => 3,
                'status' => 'Kosong',
                'no_kamar' => 'X002',
                'deskripsi' => 'Kamar exclusive terbaik dengan pemandangan panorama dan fasilitas lengkap.',
            ],
            [
                'id_tipe_kamar' => 3,
                'status' => 'Terisi',
                'no_kamar' => 'X003',
                'deskripsi' => 'Kamar exclusive dengan desain minimalis modern dan teknologi terbaru.',
            ],
        ];

        foreach ($kamars as $kamar) {
            Kamar::create($kamar);
        }
    }
}

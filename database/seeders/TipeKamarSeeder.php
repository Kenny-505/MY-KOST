<?php

namespace Database\Seeders;

use App\Models\TipeKamar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipeKamarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipeKamar = [
            [
                'tipe_kamar' => 'Standar',
                'fasilitas' => 'Kamar dengan fasilitas dasar: tempat tidur, lemari, meja belajar, kamar mandi dalam, AC, WiFi gratis.',
            ],
            [
                'tipe_kamar' => 'Elite',
                'fasilitas' => 'Kamar dengan fasilitas lengkap: tempat tidur queen, lemari besar, meja kerja, kamar mandi dalam, AC, TV 32 inch, WiFi gratis, minibar.',
            ],
            [
                'tipe_kamar' => 'Exclusive',
                'fasilitas' => 'Kamar premium: tempat tidur king, walk-in closet, meja kerja ergonomis, kamar mandi mewah dengan bathtub, AC dual zone, TV 43 inch, WiFi premium, minibar, dapur kecil dengan kulkas.',
            ],
        ];

        foreach ($tipeKamar as $tipe) {
            TipeKamar::create($tipe);
        }
    }
}

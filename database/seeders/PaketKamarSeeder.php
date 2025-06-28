<?php

namespace Database\Seeders;

use App\Models\PaketKamar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaketKamarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paketKamar = [
            // Standar Room Packages (id_tipe_kamar = 1)
            ['id_tipe_kamar' => 1, 'jenis_paket' => 'Mingguan', 'kapasitas_kamar' => '1', 'jumlah_penghuni' => '1', 'harga' => 500000.00],
            ['id_tipe_kamar' => 1, 'jenis_paket' => 'Bulanan', 'kapasitas_kamar' => '1', 'jumlah_penghuni' => '1', 'harga' => 1800000.00],
            ['id_tipe_kamar' => 1, 'jenis_paket' => 'Tahunan', 'kapasitas_kamar' => '1', 'jumlah_penghuni' => '1', 'harga' => 20000000.00],
            ['id_tipe_kamar' => 1, 'jenis_paket' => 'Mingguan', 'kapasitas_kamar' => '2', 'jumlah_penghuni' => '1', 'harga' => 650000.00],
            ['id_tipe_kamar' => 1, 'jenis_paket' => 'Bulanan', 'kapasitas_kamar' => '2', 'jumlah_penghuni' => '1', 'harga' => 2300000.00],
            ['id_tipe_kamar' => 1, 'jenis_paket' => 'Tahunan', 'kapasitas_kamar' => '2', 'jumlah_penghuni' => '1', 'harga' => 25000000.00],
            ['id_tipe_kamar' => 1, 'jenis_paket' => 'Mingguan', 'kapasitas_kamar' => '2', 'jumlah_penghuni' => '2', 'harga' => 800000.00],
            ['id_tipe_kamar' => 1, 'jenis_paket' => 'Bulanan', 'kapasitas_kamar' => '2', 'jumlah_penghuni' => '2', 'harga' => 2800000.00],
            ['id_tipe_kamar' => 1, 'jenis_paket' => 'Tahunan', 'kapasitas_kamar' => '2', 'jumlah_penghuni' => '2', 'harga' => 30000000.00],

            // Elite Room Packages (id_tipe_kamar = 2)
            ['id_tipe_kamar' => 2, 'jenis_paket' => 'Mingguan', 'kapasitas_kamar' => '1', 'jumlah_penghuni' => '1', 'harga' => 750000.00],
            ['id_tipe_kamar' => 2, 'jenis_paket' => 'Bulanan', 'kapasitas_kamar' => '1', 'jumlah_penghuni' => '1', 'harga' => 2700000.00],
            ['id_tipe_kamar' => 2, 'jenis_paket' => 'Tahunan', 'kapasitas_kamar' => '1', 'jumlah_penghuni' => '1', 'harga' => 30000000.00],
            ['id_tipe_kamar' => 2, 'jenis_paket' => 'Mingguan', 'kapasitas_kamar' => '2', 'jumlah_penghuni' => '1', 'harga' => 950000.00],
            ['id_tipe_kamar' => 2, 'jenis_paket' => 'Bulanan', 'kapasitas_kamar' => '2', 'jumlah_penghuni' => '1', 'harga' => 3400000.00],
            ['id_tipe_kamar' => 2, 'jenis_paket' => 'Tahunan', 'kapasitas_kamar' => '2', 'jumlah_penghuni' => '1', 'harga' => 37000000.00],
            ['id_tipe_kamar' => 2, 'jenis_paket' => 'Mingguan', 'kapasitas_kamar' => '2', 'jumlah_penghuni' => '2', 'harga' => 1200000.00],
            ['id_tipe_kamar' => 2, 'jenis_paket' => 'Bulanan', 'kapasitas_kamar' => '2', 'jumlah_penghuni' => '2', 'harga' => 4200000.00],
            ['id_tipe_kamar' => 2, 'jenis_paket' => 'Tahunan', 'kapasitas_kamar' => '2', 'jumlah_penghuni' => '2', 'harga' => 45000000.00],

            // Exclusive Room Packages (id_tipe_kamar = 3)
            ['id_tipe_kamar' => 3, 'jenis_paket' => 'Mingguan', 'kapasitas_kamar' => '1', 'jumlah_penghuni' => '1', 'harga' => 1200000.00],
            ['id_tipe_kamar' => 3, 'jenis_paket' => 'Bulanan', 'kapasitas_kamar' => '1', 'jumlah_penghuni' => '1', 'harga' => 4200000.00],
            ['id_tipe_kamar' => 3, 'jenis_paket' => 'Tahunan', 'kapasitas_kamar' => '1', 'jumlah_penghuni' => '1', 'harga' => 45000000.00],
            ['id_tipe_kamar' => 3, 'jenis_paket' => 'Mingguan', 'kapasitas_kamar' => '2', 'jumlah_penghuni' => '1', 'harga' => 1500000.00],
            ['id_tipe_kamar' => 3, 'jenis_paket' => 'Bulanan', 'kapasitas_kamar' => '2', 'jumlah_penghuni' => '1', 'harga' => 5200000.00],
            ['id_tipe_kamar' => 3, 'jenis_paket' => 'Tahunan', 'kapasitas_kamar' => '2', 'jumlah_penghuni' => '1', 'harga' => 55000000.00],
            ['id_tipe_kamar' => 3, 'jenis_paket' => 'Mingguan', 'kapasitas_kamar' => '2', 'jumlah_penghuni' => '2', 'harga' => 1800000.00],
            ['id_tipe_kamar' => 3, 'jenis_paket' => 'Bulanan', 'kapasitas_kamar' => '2', 'jumlah_penghuni' => '2', 'harga' => 6200000.00],
            ['id_tipe_kamar' => 3, 'jenis_paket' => 'Tahunan', 'kapasitas_kamar' => '2', 'jumlah_penghuni' => '2', 'harga' => 65000000.00],
        ];

        foreach ($paketKamar as $paket) {
            PaketKamar::create($paket);
        }
    }
}

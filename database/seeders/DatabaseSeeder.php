<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Database seeders are disabled since we're using MySQL database
        // with data imported from mykost_updated_schema.sql
        
        /*
        $this->call([
            UserSeeder::class,
            TipeKamarSeeder::class,
            PaketKamarSeeder::class,
            KamarSeeder::class,
            PenghuniSeeder::class,
        ]);
        */
    }
}

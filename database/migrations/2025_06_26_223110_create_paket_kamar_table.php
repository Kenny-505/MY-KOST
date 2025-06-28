<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paket_kamar', function (Blueprint $table) {
            $table->id('id_paket_kamar');
            $table->integer('id_tipe_kamar');
            $table->enum('jenis_paket', ['Mingguan', 'Bulanan', 'Tahunan']);
            $table->enum('kapasitas_kamar', ['1', '2'])->comment('Physical room capacity');
            $table->enum('jumlah_penghuni', ['1', '2'])->comment('Number of occupants');
            $table->decimal('harga', 12, 2);
            $table->timestamps();
            
            $table->foreign('id_tipe_kamar')->references('id_tipe_kamar')->on('tipe_kamar')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_kamar');
    }
};

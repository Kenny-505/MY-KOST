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
        Schema::create('tipe_kamar', function (Blueprint $table) {
            $table->integer('id_tipe_kamar')->autoIncrement();
            $table->enum('tipe_kamar', ['Standar', 'Elite', 'Exclusive']);
            $table->text('fasilitas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipe_kamar');
    }
};

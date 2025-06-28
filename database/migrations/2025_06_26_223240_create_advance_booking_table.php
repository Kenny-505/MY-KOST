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
        Schema::create('advance_booking', function (Blueprint $table) {
            $table->id('id_advance');
            $table->unsignedBigInteger('id_kamar');
            $table->unsignedBigInteger('id_user');
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai');
            $table->enum('status', ['Active', 'Cancelled', 'Completed'])->default('Active');
            $table->timestamps();
            
            $table->foreign('id_kamar')->references('id_kamar')->on('kamar')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advance_booking');
    }
};

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
        Schema::create('booking', function (Blueprint $table) {
            $table->integer('id_booking')->autoIncrement();
            $table->integer('id_penghuni')->comment('Primary tenant');
            $table->integer('id_teman')->nullable()->comment('Secondary tenant');
            $table->integer('id_kamar');
            $table->unsignedBigInteger('id_paket_kamar');
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai');
            $table->string('total_durasi')->nullable();
            $table->enum('status_booking', ['Aktif', 'Selesai', 'Dibatalkan'])->default('Aktif');
            $table->timestamps();
            
            $table->foreign('id_penghuni')->references('id_penghuni')->on('penghuni')->onDelete('cascade');
            $table->foreign('id_teman')->references('id_penghuni')->on('penghuni')->onDelete('set null');
            $table->foreign('id_kamar')->references('id_kamar')->on('kamar')->onDelete('cascade');
            $table->foreign('id_paket_kamar')->references('id_paket_kamar')->on('paket_kamar')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};

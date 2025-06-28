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
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->integer('id_pengaduan')->autoIncrement();
            $table->integer('id_penghuni');
            $table->integer('id_kamar');
            $table->string('judul_pengaduan');
            $table->text('isi_pengaduan');
            $table->enum('status', ['Menunggu', 'Diproses', 'Selesai'])->default('Menunggu');
            $table->longText('foto_pengaduan')->nullable()->comment('Base64 encoded image data for complaint photo');
            $table->dateTime('tanggal_pengaduan');
            $table->text('response_admin')->nullable();
            $table->dateTime('tanggal_response')->nullable();
            $table->timestamps();
            
            $table->foreign('id_penghuni')->references('id_penghuni')->on('penghuni')->onDelete('cascade');
            $table->foreign('id_kamar')->references('id_kamar')->on('kamar')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};

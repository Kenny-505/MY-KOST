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
        Schema::create('kamar', function (Blueprint $table) {
            $table->id('id_kamar');
            $table->integer('id_tipe_kamar');
            $table->enum('status', ['Kosong', 'Dipesan', 'Terisi'])->default('Kosong');
            $table->string('no_kamar', 50)->unique();
            $table->longText('foto_kamar1')->nullable()->comment('Base64 encoded image data, max 2MB');
            $table->longText('foto_kamar2')->nullable()->comment('Base64 encoded image data, max 2MB');
            $table->longText('foto_kamar3')->nullable()->comment('Base64 encoded image data, max 2MB');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
            
            $table->foreign('id_tipe_kamar')->references('id_tipe_kamar')->on('tipe_kamar')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamar');
    }
};

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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->integer('id_pembayaran')->autoIncrement();
            $table->unsignedBigInteger('id_user');
            $table->integer('id_booking');
            $table->integer('id_kamar');
            $table->dateTime('tanggal_pembayaran');
            $table->enum('status_pembayaran', ['Belum bayar', 'Gagal', 'Lunas'])->default('Belum bayar');
            $table->decimal('jumlah_pembayaran', 12, 2);
            $table->string('bukti_pembayaran')->nullable();
            $table->enum('payment_type', ['Booking', 'Extension', 'Additional'])->default('Booking')->comment('Type of payment');
            $table->string('midtrans_order_id')->nullable()->comment('Midtrans transaction ID');
            $table->string('midtrans_transaction_id')->nullable();
            $table->timestamps();
            
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_booking')->references('id_booking')->on('booking')->onDelete('cascade');
            $table->foreign('id_kamar')->references('id_kamar')->on('kamar')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};

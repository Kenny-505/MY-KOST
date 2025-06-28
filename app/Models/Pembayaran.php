<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id_pembayaran';

    /**
     * The data type of the auto-incrementing ID.
     */
    protected $keyType = 'int';

    /**
     * The table associated with the model.
     */
    protected $table = 'pembayaran';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id_user',
        'id_booking',
        'id_kamar',
        'tanggal_pembayaran',
        'status_pembayaran',
        'jumlah_pembayaran',
        'bukti_pembayaran',
        'payment_type',
        'midtrans_order_id',
        'midtrans_transaction_id',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'tanggal_pembayaran' => 'datetime',
            'jumlah_pembayaran' => 'decimal:2',
        ];
    }

    /**
     * Get the user that owns the pembayaran.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Get the booking that owns the pembayaran.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'id_booking');
    }

    /**
     * Get the kamar that owns the pembayaran.
     */
    public function kamar(): BelongsTo
    {
        return $this->belongsTo(Kamar::class, 'id_kamar');
    }

    /**
     * Check if payment is completed
     */
    public function isPaid(): bool
    {
        return $this->status_pembayaran === 'Lunas';
    }

    /**
     * Check if payment is pending
     */
    public function isPending(): bool
    {
        return $this->status_pembayaran === 'Belum bayar';
    }

    /**
     * Check if payment is failed
     */
    public function isFailed(): bool
    {
        return $this->status_pembayaran === 'Gagal';
    }
}

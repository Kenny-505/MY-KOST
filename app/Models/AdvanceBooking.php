<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdvanceBooking extends Model
{
    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id_advance';

    /**
     * The table associated with the model.
     */
    protected $table = 'advance_booking';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id_kamar',
        'id_user',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'datetime',
            'tanggal_selesai' => 'datetime',
        ];
    }

    /**
     * Get the kamar that owns the advance booking.
     */
    public function kamar(): BelongsTo
    {
        return $this->belongsTo(Kamar::class, 'id_kamar');
    }

    /**
     * Get the user that owns the advance booking.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Check if advance booking is active
     */
    public function isActive(): bool
    {
        return $this->status === 'Active';
    }

    /**
     * Check if advance booking is cancelled
     */
    public function isCancelled(): bool
    {
        return $this->status === 'Cancelled';
    }

    /**
     * Check if advance booking is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'Completed';
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penghuni extends Model
{
    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id_penghuni';

    /**
     * The data type of the auto-incrementing ID.
     */
    protected $keyType = 'int';

    /**
     * The table associated with the model.
     */
    protected $table = 'penghuni';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id_user',
        'status_penghuni',
    ];

    /**
     * Get the user that owns the penghuni.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Get the booking records for the penghuni.
     */
    public function booking(): HasMany
    {
        return $this->hasMany(Booking::class, 'id_penghuni');
    }

    /**
     * Get the booking records where penghuni is secondary tenant.
     */
    public function bookingAsTeman(): HasMany
    {
        return $this->hasMany(Booking::class, 'id_teman');
    }

    /**
     * Get the pengaduan records for the penghuni.
     */
    public function pengaduan(): HasMany
    {
        return $this->hasMany(Pengaduan::class, 'id_penghuni');
    }

    /**
     * Check if penghuni is active
     */
    public function isActive(): bool
    {
        return $this->status_penghuni === 'Aktif';
    }

    public function getRouteKeyName()
    {
        return 'id_penghuni';
    }
}

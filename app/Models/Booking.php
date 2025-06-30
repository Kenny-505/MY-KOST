<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id_booking';

    /**
     * The data type of the auto-incrementing ID.
     */
    protected $keyType = 'int';

    /**
     * The table associated with the model.
     */
    protected $table = 'booking';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id_penghuni',
        'id_teman',
        'id_kamar',
        'id_paket_kamar',
        'tanggal_mulai',
        'tanggal_selesai',
        'total_durasi',
        'status_booking',
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
     * Get the penghuni that owns the booking.
     */
    public function penghuni(): BelongsTo
    {
        return $this->belongsTo(Penghuni::class, 'id_penghuni');
    }

    /**
     * Get the secondary tenant (teman) for the booking.
     */
    public function teman(): BelongsTo
    {
        return $this->belongsTo(Penghuni::class, 'id_teman');
    }

    /**
     * Get the kamar that owns the booking.
     */
    public function kamar(): BelongsTo
    {
        return $this->belongsTo(Kamar::class, 'id_kamar');
    }

    /**
     * Get the paket kamar that owns the booking.
     */
    public function paketKamar(): BelongsTo
    {
        return $this->belongsTo(PaketKamar::class, 'id_paket_kamar');
    }

    /**
     * Get the pembayaran records for the booking.
     */
    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'id_booking');
    }

    /**
     * Check if booking is active
     */
    public function isActive(): bool
    {
        return $this->status_booking === 'Aktif';
    }

    /**
     * Check if booking has secondary tenant
     */
    public function hasSecondaryTenant(): bool
    {
        return !is_null($this->id_teman);
    }

    /**
     * Get formatted total duration with 3 decimal places
     */
    public function getFormattedTotalDurasi(): string
    {
        if (empty($this->total_durasi)) {
            return '-';
        }

        // Split the duration into number and unit (e.g., "1.5 bulan" -> ["1.5", "bulan"])
        $parts = explode(' ', $this->total_durasi);
        
        if (count($parts) >= 2 && is_numeric($parts[0])) {
            $number = (float) $parts[0];
            $unit = $parts[1];
            
            // Format number with 3 decimal places
            return number_format($number, 3, '.', '') . ' ' . $unit;
        }
        
        // Return as-is if format is not recognized
        return $this->total_durasi;
    }

    public function getRouteKeyName()
    {
        return 'id_booking';
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaketKamar extends Model
{
    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id_paket_kamar';

    /**
     * The table associated with the model.
     */
    protected $table = 'paket_kamar';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id_tipe_kamar',
        'jenis_paket',
        'kapasitas_kamar',
        'jumlah_penghuni',
        'harga',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'harga' => 'decimal:2',
        ];
    }

    /**
     * Get the tipe kamar that owns the paket kamar.
     */
    public function tipeKamar(): BelongsTo
    {
        return $this->belongsTo(TipeKamar::class, 'id_tipe_kamar');
    }

    /**
     * Get the booking records for the paket kamar.
     */
    public function booking(): HasMany
    {
        return $this->hasMany(Booking::class, 'id_paket_kamar');
    }

    public function getRouteKeyName()
    {
    return 'id_tipe_kamar';
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\HasImages;

class Kamar extends Model
{
    use HasFactory;
    use HasImages;

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id_kamar';

    /**
     * The table associated with the model.
     */
    protected $table = 'kamar';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id_tipe_kamar',
        'status',
        'no_kamar',
        'foto_kamar1',
        'foto_kamar2',
        'foto_kamar3',
        'deskripsi',
    ];

    /**
     * Get all photo URLs for the room
     *
     * @return array
     */
    public function getPhotoUrls()
    {
        return [
            'foto1' => $this->getImageUrl('foto_kamar1'),
            'foto2' => $this->getImageUrl('foto_kamar2'),
            'foto3' => $this->getImageUrl('foto_kamar3')
        ];
    }

    /**
     * Set room photos from request
     *
     * @param array $files
     * @return void
     */
    public function setRoomPhotos($files)
    {
        $attributes = [
            'foto1' => 'foto_kamar1',
            'foto2' => 'foto_kamar2',
            'foto3' => 'foto_kamar3'
        ];

        $this->setImages($files, $attributes);
    }

    /**
     * Get the tipe kamar that owns the kamar.
     */
    public function tipeKamar(): BelongsTo
    {
        return $this->belongsTo(TipeKamar::class, 'id_tipe_kamar');
    }

    /**
     * Get the booking records for the kamar.
     */
    public function booking(): HasMany
    {
        return $this->hasMany(Booking::class, 'id_kamar');
    }

    /**
     * Get the pengaduan records for the kamar.
     */
    public function pengaduan(): HasMany
    {
        return $this->hasMany(Pengaduan::class, 'id_kamar');
    }

    /**
     * Get the advance booking records for the kamar.
     */
    public function advanceBookings(): HasMany
    {
        return $this->hasMany(AdvanceBooking::class, 'id_kamar');
    }

    /**
     * Get the pembayaran records for the kamar.
     */
    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'id_kamar');
    }

    /**
     * Check if kamar is available
     */
    public function isAvailable(): bool
    {
        return $this->status === 'Kosong';
    }

    /**
     * Check if kamar is occupied
     */
    public function isOccupied(): bool
    {
        return $this->status === 'Terisi';
    }

    public function getRouteKeyName()
    {
    return 'id_tipe_kamar';
    }
}

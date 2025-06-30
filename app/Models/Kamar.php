<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
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
     * Get single photo URL
     *
     * @param string $field
     * @return string|null
     */
    public function getPhotoUrl($field)
    {
        return $this->getImageUrlFromBase64($field);
    }

    /**
     * Get all photo URLs for the room
     *
     * @return array
     */
    public function getPhotoUrls()
    {
        return [
            'foto1' => $this->getImageUrlFromBase64('foto_kamar1'),
            'foto2' => $this->getImageUrlFromBase64('foto_kamar2'),
            'foto3' => $this->getImageUrlFromBase64('foto_kamar3')
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
     * Get the booking records for the kamar (plural form).
     */
    public function bookings(): HasMany
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
     * Get the pembayaran records for the kamar.
     */
    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'id_kamar');
    }

    /**
     * Get the paket kamar for this room's type.
     */
    public function paketKamar()
    {
        return PaketKamar::where('id_tipe_kamar', $this->id_tipe_kamar);
    }

    /**
     * Get the paket kamar collection for this room's type.
     */
    public function getPaketKamarAttribute()
    {
        return PaketKamar::where('id_tipe_kamar', $this->id_tipe_kamar)->get();
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

    /**
     * Check if kamar has active bookings (currently occupied by tenants)
     */
    public function hasActiveBookings(): bool
    {
        return $this->bookings()
            ->where('status_booking', 'Aktif')
            ->where('tanggal_selesai', '>=', now())
            ->exists();
    }

    /**
     * Check if kamar is available for new booking
     */
    public function isAvailableForBooking(): bool
    {
        return $this->status === 'Kosong';
    }

    public function getRouteKeyName()
    {
        return 'id_kamar';
    }
}

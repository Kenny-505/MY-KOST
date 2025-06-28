<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipeKamar extends Model
{
    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id_tipe_kamar';

    /**
     * The data type of the auto-incrementing ID.
     */
    protected $keyType = 'int';

    /**
     * The table associated with the model.
     */
    protected $table = 'tipe_kamar';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'tipe_kamar',
        'fasilitas',
    ];

    /**
     * Get the kamar records for the tipe kamar.
     */
    public function kamar(): HasMany
    {
        return $this->hasMany(Kamar::class, 'id_tipe_kamar');
    }

    /**
     * Get the kamar records for the tipe kamar (plural alias).
     */
    public function kamars(): HasMany
    {
        return $this->hasMany(Kamar::class, 'id_tipe_kamar');
    }

    /**
     * Get the paket kamar records for the tipe kamar.
     */
    public function paketKamar(): HasMany
    {
        return $this->hasMany(PaketKamar::class, 'id_tipe_kamar');
    }

    /**
     * Get the paket kamar records for the tipe kamar (plural alias).
     */
    public function paketKamars(): HasMany
    {
        return $this->hasMany(PaketKamar::class, 'id_tipe_kamar');
    }

    public function getRouteKeyName()
    {
    return 'id_tipe_kamar';
    }
}

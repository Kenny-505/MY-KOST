<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasImages;

class Pengaduan extends Model
{
    use HasFactory;
    use HasImages;

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id_pengaduan';

    /**
     * The data type of the auto-incrementing ID.
     */
    protected $keyType = 'int';

    /**
     * The table associated with the model.
     */
    protected $table = 'pengaduan';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id_penghuni',
        'id_kamar',
        'judul_pengaduan',
        'isi_pengaduan',
        'status',
        'foto_pengaduan',
        'tanggal_pengaduan',
        'response_admin',
        'tanggal_response',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected $casts = [
        'tanggal_pengaduan' => 'datetime',
        'tanggal_response' => 'datetime',
    ];

    /**
     * Get the penghuni that owns the pengaduan.
     */
    public function penghuni(): BelongsTo
    {
        return $this->belongsTo(Penghuni::class, 'id_penghuni');
    }

    /**
     * Get the kamar that owns the pengaduan.
     */
    public function kamar(): BelongsTo
    {
        return $this->belongsTo(Kamar::class, 'id_kamar');
    }

    /**
     * Check if pengaduan is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'Menunggu';
    }

    /**
     * Check if pengaduan is in progress
     */
    public function isInProgress(): bool
    {
        return $this->status === 'Diproses';
    }

    /**
     * Check if pengaduan is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'Selesai';
    }

    /**
     * Check if pengaduan has admin response
     */
    public function hasResponse(): bool
    {
        return !is_null($this->response_admin);
    }

    /**
     * Get foto pengaduan for display (already base64 encoded)
     */
    public function getFotoPengaduanDisplayAttribute()
    {
        return $this->foto_pengaduan;
    }

    /**
     * Get complaint photo URL
     *
     * @return string|null
     */
    public function getPhotoUrl()
    {
        return $this->getImageUrl('foto_pengaduan');
    }

    /**
     * Set complaint photo from request
     *
     * @param \Illuminate\Http\UploadedFile|null $file
     * @return void
     */
    public function setComplaintPhoto($file)
    {
        $this->setImage($file, 'foto_pengaduan');
    }

    public function getRouteKeyName()
    {
        return 'id_pengaduan';
    }
}

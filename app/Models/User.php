<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_hp',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the penghuni records for the user.
     */
    public function penghuni(): HasMany
    {
        return $this->hasMany(Penghuni::class, 'id_user');
    }

    /**
     * Get the pembayaran records for the user.
     */
    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'id_user');
    }

    /**
     * Get the booking records for the user through penghuni.
     */
    public function bookings()
    {
        return $this->hasManyThrough(
            Booking::class,
            Penghuni::class,
            'id_user', // Foreign key on penghuni table
            'id_penghuni', // Foreign key on booking table
            'id', // Local key on users table
            'id_penghuni' // Local key on penghuni table
        );
    }

    /**
     * Get the advance booking records for the user.
     */
    public function advanceBookings(): HasMany
    {
        return $this->hasMany(AdvanceBooking::class, 'id_user');
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'Admin';
    }

    /**
     * Check if user has active penghuni status
     */
    // public function hasActivePenghuni(): bool
    // {
    //     return $this->penghuni()->where('status_penghuni', 'Aktif')->exists();
    // }

    public function hasActivePenghuni(): bool
    {
        return $this->penghuni()->where('status_penghuni', 'Aktif')->exists();
    }

    /**
     * Get the active penghuni record.
     */
    public function activePenghuni()
    {
        return $this->penghuni()->where('status_penghuni', 'Aktif')->first();
    }
}

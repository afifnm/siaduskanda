<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'nip_nisn',
        'unit',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    public function isPelapor(): bool
    {
        return $this->role === 'pelapor';
    }

    public function submittedPengaduans(): HasMany
    {
        return $this->hasMany(Pengaduan::class, 'user_id');
    }

    public function assignedPengaduans(): HasMany
    {
        return $this->hasMany(Pengaduan::class, 'petugas_id');
    }

    public function histories(): HasMany
    {
        return $this->hasMany(PengaduanHistory::class, 'user_id');
    }
}

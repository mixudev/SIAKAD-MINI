<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;

    /**
     * Guard name eksplisit, supaya konsisten dengan config/auth.php & Spatie.
     * Tetap pakai guard 'web' default karena kita hanya punya satu guard untuk semua role.
     */
    protected $guard_name = 'web';

    protected $fillable = [
        'identifier',
        'name',
        'password',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke profil mahasiswa (jika user ini berrole mahasiswa).
     */
    public function mahasiswa(): HasOne
    {
        return $this->hasOne(Mahasiswa::class);
    }

    /**
     * Relasi ke profil dosen (jika user ini berrole dosen).
     */
    public function dosen(): HasOne
    {
        return $this->hasOne(Dosen::class);
    }

    /**
     * Helper cepat cek role tanpa perlu ingat nama method Spatie.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isDosen(): bool
    {
        return $this->hasRole('dosen');
    }

    public function isMahasiswa(): bool
    {
        return $this->hasRole('mahasiswa');
    }
}

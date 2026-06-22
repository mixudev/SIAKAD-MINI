<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dosen extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nidn',
        'nama_lengkap',
        'gelar_depan',
        'gelar_belakang',
        'jenis_kelamin',
        'no_hp',
        'email',
        'alamat',
        'foto',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Semua kelas matkul yang pernah/sedang diampu dosen ini (lintas semester).
     */
    public function kelasMatkuls(): HasMany
    {
        return $this->hasMany(KelasMatkul::class);
    }

    /**
     * Nama lengkap dengan gelar, contoh: "Dr. Budi Santoso, S.Kom., M.Kom."
     */
    public function getNamaDenganGelarAttribute(): string
    {
        return trim("{$this->gelar_depan} {$this->nama_lengkap}, {$this->gelar_belakang}", ' ,');
    }
}

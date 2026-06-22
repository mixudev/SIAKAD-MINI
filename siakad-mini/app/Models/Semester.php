<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tahun_ajaran',
        'tipe',
        'tanggal_mulai',
        'tanggal_selesai',
        'krs_mulai',
        'krs_selesai',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'krs_mulai' => 'date',
            'krs_selesai' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function kelasMatkuls(): HasMany
    {
        return $this->hasMany(KelasMatkul::class);
    }

    public function krs(): HasMany
    {
        return $this->hasMany(Krs::class);
    }

    /**
     * Cek apakah periode pengisian KRS untuk semester ini sedang berjalan.
     */
    protected function krsSedangDibuka(): Attribute
    {
        return Attribute::get(function () {
            if (! $this->krs_mulai || ! $this->krs_selesai) {
                return false;
            }

            $now = now()->startOfDay();

            return $now->between($this->krs_mulai, $this->krs_selesai);
        });
    }

    /**
     * Ambil semester yang sedang aktif. Dipakai di banyak tempat (KRS, nilai, dashboard).
     */
    public static function aktif(): ?self
    {
        return static::where('is_active', true)->first();
    }
}

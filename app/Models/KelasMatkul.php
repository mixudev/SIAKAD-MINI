<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KelasMatkul extends Model
{
    use HasFactory;

    protected $table = 'kelas_matkuls';

    protected $fillable = [
        'mata_kuliah_id',
        'dosen_id',
        'semester_id',
        'nama_kelas',
        'kapasitas',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruangan',
    ];

    public function mataKuliah(): BelongsTo
    {
        return $this->belongsTo(MataKuliah::class);
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class);
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    public function krsDetails(): HasMany
    {
        return $this->hasMany(KrsDetail::class);
    }

    public function nilais(): HasMany
    {
        return $this->hasMany(Nilai::class);
    }

    /**
     * Jumlah mahasiswa yang sudah mengambil kelas ini (lewat KRS).
     */
    public function jumlahPeserta(): int
    {
        return $this->krsDetails()->count();
    }

    /**
     * Apakah kelas ini masih ada kuota tersisa.
     */
    public function masihAdaKuota(): bool
    {
        return $this->jumlahPeserta() < $this->kapasitas;
    }

    /**
     * Label tampilan ringkas, contoh: "Basis Data - Kelas A (Budi Santoso)"
     */
    public function getLabelAttribute(): string
    {
        return "{$this->mataKuliah->nama} - Kelas {$this->nama_kelas} ({$this->dosen->nama_lengkap})";
    }
}

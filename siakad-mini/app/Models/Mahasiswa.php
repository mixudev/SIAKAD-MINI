<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nim',
        'nama_lengkap',
        'angkatan',
        'program_studi',
        'jenis_kelamin',
        'status',
        'no_hp',
        'email',
        'alamat',
        'foto',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function krs(): HasMany
    {
        return $this->hasMany(Krs::class);
    }

    public function nilais(): HasMany
    {
        return $this->hasMany(Nilai::class);
    }

    /**
     * Ambil KRS mahasiswa ini untuk semester tertentu (default: semester aktif).
     */
    public function krsSemester(?Semester $semester = null): ?Krs
    {
        $semester ??= Semester::aktif();

        if (! $semester) {
            return null;
        }

        return $this->krs()->where('semester_id', $semester->id)->first();
    }

    /**
     * Hitung total SKS yang sudah lulus (nilai_huruf bukan E dan bukan null),
     * dipakai untuk transkrip / progress studi.
     */
    public function totalSksLulus(): int
    {
        return $this->nilais()
            ->whereNotNull('nilai_huruf')
            ->where('nilai_huruf', '!=', 'E')
            ->with('kelasMatkul.mataKuliah')
            ->get()
            ->sum(fn (Nilai $nilai) => $nilai->kelasMatkul->mataKuliah->sks);
    }
}

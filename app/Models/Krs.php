<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Krs extends Model
{
    use HasFactory;

    protected $table = 'krs';

    /**
     * Batas maksimal SKS yang boleh diambil dalam satu KRS.
     * Aturan tetap (belum progresif berdasar IP), sesuai keputusan awal project.
     */
    public const MAX_SKS = 24;

    protected $fillable = [
        'mahasiswa_id',
        'semester_id',
        'total_sks',
        'status',
        'disetujui_oleh',
        'diajukan_at',
        'disetujui_at',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'diajukan_at' => 'datetime',
            'disetujui_at' => 'datetime',
        ];
    }

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    public function disetujuiOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }

    public function details(): HasMany
    {
        return $this->hasMany(KrsDetail::class);
    }

    /**
     * Sisa kuota SKS yang masih boleh diambil mahasiswa di KRS ini.
     */
    public function sisaSks(): int
    {
        return max(0, self::MAX_SKS - $this->total_sks);
    }

    /**
     * Hitung ulang total_sks berdasarkan detail yang ada, lalu simpan.
     * Dipanggil setiap kali ada penambahan/penghapusan matkul dari KRS.
     */
    public function recalculateTotalSks(): void
    {
        $this->total_sks = $this->details()->sum('sks_diambil');
        $this->save();
    }
}

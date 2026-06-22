<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilais';

    /**
     * Bobot nilai akhir TETAP untuk semua matkul, sesuai keputusan awal project.
     * Total harus selalu 1.0 (100%).
     */
    public const BOBOT_TUGAS = 0.30;

    public const BOBOT_UTS = 0.30;

    public const BOBOT_UAS = 0.40;

    /**
     * Batas bawah nilai_akhir untuk setiap huruf. Dicek berurutan dari atas.
     */
    public const KONVERSI_HURUF = [
        85 => 'A',
        80 => 'A-',
        75 => 'B+',
        70 => 'B',
        65 => 'B-',
        60 => 'C+',
        55 => 'C',
        40 => 'D',
        0 => 'E',
    ];

    protected $fillable = [
        'mahasiswa_id',
        'kelas_matkul_id',
        'nilai_tugas',
        'nilai_uts',
        'nilai_uas',
        'nilai_akhir',
        'nilai_huruf',
        'diinput_oleh',
    ];

    protected function casts(): array
    {
        return [
            'nilai_tugas' => 'decimal:2',
            'nilai_uts' => 'decimal:2',
            'nilai_uas' => 'decimal:2',
            'nilai_akhir' => 'decimal:2',
        ];
    }

    /**
     * Setiap kali model disimpan, hitung ulang nilai_akhir & nilai_huruf
     * otomatis dari komponen tugas/UTS/UAS yang ada, supaya kedua kolom
     * itu tidak pernah perlu diisi manual dan selalu konsisten dengan bobot tetap.
     */
    protected static function booted(): void
    {
        static::saving(function (Nilai $nilai) {
            if ($nilai->nilai_tugas !== null && $nilai->nilai_uts !== null && $nilai->nilai_uas !== null) {
                $nilai->nilai_akhir = $nilai->hitungNilaiAkhir();
                $nilai->nilai_huruf = $nilai->konversiHuruf($nilai->nilai_akhir);
            }
        });
    }

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function kelasMatkul(): BelongsTo
    {
        return $this->belongsTo(KelasMatkul::class);
    }

    public function diinputOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diinput_oleh');
    }

    /**
     * Hitung nilai akhir dari bobot tetap: Tugas 30% + UTS 30% + UAS 40%.
     */
    public function hitungNilaiAkhir(): float
    {
        $tugas = (float) $this->nilai_tugas;
        $uts = (float) $this->nilai_uts;
        $uas = (float) $this->nilai_uas;

        $akhir = ($tugas * self::BOBOT_TUGAS)
            + ($uts * self::BOBOT_UTS)
            + ($uas * self::BOBOT_UAS);

        return round($akhir, 2);
    }

    /**
     * Konversi nilai angka (0-100) menjadi nilai huruf (A, A-, B+, ...).
     */
    public function konversiHuruf(?float $nilaiAkhir): ?string
    {
        if ($nilaiAkhir === null) {
            return null;
        }

        foreach (self::KONVERSI_HURUF as $batasBawah => $huruf) {
            if ($nilaiAkhir >= $batasBawah) {
                return $huruf;
            }
        }

        return 'E';
    }

    /**
     * Bobot mutu untuk perhitungan IP/IPK, dipakai bersama SKS matkul.
     */
    public function bobotMutu(): float
    {
        return match ($this->nilai_huruf) {
            'A' => 4.00,
            'A-' => 3.75,
            'B+' => 3.50,
            'B' => 3.00,
            'B-' => 2.75,
            'C+' => 2.50,
            'C' => 2.00,
            'D' => 1.00,
            'E' => 0.00,
            default => 0.00,
        };
    }
}

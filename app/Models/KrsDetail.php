<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KrsDetail extends Model
{
    use HasFactory;

    protected $table = 'krs_details';

    protected $fillable = [
        'krs_id',
        'kelas_matkul_id',
        'sks_diambil',
    ];

    public function krs(): BelongsTo
    {
        return $this->belongsTo(Krs::class);
    }

    public function kelasMatkul(): BelongsTo
    {
        return $this->belongsTo(KelasMatkul::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpkHasil extends Model
{
    use HasFactory;

    protected $table = 'spk_hasil';

    protected $fillable = [
        'sekolah_id',
        'periode_id',
        'skor',
        'peringkat',
        'kategori',
        'rincian',
        'dihitung_pada',
    ];

    protected $casts = [
        'skor' => 'decimal:5',
        'peringkat' => 'integer',
        'rincian' => 'array',
        'dihitung_pada' => 'datetime',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }
}

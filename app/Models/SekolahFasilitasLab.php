<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SekolahFasilitasLab extends Model
{
    use HasFactory;
    protected $table = 'sekolah_fasilitastik_lab';
    protected $fillable = [
        'sekolah_fasilitastik_id',
        'labkom_nama',
        'labkom_jumlah_pc',
    ];

    public function fasilitas()
    {
        return $this->belongsTo(SekolahFasilitas::class, 'sekolah_fasilitastik_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SekolahSosekbud extends Model
{
    use HasFactory;
    protected $table = 'sekolah_sosekbud';
    protected $fillable = [
        'sekolah_id',
        'kondisi_geografis',
        'kondisi_sosekbud',
        'akses_transportasi',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }
}

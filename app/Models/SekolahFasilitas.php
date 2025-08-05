<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SekolahFasilitas extends Model
{
    use HasFactory;
    protected $table = 'sekolah_fasilitastik';
    protected $fillable = [
        'sekolah_id',
        'listrik_status',
        'listrik_sumber',
        'listrik_durasi',
        'jumlah_kom',
        'labkom_status',
        'internet_status',
        'internet_sumber',
        'internet_bandwith',
        'topologi_jaringan',
        'internet_kesesuaian',
        'internet_alasankuota',
        'saran_pengembangan',
    ];

    public function SekolahFasilitasLab()
    {
        return $this->hasMany(SekolahFasilitasLab::class);
    }
}

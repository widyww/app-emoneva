<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SekolahBantuanDetail extends Model
{
    use HasFactory;
    protected $table = 'sekolah_bantuan_detail';
    protected $fillable = [
        'sekolah_bantuan_status_id',
        'nama_lembaga',
        'keterangan_bantuan',
    ];

    public function SekolahBantuanStatus()
    {
        return $this->belongsTo(SekolahBantuanStatus::class, 'sekolah_bantuan_status_id');
    }


    
}

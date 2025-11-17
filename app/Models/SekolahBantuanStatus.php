<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SekolahBantuanStatus extends Model
{
    use HasFactory;

    protected $table = 'sekolah_bantuan_status';

    protected $fillable = [
        'sekolah_id',
        'status',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }

    // detail bantuan
    public function details()
    {
        return $this->hasMany(SekolahBantuanDetail::class, 'sekolah_bantuan_status_id');
    }
}

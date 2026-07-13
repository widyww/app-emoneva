<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SawHasil extends Model
{
    protected $table = 'saw_hasil';

    protected $fillable = [
        'periode_id',
        'sekolah_id',
        'skor',
        'nilai_vi',
        'peringkat',
        'dihitung_pada',
    ];

    protected $casts = [
        'skor' => 'array',
        'nilai_vi' => 'float',
        'peringkat' => 'integer',
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

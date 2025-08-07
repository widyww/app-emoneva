<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruPelatihan extends Model
{
    use HasFactory;
    protected $table = 'guru_pelatihan';
    protected $fillable = [
        'guru_id',
        'nama_pelatihan',
        'tingkatan',
        'level',
        'tahun_pelatihan',
        'jam_pelatihan',
    ];


    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
}

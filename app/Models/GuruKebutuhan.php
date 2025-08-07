<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruKebutuhan extends Model
{
    use HasFactory;
    protected $table = 'guru_kebutuhan';
    protected $fillable = [
        'guru_id',
        'nama_pelatihan',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
}

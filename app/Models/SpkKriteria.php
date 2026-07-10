<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpkKriteria extends Model
{
    use HasFactory;

    protected $table = 'spk_kriteria';

    protected $fillable = [
        'kode',
        'nama',
        'bobot',
        'tipe',
        'aktif',
    ];

    protected $casts = [
        'bobot' => 'decimal:4',
        'aktif' => 'boolean',
    ];

    /**
     * Scope kriteria yang aktif dipakai dalam perhitungan SPK.
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;
    protected $table = 'sekolah';
    protected $fillable = [
        'npsn',
        'tingkatan',
        'nama',
        'alamat',
        'telepon',
        'email',
        'website',
        'sk_ijin',
        'status_sekolah',
        'status_akreditasi',
        'status_tanah',
        'jum_siswa_pria',
        'jum_siswa_wanita',
        'unbk_status',
        'unbk_tahun',
        'status_verifikasi',
        'keterangan_verifikasi',
        'kecamatan_id',
        'kota_id',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function sekolah_sosekbud()
    {
        return $this->hasOne(SekolahSosekbud::class, 'sekolah_id');
    }


    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function kota()
    {
        return $this->belongsTo(Kota::class);
    }

}

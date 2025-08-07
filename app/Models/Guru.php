<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $table = 'guru';
    protected $fillable = [
        'nama',
        'status',
        'nuptk',
        'nip',
        'tempat',
        'tgl_lahir',
        'agama',
        'jenis_kelamin',
        'pendidikan_terakhir',
        'tmt_pns_tahun',
        'telepon',
        'mapel',
        'sertifikasi_status',
        'sertifikasi_tahun',
        'sertifikasi_alasan',
        'kompetensi_word',
        'kompetensi_powerpoin',
        'kompetensi_excel',
        'kompetensi_pemrogramman',
        'kompetensi_jaringan',
        'kompetensi_multimedia',
        'pelatihan_status',
        'pelatihan_kebutuhan',
        
    ];

    public function gurukebutuhan()
    {
        return $this->hasMany(GuruKebutuhan::class);
    }

    public function gurupelatihan()
    {
        return $this->hasMany(GuruPelatihan::class);
    }
}

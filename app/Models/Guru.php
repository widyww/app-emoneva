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
        'kompetensi_jaringan',      // ✅ tambahkan
        'kompetensi_multimedia',    // ✅ tambahkan
        'pelatihan_status',
        'pelatihan_kebutuhan',
        'sekolah_id',
        'status_verifikasi',
        'catatan_verifikasi',

    ];

    public function pelatihan()
    {
        return $this->hasMany(GuruPelatihan::class); // sesuaikan nama model & foreign key
    }

    public function kebutuhanPelatihan()
    {
        return $this->hasMany(GuruKebutuhan::class); // sesuaikan nama model & foreign key
    }
   
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id', 'id');
    }

    
}

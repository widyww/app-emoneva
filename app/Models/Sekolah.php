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
        'foto_sekolah',
        'tingkatan',
        'nama',
        'alamat',
        'telepon',
        'email',
        'website',
        'sk_ijin',
        'kepsek_nama',
        'kepsek_hp',
        'kepsek_foto',
        'status_sekolah',
        'status_akreditasi',
        'status_tanah',
        'jum_siswa_pria',
        'jum_siswa_wanita',
        'jum_guru',
        'unbk_status',
        'unbk_tahun',
        'status_verifikasi',
        'keterangan_verifikasi',
        'kecamatan_id',
        'kota_id',
    ];

    public function labKomputers()
    {
        return $this->fasilitas()->with('labs');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function fasilitas()
    {
        // Pastikan nama model 'SekolahFasilitas' sesuai dengan nama file/class yang akan Anda buat
        return $this->hasOne(SekolahFasilitas::class, 'sekolah_id');
    }


    // STATUS
    public function bantuanStatus()
    {
        return $this->hasOne(SekolahBantuanStatus::class, 'sekolah_id');
    }

    // DETAIL (via status)
    public function bantuanDetails()
    {
        return $this->hasMany(SekolahBantuanDetail::class, 'sekolah_bantuan_status_id', 'id');
    }

    public function sekolah_sosekbud()
    {
        return $this->hasOne(SekolahSosekbud::class, 'sekolah_id');
    }

    /**
     * Nilai baku status_verifikasi untuk sekolah yang DISETUJUI verifikator.
     * (Lihat VerifikasiProsesController@update: 2 = Disetujui, 3 = Ditolak.)
     * Dipakai SPK agar hanya sekolah terverifikasi yang ikut perhitungan.
     */
    public const STATUS_VERIFIKASI_DISETUJUI = '2';

    public function scopeTerverifikasi($query)
    {
        return $query->where('status_verifikasi', self::STATUS_VERIFIKASI_DISETUJUI);
    }

    public function spkHasil()
    {
        return $this->hasMany(SpkHasil::class, 'sekolah_id');
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

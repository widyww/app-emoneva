<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    use HasFactory;
    protected $table = 'kota';
    protected $fillable = ['nama'];

    public function kecamatan()
    {
        return $this->hasMany(Kecamatan::class);
    }
    public function sekolah()
    {
        return $this->hasMany(Sekolah::class);
    }
}

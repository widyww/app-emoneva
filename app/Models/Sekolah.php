<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;
    protected $table = 'sekolah';
    protected $fillable = ['npsn','nama','tingkatan','alamat','phone','email','website','sk_ijin','status','akreditasi'];
}

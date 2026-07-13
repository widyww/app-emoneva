<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AhpPerbandingan extends Model
{
    protected $table = 'ahp_perbandingan';

    protected $fillable = ['periode_id', 'kriteria_baris_id', 'kriteria_kolom_id', 'nilai'];

    protected $casts = ['nilai' => 'float'];
}

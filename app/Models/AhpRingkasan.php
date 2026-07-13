<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AhpRingkasan extends Model
{
    protected $table = 'ahp_ringkasan';

    protected $fillable = [
        'periode_id',
        'lambda_maks',
        'ci',
        'ri',
        'cr',
        'konsisten',
        'dihitung_pada',
    ];

    protected $casts = [
        'lambda_maks' => 'float',
        'ci' => 'float',
        'ri' => 'float',
        'cr' => 'float',
        'konsisten' => 'boolean',
        'dihitung_pada' => 'datetime',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AhpBobot extends Model
{
    protected $table = 'ahp_bobot';

    protected $fillable = ['periode_id', 'kriteria_id', 'bobot'];

    protected $casts = ['bobot' => 'float'];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }
}

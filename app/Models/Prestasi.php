<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    protected $table = 't_prestasi';
    protected $guarded = ['id'];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'id_alumni');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TracerCompetence extends Model
{
    protected $table = 't_tracer_competence';
    protected $guarded = ['id'];

    public function main()
    {
        return $this->belongsTo(TracerMain::class, 'id_tracer_main');
    }
}
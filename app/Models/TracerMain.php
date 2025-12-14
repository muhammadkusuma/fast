<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TracerMain extends Model
{
    protected $table = 't_tracer_main';
    protected $guarded = ['id'];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'id_alumni');
    }

    // Relasi One-to-One ke tabel detail
    public function process()
    {
        return $this->hasOne(TracerProcess::class, 'id_tracer_main');
    }

    public function competence()
    {
        return $this->hasOne(TracerCompetence::class, 'id_tracer_main');
    }

    public function evaluation()
    {
        return $this->hasOne(TracerEvaluation::class, 'id_tracer_main');
    }
}
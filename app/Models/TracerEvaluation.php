<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TracerEvaluation extends Model
{
    protected $table = 't_tracer_evaluation';
    protected $guarded = ['id'];

    public function main()
    {
        return $this->belongsTo(TracerMain::class, 'id_tracer_main');
    }
}
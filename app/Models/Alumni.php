<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Foundation\Auth\User as Authenticatable; // Jika alumni login pakai tabel ini

class Alumni extends Authenticatable
{
    protected $table = 'm_alumni';
    protected $guarded = ['id'];
    
    // Sembunyikan password saat return JSON
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi');
    }

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class, 'id_alumni');
    }

    public function tracerMain()
    {
        return $this->hasMany(TracerMain::class, 'id_alumni');
    }
}
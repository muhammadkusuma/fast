<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    protected $table = 'm_fakultas';
    protected $guarded = ['id'];

    public function prodi()
    {
        return $this->hasMany(Prodi::class, 'id_fakultas');
    }
}
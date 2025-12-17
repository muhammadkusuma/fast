<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TracerStudy extends Model
{
    use HasFactory;

    protected $table = 'tracer_studies';

    // Kita gunakan guarded id agar semua kolom lain bisa diisi (mass assignment)
    // tanpa perlu menuliskan fillable satu per satu yang sangat panjang.
    protected $guarded = ['id'];

    /**
     * Relasi ke Alumni / User
     * Sesuaikan 'Alumni::class' dengan nama Model user Anda.
     */
    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'user_id');
    }
}

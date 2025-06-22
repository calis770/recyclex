<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class LevelAkun extends Authenticatable
{
    use HasFactory;

    protected $table = 'level_akun';
    protected $primaryKey = 'id_level';

    protected $fillable = [
        'nama_level',
        'deskripsi',
    ];

    // Relasi ke akun
    public function akuns()
    {
        return $this->hasMany(Akun::class, 'id_level', 'id_level');
    }
}
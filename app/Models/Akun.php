<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\LevelAkun;

class Akun extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'akun';
    protected $primaryKey = 'id_akun';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_akun',
        'id_level',
        'phone',
        'name',
        'email',
        'password',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',        // Add this line
        'updated_at' => 'datetime',        // Add this line
        'password' => 'hashed',
    ];

    // Method untuk cek role
    public function isAdmin()
    {
        return $this->id_level == 1;
    }

    public function isCustomer()
    {
        return $this->id_level == 2;
    }

    // Relasi ke level
    public function level()
    {
        return $this->belongsTo(LevelAkun::class, 'id_level', 'id_level');
    }

    // Method untuk mendapatkan nama role
    public function getRoleName()
    {
        return $this->level->nama_level ?? 'Unknown';
    }

    // Optional: Add accessor for safe date formatting
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at ? $this->created_at->format('d F Y, H:i') : 'N/A';
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return $this->updated_at ? $this->updated_at->format('d F Y, H:i') : 'N/A';
    }
}
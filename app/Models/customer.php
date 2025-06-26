<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Assuming Customer can log in
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable // Or just Model if not directly login-able
{
    use HasFactory, Notifiable;

    protected $table = 'customer'; // Your customer table name
    protected $primaryKey = 'customer_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'customer_id',
        'customer_name',
        'email',
        'password',
        // other customer fields
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // If customer is also a user that logs in, implement these
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'customer_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $primaryKey = 'product_id';
    public $incrementing = false; // Add this line if product_id is not auto-incrementing
    protected $keyType = 'string'; // Add this line if product_id is a char/string
    public $timestamps = true; // Set to true to use timestamps based on your migration

    protected $fillable = [
        'product_id',
        'product_name',
        'price',
        'rating',
        'image_product',
        'sold',
        'description',
        'variasi',
        'category',
        'umkm',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'rating' => 'decimal:1',
        'sold' => 'integer',
        'created_at' => 'datetime', // Cast timestamps for consistency
        'updated_at' => 'datetime', // Cast timestamps for consistency
    ];
}
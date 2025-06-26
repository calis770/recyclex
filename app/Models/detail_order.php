<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    use HasFactory;

    protected $table = 'detail_orders'; // Ensure this matches your migration table name
    protected $primaryKey = 'detail_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'detail_id',
        'order_id',
        'product_id',
        'quantity',
        'price_at_order', // Add this to save the product price at the time of order
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
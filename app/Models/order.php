<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';
    public $incrementing = false; // Disable auto-incrementing for custom string ID
    protected $keyType = 'string'; // Set key type to string

    protected $fillable = [
        'order_id',
        'customer_id',
        'payment_id',
        'order_date',
        'total_price',
        'subtotal',
        'tax_amount',
        'status',
        'status_info',
    ];

    // Define the relationship with Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    // Define the relationship with Payment
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'payment_id');
    }

    // Define the relationship with DetailOrder
    public function detailOrders()
    {
        return $this->hasMany(DetailOrder::class, 'order_id', 'order_id');
    }

    // Method to get status options
    public static function getStatusOptions()
    {
        return [
            'PACKED' => 'Packed',
            'SENT' => 'Sent',
            'DONE' => 'Done',
            'CANCELLED' => 'Cancelled',
        ];
    }

    // Accessor for human-readable status label (optional, but good for display)
    public function getStatusLabelAttribute()
    {
        return self::getStatusOptions()[$this->status] ?? $this->status;
    }

    // Mutator for default status_info if not provided
    public function getStatusInfoAttribute($value)
    {
        if ($value) {
            return $value;
        }

        switch ($this->status) {
            case 'PACKED':
                return 'Pesanan sedang disiapkan dan dikemas.';
            case 'SENT':
                return 'Pesanan telah dikirim.';
            case 'DONE':
                return 'Pesanan telah selesai dan diterima.';
            case 'CANCELLED':
                return 'Pesanan telah dibatalkan.';
            default:
                return 'Informasi status tidak tersedia.';
        }
    }
}
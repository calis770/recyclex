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
        'order_date',
        'total_price',
        'status',
        'merchant_name',
        'product_name',
        'product_description',
        'product_image',
        'quantity',
        'unit_price',
        'status_info',
        'nama_penerima',
        'nomor_hp',
        'alamat_penerima',
        'kota_penerima',
        'kode_pos_penerima',
        'provinsi',
        'note_pengiriman',
        'payment_method',
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'total_price' => 'integer',
        'quantity' => 'integer',
        'unit_price' => 'integer',
    ];

    // Method to get status options
    public static function getStatusOptions()
    {
        return [
            'UNPAID' => 'Unpaid',
            'PACKED' => 'Packed',
            'SENT' => 'Sent',
            'DONE' => 'Done',
            'CANCELLED' => 'Cancelled',
        ];
    }

    // Accessor for human-readable status label
    public function getStatusLabelAttribute()
    {
        return self::getStatusOptions()[$this->status] ?? $this->status;
    }

    // Accessor for default status_info if not provided
    public function getStatusInfoAttribute($value)
    {
        if ($value) {
            return $value;
        }

        switch ($this->status) {
            case 'UNPAID':
                return 'Pesanan belum dibayar.';
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

    // Helper method to get full recipient address
    public function getFullAddressAttribute()
    {
        return "{$this->alamat_penerima}, {$this->kota_penerima}, {$this->provinsi} {$this->kode_pos_penerima}";
    }

    // Helper method to calculate total from unit price and quantity
    public function calculateTotal()
    {
        return $this->unit_price * $this->quantity;
    }
}
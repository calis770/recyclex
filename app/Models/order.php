<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table      = 'orders';
    protected $primaryKey = 'order_id';
    public    $incrementing = false;   // karena order_id bertipe char(5)
    protected $keyType    = 'string';

    /**
     * Kolom yang boleh di‑mass‑assign.
     * Pastikan seluruh kolom di migration tercantum di sini.
     */
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

    /**
     * Casting kolom agar otomatis menjadi instance Carbon.
     */
    protected $casts = [
        'order_date' => 'datetime',
    ];

    /* ===== accessor/helper ===== */

    public static function getStatusOptions(): array
    {
        return [
            'UNPAID'    => 'Belum Dibayar',
            'PACKED'    => 'Dikemas',
            'SENT'      => 'Dikirim',
            'DONE'      => 'Selesai',
            'CANCELLED' => 'Dibatalkan',
        ];
    }

    /**
     * label_status → $order->status_label
     */
    public function getStatusLabelAttribute(): string
    {
        return self::getStatusOptions()[$this->status] ?? $this->status;
    }

    /**
     * formatted_price → $order->formatted_price
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    /**
     * status_info → jika kolom belum terisi, isi otomatis berdasarkan status.
     */
    public function getStatusInfoAttribute($value): string
    {
        if ($value) {
            return $value;
        }

        return match ($this->status) {
            'UNPAID'    => 'Menunggu pembayaran dari pelanggan',
            'PACKED'    => 'Pesanan sedang dikemas oleh penjual',
            'SENT'      => 'Pesanan dalam perjalanan ke alamat tujuan',
            'DONE'      => 'Pesanan telah sampai dan selesai',
            'CANCELLED' => 'Pesanan dibatalkan',
            default     => '',
        };
    }
}

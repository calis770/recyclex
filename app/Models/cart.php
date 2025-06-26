<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';
    protected $primaryKey = 'id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_cart',
        'product_id',
        'quantity',
        'variation',
        'total_price',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'integer',
        'total_price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the product associated with the cart item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    /**
     * Get formatted total price
     */
    public function getFormattedTotalPriceAttribute()
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    /**
     * Get formatted unit price
     */
    public function getFormattedUnitPriceAttribute()
    {
        if ($this->quantity > 0) {
            $unitPrice = $this->total_price / $this->quantity;
            return 'Rp ' . number_format($unitPrice, 0, ',', '.');
        }
        return 'Rp 0';
    }

    /**
     * Scope to get cart items with products
     */
    public function scopeWithProduct($query)
    {
        return $query->with('product');
    }

    /**
     * Scope to get cart items by product
     */
    public function scopeByProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    /**
     * Scope to get cart items by variation
     */
    public function scopeByVariation($query, $variation)
    {
        return $query->where('variation', $variation);
    }

    /**
     * Check if cart item has variation
     */
    public function hasVariation()
    {
        return !empty($this->variation);
    }

    /**
     * Get display name with variation
     */
    public function getDisplayNameAttribute()
    {
        $name = $this->product ? $this->product->product_name : 'Unknown Product';
        
        if ($this->hasVariation()) {
            $name .= ' (' . $this->variation . ')';
        }
        
        return $name;
    }

    /**
     * Calculate total price based on quantity and product price
     */
    public function calculateTotalPrice()
    {
        if ($this->product && $this->quantity > 0) {
            return $this->product->price * $this->quantity;
        }
        return 0;
    }

    /**
     * Update total price automatically
     */
    public function updateTotalPrice()
    {
        $this->total_price = $this->calculateTotalPrice();
        $this->save();
        return $this;
    }
}
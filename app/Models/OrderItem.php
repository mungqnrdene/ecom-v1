<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * OrderItem Model
 * 
 * Захиалгын дэд зүйлүүдийг хадгалдаг.
 * Жишээ: ORD-001 захиалгад iPhone 15 (2шт) + iPad (1шт).
 */
class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_variant_id',
        'product_name',
        'price_at_purchase',
        'quantity',
        'subtotal',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}

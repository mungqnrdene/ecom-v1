<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ProductVariant Model
 * 
 * Барааны төрөлүүдийг хадгалдаг.
 * Жишээ: iPhone 15 - Blue 256GB, Red 512GB гэх мэт.
 * Арил төрөл бүр өөр үнэ, сток байж болно.
 */
class ProductVariant extends Model
{
    protected $fillable = ['product_id', 'name', 'sku', 'price_modifier', 'stock_quantity', 'low_stock_threshold'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}

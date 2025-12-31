<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ProductImage Model
 * 
 * Барааны зургуудыг хадгалдаг.
 * Нэг барааны олон зураг байж болно (үндсэн зураг, дэлгэрэнгүй зураг).
 */
class ProductImage extends Model
{
    protected $fillable = ['product_id', 'image_path', 'is_primary', 'order'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

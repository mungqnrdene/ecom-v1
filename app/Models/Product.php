<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'category_id', 'description', 'keywords', 'admin_id', 'image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    // Барааны зургууд
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Барааны төрөлүүд (өнгө, хэмжээ гэх мэт)
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    // Захиалгадаа байсан зүйлүүд
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function wishlistItems()
    {
        return $this->hasMany(WishlistItem::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Cart Model
 * 
 * Хэрэглэгчийн сагсыг хадгалдаг.
 * Хэрэглэгч захиалга гаргахын өмнө сагсанд бараа нэмдэг.
 */
class Cart extends Model
{
    protected $fillable = ['user_id', 'total_items', 'total_price', 'expires_at'];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}

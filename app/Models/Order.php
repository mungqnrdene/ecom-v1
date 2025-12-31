<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Order Model
 * 
 * Хэрэглэгчийн захиалгуудыг хадгалдаг.
 * Нэг захиалга олон дэд зүйл (OrderItem) болж болно.
 */
class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'payment_status',
        'subtotal',
        'shipping_cost',
        'tax',
        'total_amount',
        'shipping_address',
        'phone',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}

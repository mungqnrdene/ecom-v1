<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Payment Model
 * 
 * Захиалгын төлбөрийн мэдээлэлийг хадгалдаг.
 * Нэг захиалга олон төлбөр байж болно (хэсэгт төлөх).
 */
class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'payment_method',
        'status',
        'amount',
        'transaction_id',
        'reference_number',
        'admin_id',
        'response_data',
        'paid_at'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'response_data' => 'array', // JSON лүү хөрвүүлэх
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}

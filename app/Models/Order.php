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
        'payment_method',
        'subtotal',
        'shipping_cost',
        'tax',
        'total_amount',
        'shipping_address',
        'phone',
        'notes',
        'refunded_at',
    ];

    protected $casts = [
        'refunded_at' => 'datetime',
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

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Check if order can be refunded (within 5 minutes)
     */
    public function canRefund()
    {
        if ($this->status === 'refunded') {
            return false;
        }

        $refundDeadline = $this->created_at->copy()->addMinutes(5);
        return now()->lessThanOrEqualTo($refundDeadline);
    }

    /**
     * Get remaining refund time in seconds
     */
    public function getRefundTimeRemaining()
    {
        if (!$this->canRefund()) {
            return 0;
        }

        $refundDeadline = $this->created_at->copy()->addMinutes(5);
        return max(0, now()->diffInSeconds($refundDeadline, false));
    }
}

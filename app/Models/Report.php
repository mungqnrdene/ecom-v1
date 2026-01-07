<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_type',
        'start_date',
        'end_date',
        'new_users_count',
        'total_orders_count',
        'total_sales_amount',
        'refunded_orders_count',
        'refunded_amount',
        'daily_orders',
        'sold_products',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'daily_orders' => 'array',
        'sold_products' => 'array',
        'total_sales_amount' => 'decimal:2',
        'refunded_amount' => 'decimal:2',
    ];

    /**
     * Get report for specific period
     */
    public static function getOrCreateReport($periodType, $startDate, $endDate)
    {
        return self::firstOrCreate(
            [
                'period_type' => $periodType,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ],
            [
                'new_users_count' => 0,
                'total_orders_count' => 0,
                'total_sales_amount' => 0,
                'refunded_orders_count' => 0,
                'refunded_amount' => 0,
                'daily_orders' => [],
                'sold_products' => [],
            ]
        );
    }

    /**
     * Get current period report
     */
    public static function getCurrentReport($periodType = '10_days')
    {
        if ($periodType === 'monthly') {
            $startDate = now()->startOfMonth();
            $endDate = now()->endOfMonth();
        } else {
            $startDate = now()->subDays(9)->startOfDay(); // Last 10 days including today
            $endDate = now()->endOfDay();
        }

        return self::getOrCreateReport($periodType, $startDate, $endDate);
    }
}

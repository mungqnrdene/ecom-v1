<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'card_holder',
        'card_last_four',
        'card_brand',
        'expiry_month',
        'expiry_year',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Card belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get masked card number for display
     */
    public function getMaskedCardNumberAttribute()
    {
        return '**** **** **** ' . $this->card_last_four;
    }

    /**
     * Check if card is expired
     */
    public function isExpired()
    {
        $expiry = "{$this->expiry_year}-{$this->expiry_month}-01";
        return now()->startOfMonth()->greaterThan($expiry);
    }
}

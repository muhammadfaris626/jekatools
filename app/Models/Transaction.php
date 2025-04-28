<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'merchant_ref', 'reference', 'amount', 'fee_merchant', 'fee_customer', 'total_fee', 'amount_received', 'payment_method', 'payment_url', 'status'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product(): BelongsTo {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function licenses(): HasMany {
        return $this->hasMany(License::class);
    }

    public function referralBonuses(): HasMany {
        return $this->hasMany(ReferralBonus::class);
    }
}

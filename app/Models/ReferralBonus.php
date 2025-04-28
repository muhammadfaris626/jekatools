<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReferralBonus extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_id', 'user_id', 'referred_user_id', 'amount'];

    public function transaction(): BelongsTo {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function referredUser(): BelongsTo {
        return $this->belongsTo(User::class, 'referred_user_id');
    }
}

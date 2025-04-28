<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'price', 'desc', 'duration_days', 'stock'];

    public function accountItems(): HasMany {
        return $this->hasMany(AccountItem::class);
    }

    public function transactions(): HasMany {
        return $this->hasMany(Transaction::class);
    }

    public function licenses(): HasMany {
        return $this->hasMany(License::class);
    }
}

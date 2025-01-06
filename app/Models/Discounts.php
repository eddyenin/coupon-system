<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Discounts extends Model
{
    /** @use HasFactory<\Database\Factories\DiscountsFactory> */
    use HasFactory;

    public function coupon():HasMany
    {
        return $this->hasMany(Coupon::class);
    }

    public function discountRule():BelongsToMany
    {
        return $this->belongsToMany(Discounts::class);
    }
}

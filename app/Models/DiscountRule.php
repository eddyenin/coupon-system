<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DiscountRule extends Model
{
    /** @use HasFactory<\Database\Factories\DiscountRuleFactory> */
    use HasFactory;

    public function discount():BelongsToMany
    {
        return $this->belongsToMany(Discounts::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'is_active'];
    protected $appends = ['subtotal', 'tax', 'total'];

    /**
     * Get the user that owns the cart.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items in the cart.
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
    
    /**
     * Get the subtotal for the cart.
     */
    public function getSubtotalAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }
    
    /**
     * Get the tax for the cart.
     */
    public function getTaxAttribute()
    {
        return $this->subtotal * 0.1;
    }
    
    /**
     * Get the total for the cart.
     */
    public function getTotalAttribute()
    {
        return $this->subtotal + $this->tax;
    }
}

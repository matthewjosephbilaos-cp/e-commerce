<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Pivot
{
    use HasFactory;

    protected $table = 'customer_product';

    protected $fillable = [
        'customer_id',
        'product_id',
        'quantity',
        'status'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    // Relationship to Product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

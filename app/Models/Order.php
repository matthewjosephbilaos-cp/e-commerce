<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

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
}

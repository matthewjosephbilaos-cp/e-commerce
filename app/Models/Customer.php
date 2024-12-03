<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Address;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function productsOrdered() : BelongsToMany {
        return $this->belongsToMany(Product::class)
            ->using(Order::class)
            ->withPivot(['quantity', 'status']);
    }

    public function address() : MorphOne {
        return $this->morphOne(Address::class, 'addressable');
    }
}

<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Order;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'description',
        'quantity',
        'inStock',
        'published',
        'price',
        'image',
        'url',
    ];

    public function brand() {
        return $this->belongsTo(Brand::class);
    }


    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function productCustomers() : BelongsToMany {
        return $this->belongsToMany(Customer::class)
            ->using(Order::class)
            ->withPivot(['quantity', 'status']);
    }

}

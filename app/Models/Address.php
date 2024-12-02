<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Address extends MorphPivot
{

    public $incrementing = true;

    protected $table = 'addresses';

    protected $fillable = [
        'addressable_id',
        'addressable_type',
        'street',
        'barangay',
        'city',
        'country',
        'postal_code'
    ];

    public function addressable() : MorphTo {
        return $this->morphTo();
    }
}

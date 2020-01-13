<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $guarded = [];

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'address_customer');
    }
}

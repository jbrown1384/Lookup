<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'customer_role');
    }
}

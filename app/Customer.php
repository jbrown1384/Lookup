<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($customer) {
            $roles = Role::all();
            $loop = rand(1, 5);
            for ($i = 0; $i < $loop; $i++) {
                $role = Role::find($roles[rand(0, 4)]);
                $customer->roles()->toggle($role);
            }

            $addresses = Address::all();
            $loop = rand(1, 3);
            for ($i = 0; $i < $loop; $i++) {
                $address = Address::find($addresses[rand(0, 29)]);
                $customer->addresses()->toggle($address);
            }
        });
    }

    public function addresses()
    {
        return $this->belongsToMany(Address::class, 'address_customer')->orderBy('address', 'ASC');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'customer_role')->orderBy('name', 'ASC');
    }
}

<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function show(Customer $customer)
    {
        $customerDetails = [
            'customer' => $customer,
            'addresses' => $customer->addresses,
            'roles' => $customer->roles,
        ];
        // $customer = Customer::find($customer);
        return response()->json($customerDetails);
    }
}

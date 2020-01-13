<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('lookup.index');
    }

    /**
     * Validates Customer object and retrieves customer data
     *
     * @param Customer $customer
     * @return Response
     */
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

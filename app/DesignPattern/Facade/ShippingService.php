<?php

namespace App\DesignPattern\Facade;


use App\Models\Shipping;
use Illuminate\Support\Facades\Session;

class ShippingService
{
    public function saveShippingDetails($request)
    {
        $shipping = new Shipping();
        $shipping->name = $request->name;
        $shipping->email = $request->email;
        $shipping->phone_no = $request->phone_no;
        $shipping->address = $request->address;
        $shipping->save();

        Session::put('shipping_id', $shipping->id);
        Session::put('customer_name', $shipping->name);

        return $shipping;
    }
}
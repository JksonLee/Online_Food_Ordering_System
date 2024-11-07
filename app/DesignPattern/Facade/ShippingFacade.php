<?php

namespace App\DesignPattern\Facade;

use Illuminate\Support\Facades\Facade;

class ShippingFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'shippingService';
    }
}

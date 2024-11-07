<?php

namespace App\DesignPattern\Facade;

use Illuminate\Support\Facades\Facade;

class CustomerFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'customerService';
    }
}
<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\DesignPattern\Observer\CartObserver; // Correct namespace
use App\DesignPattern\Observer\Event\DishAdded;
use App\DesignPattern\Observer\Event\DishUpdated;
use App\DesignPattern\Observer\Event\DishRemoved;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        DishAdded::class => [
            CartObserver::class . '@handleAddDish',
        ],
        DishUpdated::class => [
            CartObserver::class . '@handleUpdateDish',
        ],
        DishRemoved::class => [
            CartObserver::class . '@handleRemoveDish',
        ],
   
        ];

    public function boot()
    {
      parent::boot();
    }
}

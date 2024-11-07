<?php

namespace App\Providers;

use App\Models\category;
use Illuminate\Support\ServiceProvider;

use App\DesignPattern\Factory\CategoryFactory;
use App\DesignPattern\Factory\CategoryFactoryInterface;
use App\DesignPattern\Factory\DeliverBoyFactory;
use App\DesignPattern\Factory\DeliverBoyFactoryInterface;
use App\DesignPattern\Factory\CouponFactory;
use App\DesignPattern\Factory\CouponFactoryInterface;
use App\DesignPattern\Factory\DishFactoryInterface;
use App\DesignPattern\Factory\DishFactory;
use App\DesignPattern\Factory\OrderFactoryInterface;
use App\DesignPattern\Factory\OrderFactory;
use App\DesignPattern\Facade\CustomerService;
use App\DesignPattern\Facade\ShippingService;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
//        Factory
      $this->app->bind(CategoryFactoryInterface::class, CategoryFactory::class);
      $this->app->bind(DeliverBoyFactoryInterface::class, DeliverBoyFactory::class);
     $this->app->bind(CouponFactoryInterface::class, CouponFactory::class);
       $this->app->bind(DishFactoryInterface::class, DishFactory::class);
         $this->app->bind(OrderFactoryInterface::class, OrderFactory::class);
     
         //Facade
        $this->app->bind('customerService', function ($app) {
            return new CustomerService();
        });

        $this->app->bind('shippingService', function ($app) {
            return new ShippingService();
        });   
         
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
      View::composer('FrontEnd.include.banner',function($view)
      {
              
        $view->with('categories',category::where('category_status',1)->get());      
              
    });
     View::composer('FrontEnd.include.dish',function($view)
      {
              
        $view->with('categories',category::where('category_status',1)->get());      
              
    });
    
}

}

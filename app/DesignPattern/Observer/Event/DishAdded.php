<?php

namespace App\DesignPattern\Observer\Event;

class DishAdded {
   
    public $dishId;
    public $qty;

    public function __construct($dishId, $qty)
    {
        $this->dishId = $dishId;
        $this->qty = $qty;
    }
}


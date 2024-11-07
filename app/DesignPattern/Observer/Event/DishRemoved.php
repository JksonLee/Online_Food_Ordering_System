<?php

namespace App\DesignPattern\Observer\Event;

class DishRemoved 
{
    public $rowId;

    public function __construct($rowId)
    {
        $this->rowId = $rowId;
    }
}
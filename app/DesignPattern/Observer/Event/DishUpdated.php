<?php

namespace App\DesignPattern\Observer\Event;

class DishUpdated
{
    public $rowId;
    public $qty;

    public function __construct($rowId, $qty)
    {
        $this->rowId = $rowId;
        $this->qty = $qty;
    }
}

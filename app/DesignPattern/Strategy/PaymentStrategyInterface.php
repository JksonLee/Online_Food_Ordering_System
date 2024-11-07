<?php

namespace App\DesignPattern\Strategy;

use Illuminate\Http\Request;

interface PaymentStrategyInterface {
    
    public function pay($order,$cartContent,Request $request = null);
       public function redirectAfterSelection(); // Add this method
 }

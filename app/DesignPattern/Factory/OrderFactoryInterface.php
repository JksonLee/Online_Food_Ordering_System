<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPInterface.php to edit this template
 */

namespace App\DesignPattern\Factory;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;


interface OrderFactoryInterface {
 public function manageOrder();
    public function viewOrder(int $orderId):View;
    public function viewInvoice(int $orderId):View;
    public function downloadInvoice(int $orderId);
    public function deleteOrder(int $orderId): void;
}

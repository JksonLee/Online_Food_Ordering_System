<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPInterface.php to edit this template
 */

namespace App\DesignPattern\Factory;

use App\Models\DeliverBoy;

interface DeliverBoyFactoryInterface
{
    public function getAddDeveliverBoyPage();
    public function createBoy(array $data): DeliverBoy;
    public function updateBoy(int $deliveryBoyId, array $data): DeliverBoy;
    public function activateBoy(int $deliveryBoyId): DeliverBoy;
    public function deactivateBoy(int $deliveryBoyId): DeliverBoy;
    public function deleteBoy(int $deliveryBoyId): void;
    public function getAllBoys();
}

<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\DesignPattern\Factory;

use App\Models\DeliverBoy;


class DeliverBoyFactory implements DeliverBoyFactoryInterface
{
     public function getAddDeveliverBoyPage() {
        return view('BackEnd.deliveryBoy.add'); // Adjust the view path as needed
    }
    
    public function createBoy(array $data): DeliverBoy
    {
        
        $boy = new DeliverBoy($data);
        $boy->save();
        return $boy;
    }

    public function updateBoy(int $deliveryBoyId, array $data): DeliverBoy
    {
        $boy = DeliverBoy::findOrFail($deliveryBoyId);
        $boy->update($data);
        return $boy;
    }

    public function activateBoy(int $deliveryBoyId): DeliverBoy
    {
        $boy = DeliverBoy::findOrFail($deliveryBoyId);
        $boy->delivery_boy_status = 1;
        $boy->save();
        return $boy;
    }

    public function deactivateBoy(int $deliveryBoyId): DeliverBoy
    {
        $boy = DeliverBoy::findOrFail($deliveryBoyId);
        $boy->delivery_boy_status = 0;
        $boy->save();
        return $boy;
    }

    public function deleteBoy(int $deliveryBoyId): void
    {
        $boy = DeliverBoy::findOrFail($deliveryBoyId);
        $boy->delete();
    }

    public function getAllBoys()
    {
        return DeliverBoy::all();
    }
}

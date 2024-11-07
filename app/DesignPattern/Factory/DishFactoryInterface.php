<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPInterface.php to edit this template
 */

namespace App\DesignPattern\Factory;

use App\Models\Dish;
use Illuminate\Http\Request;

interface DishFactoryInterface {
      public function getAddDishPage();
    public function createDish(Request $request): Dish;
    public function updateDish(int $dishId, Request $request): Dish;
    public function activateDish(int $dishId): Dish;
    public function deactivateDish(int $dishId): Dish;
    public function deleteDish(int $dishId): void;
    public function getAllDishes();
}

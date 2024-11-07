<?php

namespace App\DesignPattern\Factory;

use App\Models\Dish;
use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DishFactory implements DishFactoryInterface
{
    public function getAddDishPage()
    {
        return view('BackEnd.dish.add', [
            'categories' => category::where('category_status', 1)->get()
        ]);
    }

    public function createDish(Request $request): Dish
    {
        $imgName = $request->file('dish_image');
        $image = $imgName->getClientOriginalName();
        $directory = 'BackEndSourceFile/dish_img/';
        $imgUrl = $directory . $image;
        $imgName->move($directory, $image);

        $dish = new Dish();
        $dish->dish_name = $request->dish_name;
        $dish->category_id = $request->category_id;
        $dish->dish_detail = $request->dish_detail;
        $dish->dish_image = $imgUrl;
        $dish->dish_status = $request->dish_status;
        $dish->full_price = $request->full_price;
        $dish->half_price = $request->half_price;
        $dish->save();

        return $dish;
    }

    public function updateDish(int $dishId, Request $request): Dish
    {
        $dish = Dish::find($dishId);

        if ($request->hasFile('dish_image')) {
            $img_main = $request->file('dish_image');
            $img_name = $img_main->getClientOriginalName();
            $directory = 'BackEndSourceFile/dish_img/';
            $imgUrl = $directory . $img_name;
            $img_main->move($directory, $img_name);

            $old_img = $dish->dish_image;
            if (file_exists($old_img)) {
                unlink($old_img);
            }

            $dish->dish_image = $imgUrl;
        }

        $dish->dish_name = $request->dish_name;
        $dish->category_id = $request->category_id;
        $dish->dish_detail = $request->dish_detail;
        $dish->full_price = $request->full_price;
        $dish->half_price = $request->half_price;
        $dish->save();

        return $dish;
    }

    public function activateDish(int $dishId): Dish
    {
        $dish = Dish::find($dishId);
        $dish->dish_status = 1;
        $dish->save();

        return $dish;
    }

    public function deactivateDish(int $dishId): Dish
    {
        $dish = Dish::find($dishId);
        $dish->dish_status = 0;
        $dish->save();

        return $dish;
    }

    public function deleteDish(int $dishId): void
    {
        $dish = Dish::find($dishId);
        $dish->delete();
    }

    public function getAllDishes()
    {
        return DB::table('dishes')
            ->join('categories', 'dishes.category_id', '=', 'categories.category_id')
            ->select('dishes.*', 'categories.category_name')
            ->get();
    }
}

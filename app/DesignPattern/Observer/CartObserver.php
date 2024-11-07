<?php

namespace App\DesignPattern\Observer;

use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Dish;
use App\Models\Coupon;
use App\DesignPattern\Observer\CartObserver;
use Illuminate\Support\Facades\Session;

class CartObserver
{
    
    
    public function handleAddDish($dishId, $qty)
    {
        $dish = Dish::where('dish_id', $dishId)->first();

        Cart::add([
            'id' => $dishId,
            'qty' => $qty,
            'name' => $dish->dish_name,
            'price' => $dish->full_price,
            'weight' => 550,
            'options' => [
                'half_price' => $dish->half_price,
                'image' => $dish->dish_image,
            ],
        ]);
    }

    public function handleUpdateDish($rowId, $qty)
    {
        Cart::update($rowId, $qty);
    } 

    public function handleRemoveDish($rowId)
    {
        Cart::remove($rowId);
    }
    
 public function applyCoupon($couponCode)
    {
        // Find the coupon in the database
        $coupon = Coupon::where('coupon_code', $couponCode)->first();

        if (!$coupon) {
            return ['error' => 'Invalid coupon code.'];
        }

        // Check if the coupon is expired
        $currentDate = now();
        if ($coupon->expired_on < $currentDate) {
            return ['error' => 'This coupon has expired.'];
        }

        // Convert Cart subtotal to a float (removing commas)
        $cartTotalFormatted = Cart::subtotal();  // Example: "31,350.00"
        $cartTotal = floatval(str_replace(',', '', $cartTotalFormatted));  

    
        
        // Check if the cart meets the minimum value for the coupon
        if ($cartTotal < $coupon->cart_min_value) {
            return ['error' => 'Cart total is less than the minimum required for this coupon.'];
        }

        // Corrected discount calculation based on coupon type
        if ($coupon->coupon_type == 1) {
            // Percentage discount
            $discount = ($cartTotal * ($coupon->coupon_value / 100));  // Ensure percentage is divided by 100
         
        } else {
            // Fixed discount
            $discount = $coupon->coupon_value;
            
        }

      
        
      Session::put('coupon', [
    'code' => $coupon->coupon_code,
    'value' => $coupon->coupon_value,
    'type' => $coupon->coupon_type,  // Store the coupon type to check if it's percentage or fixed
    'discount' => $discount, // Store the actual calculated discount
]);
      

        
        return [
            'success' => 'Coupon applied successfully. You saved RM ' . number_format($discount, 2),
            'discount' => $discount
        ];
        
        
    
    }
   
}
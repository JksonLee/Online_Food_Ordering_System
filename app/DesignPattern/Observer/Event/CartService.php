<?php


namespace App\DesignPattern\Observer\Event;


use App\DesignPattern\Observer\Event\DishAdded;
use App\DesignPattern\Observer\Event\DishUpdated;
use App\DesignPattern\Observer\Event\DishRemoved;
use Illuminate\Http\Request;
use App\Models\Dish;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartService
{
    
    protected $cartObserver;
    
      public function __construct(\App\DesignPattern\Observer\CartObserver $cartObserver)
    {
        // Initialize the cartObserver property
        $this->cartObserver = $cartObserver;
    }
    
public function addDish($dishId, $qty)
{
    $dish = Dish::find($dishId);
    $cartItem = Cart::add([
        'id' => $dishId,
        'name' => $dish->dish_name,
        'qty' => $qty,
        'price' => $dish->full_price,
        'options' => [
            'image' => $dish->dish_image,
            'half_price' => $dish->half_price
        ]
    ]);
    
    $rowId = $cartItem->rowId;

    // Optionally, store $rowId in session or another persistent storage if needed
    session()->put('cart_item_' . $dishId, $rowId);

    event(new DishAdded($dishId, $qty));
}

public function updateDish($rowId, $qty)
{
    if (Cart::get($rowId)) {
        Cart::update($rowId, $qty);
        event(new DishUpdated($rowId, $qty));
    } else {
        // Log the error or provide more details
        \Log::error('Update failed: Cart does not contain rowId', ['rowId' => $rowId]);
        throw new \Exception('The cart does not contain this item.');
    }
}

public function removeDish($rowId)
{
    if (Cart::get($rowId)) {
        Cart::remove($rowId);
        event(new DishRemoved($rowId));
    } else {
        // Log the error or provide more details
        \Log::error('Remove failed: Cart does not contain rowId', ['rowId' => $rowId]);
        throw new \Exception('The cart does not contain this item.');
    }
}

public function getCartContents()
    {
        return Cart::content(); // Fetch cart items directly
    }

 public function clearCart()
    {
        Cart::destroy(); // Clears all items from the cart
    }
    
      public function applyCouponToCart($couponCode)
    {
        return $this->cartObserver->applyCoupon($couponCode);
    }
    
}
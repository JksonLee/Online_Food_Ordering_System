<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DesignPattern\Observer\Event\CartService;
use App\DesignPattern\Observer\CartObserver;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function applyCoupon(Request $request)
    {
        // Create the CartService with CartObserver injected
        $cartService = new CartService(new CartObserver());

        // Get the coupon code from the request input
        $couponCode = $request->input('coupon_code');

        // Call the CartService to apply the coupon
        $response = $cartService->applyCouponToCart($couponCode);

        // Debugging the response
        // This will stop the execution here and show the response

        // If you want to debug the session data, comment out the previous dd() and use this one instead:
        // dd(Session::get('coupon'));  // Check if the session is storing the coupon data

        // Check the response and redirect accordingly
        if (isset($response['error'])) {
            return redirect()->back()->with('error', $response['error']);
        } else {
            return redirect()->back()->with('success', $response['success']);
        }
    }
    
    
    public function removeCoupon(Request $request)
{
    // Remove the coupon from the session
    if (Session::has('coupon')) {
        Session::forget('coupon');
    }

    // Redirect back to the cart page with a success message
    return redirect()->back()->with('success', 'Coupon removed successfully.');
}
    
}

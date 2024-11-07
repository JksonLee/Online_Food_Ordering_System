<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\DesignPattern\Observer\CartObserver;

class CouponController extends Controller
{
  public function applyCoupon(Request $request)
    {
        // Create the CartService with CartObserver injected
        $cartService = new CartService(new CartObserver());

        // Get the coupon code from the request input
        $couponCode = $request->input('coupon_code');

        // Call the CartService to apply the coupon
        $response = $cartService->applyCouponToCart($couponCode);

        // Check the response and redirect accordingly
        if (isset($response['error'])) {
            return redirect()->back()->with('error', $response['error']);
        } else {
            return redirect()->back()->with('success', $response['success']);
        }
    }
}

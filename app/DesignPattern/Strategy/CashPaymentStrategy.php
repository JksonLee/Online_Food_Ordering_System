<?php


namespace App\DesignPattern\Strategy;

use App\Models\OrderDetail;
use App\Models\payment;
use Cart;
use Session;
use Illuminate\Http\Request;

class CashPaymentStrategy implements PaymentStrategyInterface
{
 
     public function pay($order, $cartContent,Request $request = null)
    {
        $payment = new Payment();
        $payment->order_id = $order->order_id;
        $payment->payment_type = 'Cash';
        $payment->customer_id = Session::get('customer_id');
        $payment->save();

        foreach ($cartContent as $cart) {
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $order->order_id;
            $orderDetail->dish_id = $cart->id;
            $orderDetail->dish_name = $cart->name;
            $orderDetail->dish_price = (float) ($cart->price ?? $cart->full_price); 
            $orderDetail->dish_qty = $cart->qty;
            $orderDetail->save();
        }
        
           Cart::destroy();
        Session::flash('success', 'Your order has been successfully processed.');

        return $payment;
        
    }
    
       public function redirectAfterSelection()
    {
        // Redirect to order confirmation page or any other page for Cash payment
        return redirect()->route('order_complete');
    }
    
    
}

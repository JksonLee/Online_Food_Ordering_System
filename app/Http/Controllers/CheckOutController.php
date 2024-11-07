<?php namespace App\Http\Controllers;

use Session;
use App\Models\payment;
use App\Models\OrderDetail;
use App\Models\CheckOut;
use Cart;

use App\Models\Order;
use App\Models\Shipping;
use Illuminate\Http\Request;

class CheckOutController extends Controller
{
  
    public function payment()
    {
    
        return view('FrontEnd.checkOut.checkout_payment');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function order(Request $request)
    {
        $paymentType = $request->payment_type;

        if($paymentType == 'Cash')
        {
           
            $order = new Order();
            $order->customer_id = Session::get('customer_id');
          $order->shipping_id = Session::get('shipping_id');
            $order->order_total = Session::get('sum');
            $order->save();
            
            $payMent = new payment();
            $payMent->order_id = $order->order_id;
            $payMent->payment_type = $paymentType ;
            $payMent->save();
            
            
            $CartDish = Cart::content();
            
            foreach($CartDish as $cart)
            {
           $orderDetail = new OrderDetail();
           $orderDetail->order_id = $order->order_id;
           $orderDetail->dish_id = $cart->id;
           $orderDetail->dish_name = $cart->name;
           if($cart->half_price == null)
           {
             $orderDetail->dish_price = $cart->price;  
           }
           elseif($cart->half_price !== null)
           {
             $orderDetail->dish_price = $cart->price; 
             $orderDetail->dish_price = $cart->half_price; 
           }
           $orderDetail->dish_qty = $cart->qty;
           $orderDetail->save();
           }
            
           Cart::destroy();
               Session::flash('success','Your order has been successfully processed.');
            
           return redirect('checkout/order/complete');
         
           
          
            
        }
        elseif($paymentType == 'Stripe')
        {
           
                $order = new Order();
            $order->customer_id = Session::get('customer_id');
          $order->shipping_id = Session::get('shipping_id');
            $order->order_total = Session::get('sum');
            $order->save();
            
            $payMent = new payment();
            $payMent->order_id = $order->order_id;
            $payMent->payment_type = $paymentType ;
            $payMent->save();
            
            
            $CartDish = Cart::content();
            
            foreach($CartDish as $cart)
            {
           $orderDetail = new OrderDetail();
           $orderDetail->order_id = $order->order_id;
           $orderDetail->dish_id = $cart->id;
           $orderDetail->dish_name = $cart->name;
           if($cart->half_price == null)
           {
             $orderDetail->dish_price = $cart->price;  
           }
           elseif($cart->half_price !== null)
           {
             $orderDetail->dish_price = $cart->price; 
             $orderDetail->dish_price = $cart->half_price; 
           }
           $orderDetail->dish_qty = $cart->qty;
           $orderDetail->save();
           }
            
           Cart::destroy();
            
         return redirect('/stripe-payment');
           
        }
        
    }

//    public function stripe()
//    {
//        return view('FrontEnd.checkOut.stripe');
//    }
    
    public function complete()
    {
       return view('FrontEnd.checkOut.order_complete');
    }

    /**
     * Display the specified resource.
     */
    public function show(CheckOut $checkOut)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CheckOut $checkOut)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CheckOut $checkOut)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CheckOut $checkOut)
    {
        //
    }
}

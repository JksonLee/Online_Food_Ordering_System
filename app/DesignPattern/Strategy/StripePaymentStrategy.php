<?php
namespace App\DesignPattern\Strategy;

use Stripe\Stripe;
use Stripe\Charge;
use Cart;
use App\Models\OrderDetail;
use App\Models\Payment;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class StripePaymentStrategy implements PaymentStrategyInterface
{
    public function pay($order, $cartContent, Request $request = null)
    {
        // Set Stripe API key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Retrieve Stripe token and order details
        $stripeToken = $request->input('stripeToken');
        $orderTotal = $request->input('grandTotal'); // Ensure grandTotal is in cents
        $orderDescription = $request->input('name');

        if (!$stripeToken) {
            // Handle the error if token is missing
            return redirect()->back()->withErrors('No Stripe token provided.');
        }

        try {
            // Create Stripe charge
            $charge = Charge::create([
                "amount" => $orderTotal * 100,
                "currency" => "myr",
                "source" => $stripeToken,
                "description" => $orderDescription
            ]);

            // Save payment information
            $payment = new Payment();
            $payment->order_id = $order->order_id;
            $payment->payment_type = 'Stripe';
            $payment->customer_id = Session::get('customer_id');
            $payment->save();

            // Save order details
            foreach ($cartContent as $cart) {
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->order_id;
                $orderDetail->dish_id = $cart->id;
                $orderDetail->dish_name = $cart->name;
                $orderDetail->dish_price = $cart->price ?? $cart->full_price ;
                $orderDetail->dish_qty = $cart->qty;
                $orderDetail->save();
            }

            // Clear the cart and set success message
            Cart::destroy();
            Session::flash('success', 'Your order has been successfully processed.');

            // Log successful payment
            \Log::info('Payment successful, redirecting to order complete');
            return redirect()->route('order_complete');
            
        } catch (\Exception $e) {
            // Handle errors
            return redirect()->back()->withErrors('Payment failed: ' . $e->getMessage());
        }
    }

    public function redirectAfterSelection()
    {
        // This method may not be needed if Stripe handles its own redirection
        return redirect()->route('order_complete');
    }
}

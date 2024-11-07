<?php



namespace App\DesignPattern\Strategy;

use App\Models\Order;
use App\DesignPattern\Strategy\CashPaymentStrategy;
use App\DesignPattern\Strategy\StripePaymentStrategy;
use Cart;
use Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PaymentService
{
    public function processOrder(Request $request, $paymentType)
    {
        $order = new Order();
        $order->customer_id = Session::get('customer_id');
        $order->shipping_id = Session::get('shipping_id');
        $orderTotal = Session::get('sum', 0); // Default to 0 if not set
        $order->order_total = (float) $orderTotal;
        $order->save();

        $cartContent = Cart::content();

        
        
        // Select the payment strategy based on payment type
        $paymentStrategy = match ($paymentType) {
            'Cash' => new CashPaymentStrategy(),
            'Stripe' => new StripePaymentStrategy(),
            default => throw new \Exception('Unsupported payment type'),
        };

        // Execute the payment strategy and return its response
        return $paymentStrategy->pay($order, $cartContent, $request);
    }
}
<?php

namespace App\DesignPattern\Factory;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Shipping;
use App\Models\Payment;
use App\Models\OrderDetail;
use Illuminate\View\View;
use PDF;
use DB;

class OrderFactory implements OrderFactoryInterface
{
    public function manageOrder()
    {
        $orders = DB::table('orders')
            ->join('customers', 'orders.customer_id', '=', 'customers.customer_id')
            ->join('payments', 'orders.order_id', '=', 'payments.order_id')
            ->select('orders.*', 'customers.name', 'payments.payment_type', 'payments.order_status')
            ->get();

        return view('BackEnd.Order.manage', compact('orders'));
    }

    public function viewOrder(int $orderId):View
    {
        $order = Order::find($orderId);
        $customer = Customer::find($order->customer_id);
        $shipping = Shipping::find($order->shipping_id);
        $payment = Payment::where('order_id', $order->order_id)->first();
        $order_details = OrderDetail::where('order_id', $order->order_id)->get();

        return view('BackEnd.Order.view_order', compact('order', 'customer', 'shipping', 'payment', 'order_details'));
    }

    public function viewInvoice(int $orderId):View
    {
        $order = Order::find($orderId);
        $customer = Customer::find($order->customer_id);
        $shipping = Shipping::find($order->shipping_id);
        $payment = Payment::where('order_id', $order->order_id)->first();
        $order_details = OrderDetail::where('order_id', $order->order_id)->get();

        return view('BackEnd.Order.view_order_invoice', compact('order', 'customer', 'shipping', 'payment', 'order_details'));
    }

    public function downloadInvoice(int $orderId)
    {
        $order = Order::find($orderId);
        $customer = Customer::find($order->customer_id);
        $shipping = Shipping::find($order->shipping_id);
        $payment = Payment::where('order_id', $order->order_id)->first();
        $order_details = OrderDetail::where('order_id', $order->order_id)->get();

        $pdf = PDF::loadView('BackEnd.Order.download_invoice', compact('order', 'customer', 'shipping', 'payment', 'order_details'));

        return $pdf->stream('OrderInvoice.pdf');
    }

    public function deleteOrder(int $orderId):void
    {
        $order = Order::find($orderId);
        $order->delete();

      
    }
}

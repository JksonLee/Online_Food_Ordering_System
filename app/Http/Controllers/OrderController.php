<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Shipping;
use App\Models\payment;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use PDF;
use DB;

class OrderController extends Controller
{
    
  public function showOrderXML()
    {
     // Fetch the orders with all the necessary data
    $orders = DB::table('orders')
                ->join('customers', 'orders.customer_id', '=', 'customers.customer_id')
                ->leftJoin('payments', 'orders.order_id', '=', 'payments.order_id')
                ->select(
                    'orders.order_id', 
                    'customers.name as customer_name', 
                    'orders.order_total', 
                    'orders.order_status', 
                    'orders.created_at as order_date', 
                    'payments.payment_type', 
                    'payments.order_status as payment_status'
                )
                ->get();

        // Generate XML structure
        $xmlData = $this->generateOrderXML($orders);

            $xsltData = $this->applyXsltTransformation($xmlData, 'order'); // 'order' XSLT
        
        // Return the XML response with appropriate headers
        return response($xmlData, 200)
                 ->header('Content-Type', 'application/xml');
        
    }

    
    
    
    /**
     * Transform the XML orders data using XSLT
     */
    public function transformOrderXSLT()
    {
        // Fetch the orders with all the necessary data
    $orders = DB::table('orders')
                ->join('customers', 'orders.customer_id', '=', 'customers.customer_id')
                ->leftJoin('payments', 'orders.order_id', '=', 'payments.order_id')
                ->select(
                    'orders.order_id', 
                    'customers.name as customer_name', 
                    'orders.order_total', 
                    'orders.order_status', 
                    'orders.created_at as order_date', 
                    'payments.payment_type', 
                    'payments.order_status as payment_status'
                )
                ->get();
        $xmlData = $this->generateOrderXML($orders);

        // Apply XSLT transformation to the generated XML
        $xsltData = $this->applyXsltTransformation($xmlData, 'order'); // 'order' XSLT

        // Return the transformed HTML response
        return response($xsltData, 200)->header('Content-Type', 'text/html');
    }

    /**
     * Generate the XML for orders
     * @param \Illuminate\Database\Eloquent\Collection $orders
     * @return string
     */
  private function generateOrderXML($orders)
{
    // Initialize XML structure with root element <orders>
    $xml = new \SimpleXMLElement('<orders/>');

    // Loop through each order and add data as XML
    foreach ($orders as $order) {
        $orderElement = $xml->addChild('order');
        $orderElement->addChild('order_id', $order->order_id);
        $orderElement->addChild('customer_name', $order->customer_name);
        $orderElement->addChild('order_total', $order->order_total);
        $orderElement->addChild('order_status', $order->order_status);
        $orderElement->addChild('order_date', $order->order_date);
        $orderElement->addChild('payment_type', $order->payment_type);
        $orderElement->addChild('payment_status', $order->payment_status);
    }

    // Convert the SimpleXMLElement object to a string
    $xmlString = $xml->asXML();

    // Add the DOCTYPE declaration with the DTD link
    $xmlStringWithDTD = str_replace(
        '<?xml version="1.0"?>',
        '<?xml version="1.0"?>' . "\n" . '<!DOCTYPE orders SYSTEM "order.dtd">',
        $xmlString
    );

    // Return the XML string with the DTD reference
    return $xmlStringWithDTD;
}

    /**
     * Apply XSLT transformation to XML data
     * @param string $xmlData - The raw XML data
     * @param string $type - The type of XSLT file (order, payment, etc.)
     * @return string - Transformed HTML
     */
   private function applyXsltTransformation($xmlData, $type)
{
    // Update the path to point to the correct location of the XSLT file
    $xslPath = resource_path("views/BackEnd/xslt/{$type}.xsl"); // Use resource_path instead of base_path

    // Check if the file exists to avoid any path-related issues
    if (!file_exists($xslPath)) {
        die("XSLT file not found at: " . realpath($xslPath));
    }

    // Load the XSLT file
    $xslt = new \XSLTProcessor();
    $xsl = new \DOMDocument();
    $xsl->load($xslPath); // Corrected: use $xslPath instead of storage_path

    // Load the XML data to be transformed
    $xml = new \DOMDocument();
    $xml->loadXML($xmlData);

    // Attach the XSLT stylesheet to the processor
    $xslt->importStylesheet($xsl);

    // Transform the XML into HTML and return
    return $xslt->transformToXML($xml);
}


 public function downloadOrderXML()
    {
        // Fetch the orders with all the necessary data
        $orders = DB::table('orders')
                    ->join('customers', 'orders.customer_id', '=', 'customers.customer_id')
                    ->leftJoin('payments', 'orders.order_id', '=', 'payments.order_id')
                    ->select(
                        'orders.order_id', 
                        'customers.name as customer_name', 
                        'orders.order_total', 
                        'orders.order_status', 
                        'orders.created_at as order_date', 
                        'payments.payment_type', 
                        'payments.order_status as payment_status'
                    )
                    ->get();

        // Generate XML structure
        $xmlData = $this->generateOrderXML($orders);

        // Return the XML response with appropriate headers for download
        return response()->stream(
            function () use ($xmlData) {
                echo $xmlData;
            },
            200,
            [
                'Content-Type' => 'application/xml',
                'Content-Disposition' => 'attachment; filename="orders.xml"',
            ]
        );
    }



}
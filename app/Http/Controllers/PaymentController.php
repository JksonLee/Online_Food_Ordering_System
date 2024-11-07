<?php

namespace App\Http\Controllers;

use App\Models\payment;
use Illuminate\Http\Request;
use DB;

class PaymentController extends Controller
{
   /**
     * Display a listing of payments in XML format.
     */
    public function showPaymentsXML()
    {
        // Fetch payments with all the necessary data
        $payments = DB::table('payments')
                       ->join('orders', 'payments.order_id', '=', 'orders.order_id')
                       ->join('customers', 'orders.customer_id', '=', 'customers.customer_id')
                       ->select('payments.id as payment_id', 'payments.payment_type', 'orders.order_id', 'orders.order_total', 'customers.customer_id', 'customers.name as customer_name', 'customers.email as customer_email')
                       ->get();

        // Generate XML structure
        $xmlData = $this->generatePaymentsXML($payments);

        // Return the XML response with appropriate headers
        return response($xmlData, 200)
                    ->header('Content-Type', 'application/xml');
    }

    /**
     * Apply XSLT transformation to XML payment data.
     */
    public function transformPaymentsXSLT()
    {
        // Fetch payments with all the necessary data
        $payments = DB::table('payments')
                       ->join('orders', 'payments.order_id', '=', 'orders.order_id')
                       ->join('customers', 'orders.customer_id', '=', 'customers.customer_id')
                       ->select('payments.id as payment_id', 'payments.payment_type', 'orders.order_id', 'orders.order_total', 'customers.customer_id', 'customers.name as customer_name', 'customers.email as customer_email')
                       ->get();

        // Generate XML
        $xmlData = $this->generatePaymentsXML($payments);

        // Apply XSLT transformation to the generated XML
        $xsltData = $this->applyXsltTransformation($xmlData, 'payment');

        // Return the transformed HTML response
        return response($xsltData, 200)
                    ->header('Content-Type', 'text/html');
    }

    /**
     * Generate the XML for payments.
     * @param \Illuminate\Support\Collection $payments
     * @return string
     */
    private function generatePaymentsXML($payments)
    {
        // Initialize XML structure with root element <payments>
        $xml = new \SimpleXMLElement('<payments/>' );

        // Loop through each payment and add data as XML
        foreach ($payments as $payment) {
            $paymentElement = $xml->addChild('payment');
            $paymentElement->addChild('payment_id', $payment->payment_id);
            $paymentElement->addChild('payment_type', $payment->payment_type);
            $paymentElement->addChild('order_id', $payment->order_id);
            $paymentElement->addChild('order_total', $payment->order_total);
            $paymentElement->addChild('customer_id', $payment->customer_id);
            $paymentElement->addChild('customer_name', $payment->customer_name);
            $paymentElement->addChild('customer_email', $payment->customer_email);
        }

        // Return the XML as a string
        return $xml->asXML();
    }

    /**
     * Apply XSLT transformation to XML data.
     * @param string $xmlData - The raw XML data
     * @param string $type - The type of XSLT file (payment, etc.)
     * @return string - Transformed HTML
     */
    private function applyXsltTransformation($xmlData, $type)
    {
        // Update the path to point to the correct location of the XSLT file
        $xslPath = resource_path("views/BackEnd/xslt/{$type}.xsl");

        // Check if the file exists to avoid any path-related issues
        if (!file_exists($xslPath)) {
            die("XSLT file not found at: " . realpath($xslPath));
        }

        // Load the XSLT file
        $xslt = new \XSLTProcessor();
        $xsl = new \DOMDocument();
        $xsl->load($xslPath);

        // Load the XML data to be transformed
        $xml = new \DOMDocument();
        $xml->loadXML($xmlData);

        // Attach the XSLT stylesheet to the processor
        $xslt->importStylesheet($xsl);

        // Pass the current date as a parameter
        $xslt->setParameter('', 'currentDate', '2024-09-15'); // Date only for contains check
        
        // Transform the XML into HTML and return
        return $xslt->transformToXML($xml);
    }
    
     public function downloadPaymentXML()
    {
        // Fetch the payment data
        $payments = DB::table('payments')
                       ->join('orders', 'payments.order_id', '=', 'orders.order_id')
                       ->join('customers', 'orders.customer_id', '=', 'customers.customer_id')
                       ->select('payments.id as payment_id', 'payments.payment_type', 'orders.order_id', 'orders.order_total', 'customers.customer_id', 'customers.name as customer_name', 'customers.email as customer_email')
                       ->get();

        // Generate XML structure
        $xmlData = $this->generatePaymentsXML($payments);

        // Return the XML response with appropriate headers for download
        return response()->stream(
            function () use ($xmlData) {
                echo $xmlData;
            },
            200,
            [
                'Content-Type' => 'application/xml',
                'Content-Disposition' => 'attachment; filename="payments.xml"',
            ]
        );
    }
    
}
<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Mail;
use Session;
use DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function showCustomerXML()
    {
        // Fetch customers with all the necessary data
        $customers = DB::table('customers')
                        ->select('customer_id', 'name', 'email', 'phone_no', 'created_at')
                        ->get();

        // Generate XML structure
        $xmlData = $this->generateCustomerXML($customers);

        // Return the XML response with appropriate headers
        return response($xmlData, 200)
                    ->header('Content-Type', 'application/xml');
    }

    /**
     * Apply XSLT transformation to XML customer data
     */
    public function transformCustomerXSLT()
    {
        // Fetch customers with all the necessary data
        $customers = DB::table('customers')
                        ->select('customer_id', 'name', 'email', 'phone_no', 'created_at')
                        ->get();

        // Generate XML
        $xmlData = $this->generateCustomerXML($customers);

        // Apply XSLT transformation to the generated XML
        $xsltData = $this->applyXsltTransformation($xmlData, 'customer');

        // Return the transformed HTML response
        return response($xsltData, 200)
                    ->header('Content-Type', 'text/html');
    }

    /**
     * Generate the XML for customers
     * @param \Illuminate\Database\Eloquent\Collection $customers
     * @return string
     */
    private function generateCustomerXML($customers)
    {
        // Initialize XML structure with root element <customers>
        $xml = new \SimpleXMLElement('<customers/>');

        // Loop through each customer and add data as XML
        foreach ($customers as $customer) {
            $customerElement = $xml->addChild('customer');
            $customerElement->addChild('customer_id', $customer->customer_id);
            $customerElement->addChild('name', $customer->name);
            $customerElement->addChild('email', $customer->email);
            $customerElement->addChild('phone_no', $customer->phone_no);
            $customerElement->addChild('created_at', $customer->created_at);
        }

        // Return the XML as a string
        return $xml->asXML();
    }

    /**
     * Apply XSLT transformation to XML data
     * @param string $xmlData - The raw XML data
     * @param string $type - The type of XSLT file (customer, etc.)
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

 public function downloadCustomerXML()
    {
        // Fetch the customer data
        $customers = DB::table('customers')->get();

        // Generate XML structure
        $xmlData = $this->generateCustomerXML($customers);

        // Return the XML response with appropriate headers for download
        return response()->stream(
            function () use ($xmlData) {
                echo $xmlData;
            },
            200,
            [
                'Content-Type' => 'application/xml',
                'Content-Disposition' => 'attachment; filename="customers.xml"',
            ]
        );
    }

    
    
    
}
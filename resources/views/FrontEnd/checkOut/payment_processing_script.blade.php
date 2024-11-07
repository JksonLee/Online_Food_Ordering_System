<?php

use App\DesignPattern\Strategy\PaymentService;
use Illuminate\Http\Request;

// Get payment type from the form submission
$paymentType = $_POST['payment_type'] ?? 'Cash';

// Create an instance of PaymentService
$paymentService = new PaymentService();

// Process the order using the selected payment type
    $response = $paymentService->processOrder($paymentType);

if ($response instanceof \Illuminate\Http\RedirectResponse) {
    // If the response is a RedirectResponse, output the redirect
    header('Location: ' . $response->headers->get('Location'));
    exit;
}

// Redirect to the order completion page
header("Location: /checkout/order/complete");
exit;

?>
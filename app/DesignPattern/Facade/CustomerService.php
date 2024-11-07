<?php

namespace App\DesignPattern\Facade;


use App\Models\Customer;
use App\Models\Wishlist;  // Ensure Wishlist model is imported
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\Order; // Import the Order model
use App\Models\OrderDetail; // Import the OrderDetail model
use App\Models\Shipping; // Import the ShippingDetail model

class CustomerService
{
   public function register($request)
{
    // Validate password confirmation
    if ($request->password !== $request->confirm_password) {
        return back()->with('error', 'Passwords do not match');
    }

    $customer = new Customer();
    $customer->name = $request->name;
    $customer->email = $request->email;
    $customer->phone_no = $request->phone_no;
    $customer->password = Hash::make($request->password);
    $customer->save();

    Session::put('customer_id', $customer->customer_id);
    Session::put('customer_name', $customer->name);

    // Uncomment to enable email sending
    $data = $customer->toArray();
    Mail::send('FrontEnd.mail.welcome_mail', $data, function($message) use ($data) {
        $message->to($data['email']);
        $message->subject('Welcome To NUM NUM FOOD RESTAURANT');
    });

    return $customer;
}


   public function authenticate($request)
{
    // Validate request data
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    // Retrieve the customer by email
    $customer = Customer::where('email', $request->email)->first();

    // Check if the customer exists
    if (!$customer) {
        session()->flash('error', 'Email not found.');
        return null;
    }

    // Verify the password
    if (!Hash::check($request->password, $customer->password)) {
        session()->flash('error', 'Invalid credentials.');
        return null;
    }

    // If authentication succeeds, set session data
    Session::put('customer_id', $customer->customer_id);
    Session::put('customer_name', $customer->name);

    session()->flash('success', 'Login successful!');
    return $customer;
}



    public function logout()
    {
        Session::forget('customer_id');
        Session::forget('customer_name');
        
          Session::forget('coupon');
    }

    public function findCustomer($id)
    {
        return Customer::find($id);
    }
    
        // Add an item to the wishlist
  public function addToWishlist($dishId)
    {
        $customerId = Session::get('customer_id');

        if ($customerId) {
            // Check if item already exists in the wishlist
            $existingItem = Wishlist::where('customer_id', $customerId)->where('dish_id', $dishId)->first();
            
            if (!$existingItem) {
                Wishlist::create([
                    'customer_id' => $customerId,
                    'dish_id' => $dishId,
                ]);
            }
        }
    }

    // Retrieve wishlist items for the logged-in customer
 public function getWishlistItems()
{
    $customerId = Session::get('customer_id'); // Ensure session is working

    if ($customerId) {
        // Fetch the wishlist items for this customer
        return Wishlist::where('customer_id', $customerId)
                       ->with('dish')  // Ensure that the 'dish' relationship is defined in the Wishlist model
                       ->get();
    }

    return collect();  // Return an empty collection if no customer is logged in
}

 public function removeFromWishlist($dishId)
    {
        $customerId = Session::get('customer_id');

        if ($customerId) {
            // Find the wishlist item by customer_id and dish_id
            $wishlistItem = Wishlist::where('customer_id', $customerId)
                                    ->where('dish_id', $dishId)
                                    ->first();
            
            // If the item exists, delete it
            if ($wishlistItem) {
                $wishlistItem->delete();
            }
        }
    }
    
    
    public function getCustomerPayments($customerId)
    {
        $customer = Customer::with(['payments.order'])->find($customerId);

        if (!$customer) {
            return null;  // Handle cases where the customer is not found
        }

        return $customer->payments()->with('order')->get();
    }
    
    
    
    public function getInvoiceData($order_id)
    {
     // Retrieve the order including the customer and order details
    $order = Order::with(['customer', 'orderDetails'])->where('order_id', $order_id)->firstOrFail();
    
    // Fetch order details separately if needed
    // $order_details = OrderDetail::where('order_id', $order_id)->get(); // This line is redundant with the relationships
    
    return [
        'order' => $order,
        'order_details' => $order->orderDetails,
        'customer' => $order->customer,
    ];
} 

public function editProfile($request, $customerId)
{
    $customer = Customer::find($customerId);
    
    if (!$customer) {
        return null; // Handle case where customer is not found
    }

    // Update customer details
    $customer->name = $request->fullName;
    $customer->email = $request->email;
    $customer->phone_no = $request->phone;

    // If a new password is provided, hash it and update
    if ($request->filled('password')) {
        $customer->password = Hash::make($request->password);
    }

    $customer->save(); // Save the updated customer

    return $customer;
}


}
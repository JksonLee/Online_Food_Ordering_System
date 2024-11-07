<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\deliverBoyController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\PaymentController;
use App\Http\Middleware\CheckAuthMiddleware;
use App\Http\Controllers\CustomForgotPasswordController;
use App\Http\Controllers\CustomResetPasswordController;
use App\Http\Controllers\AdminLoginController;

/*===================Import the design pattern der =====================================*/
use App\DesignPattern\Factory\DeliverBoyFactoryInterface;
use App\DesignPattern\Factory\CategoryFactoryInterface;
use App\DesignPattern\Factory\CouponFactoryInterface;
use App\DesignPattern\Factory\DishFactoryInterface;
use App\DesignPattern\Factory\OrderFactoryInterface;
use App\DesignPattern\Facade\CustomerFacade as Customer;
use App\DesignPattern\Facade\ShippingFacade as Shipping;
use App\DesignPattern\Observer\Event\CartService;
use App\Models\Order;
use App\Models\category;
use Illuminate\Http\Request;
use App\DesignPattern\Strategy\PaymentService;
use App\DesignPattern\Facade\CustomerFacade;
use App\DesignPattern\Facade\CustomerService;
use Illuminate\Support\Facades\Session;
/*===================Import the design pattern der =====================================*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/userprofile', function () {
    $customerService = new CustomerService();

    // Fetch the customer ID from the session
    $customerId = Session::get('customer_id');
    
    // If no customer is logged in, redirect to login
    if (!$customerId) {
        return redirect()->route('login'); 
    }

    // Fetch the customer details
    $customer = $customerService->findCustomer($customerId);

    // Fetch the wishlist items for the customer
    $wishlistItems = $customerService->getWishlistItems();

    // Debugging to check if wishlistItems are retrieved correctly


    return view('FrontEnd.customer.userprofile', compact('customer', 'wishlistItems'));
})->name('user_profile');

Route::get('/view-cusinvoice/{order_id}', function ($order_id) {
    $invoiceData = CustomerFacade::getInvoiceData($order_id);

    return view('FrontEnd.customer.view_customerinvoice', $invoiceData);
})->name('view_cusinvoice');

Route::get('/editprofile', function () {
    // Fetch the customer profile using the CustomerService facade
    $customerService = new CustomerService();
    $customerId = Session::get('customer_id');

    // Ensure customer data is fetched
    $customer = $customerService->findCustomer($customerId); 

    // Pass the customer data to the view
    return view('FrontEnd.customer.editprofile', compact('customer'));
})->name('editprofile');

Route::post('/customer/update-profile', function (Request $request) {
    $customerId = Session::get('customer_id'); // Assuming customer is logged in
    if ($customerId) {
        CustomerFacade::editProfile($request, $customerId);
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
    return redirect()->back()->with('error', 'You must be logged in to update your profile.');
})->name('customer.updateProfile');


 Route::get('/', [App\Http\Controllers\FrontEndController::class, 'index'])->name('homepage');
 Route::get('/category/dish/show/{category_id}', [App\Http\Controllers\FrontEndController::class, 'dish_show'])->name('category_dish');
 
 /*===================Cart Start here =====================================*/
// Route::post('/add/cart',[App\Http\Controllers\CartController::class, 'insert'])->name('add_to_cart');
// Route::get('/cart/show',[App\Http\Controllers\CartController::class, 'show'])->name('cart_show');

 
 /*===================Cart End here =====================================*/
 
 /*==================Check Out Start here =====================================*/
// 
// Route::get('/checkout/payment',[App\Http\Controllers\CheckOutController::class, 'payment'])->name('checkout_payment');
//Route::post('/checkout/new/order',[App\Http\Controllers\CheckOutController::class, 'order'])->name('new_order');
//Route::get('/checkout/order/complete',[App\Http\Controllers\CheckOutController::class, 'complete'])->name('order_complete');
//
////stripe payment only
//Route::get('/stripe-payment',[App\Http\Controllers\StripeController::class, 'handleGet']);
//Route::post('/stripe-payment',[App\Http\Controllers\StripeController::class, 'handlePost'])->name('stripe.payment');

/*===================Check Out End here =====================================*/
 
 
 /*==================Customer Start here =====================================*/
// Route::get('/register/customer',[App\Http\Controllers\CustomerController::class, 'show'])->name('sign_up');
// Route::post('/register/customer/store',[App\Http\Controllers\CustomerController::class, 'store'])->name('store_customer');
// 
// Route::get('/login/customer/',[App\Http\Controllers\CustomerController::class, 'login'])->name('login_in');
// Route::post('/logout/customer/',[App\Http\Controllers\CustomerController::class, 'logout'])->name('log_out');
// Route::post('/check/customer/login',[App\Http\Controllers\CustomerController::class, 'check'])->name('check_login');
// 
// 
// Route::get('/shipping',[App\Http\Controllers\CustomerController::class, 'shipping']);
//  Route::post('/shipping/store',[App\Http\Controllers\CustomerController::class, 'save'])->name('store_shipping');
 
 /*==================Customer End here =====================================*/

 
 Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [LoginController::class, 'destroy'])->name('profile.destroy');

});


Route::get('admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');


Route::get('admin/dashboard', function () {
    // Only accessible if the admin is logged in
    if (session()->has('admin_id')) {
        return view('BackEnd.Home.index');
    }
    return redirect()->route('admin.login')->with('error', 'Please login to access the dashboard.');
})->name('admin.dashboard');

//Route::post('/logout', [CustomLoginController::class, 'logout'])->name('logout');



Route::get('/home', [HomeController::class, 'index']);
Route::get('/search', [FrontEndController::class, 'search'])->name('search');



// ======================XML Routes Start=========================
Route::prefix('xml')->group(function () {
     Route::get('/menu', [DishController::class, 'showMenuXML'])->name('xml_menu');
      Route::get('/payment', [PaymentController::class, 'showPaymentsXML'])->name('xml_payment');
      Route::get('/order', [OrderController::class, 'showOrderXML'])->name('xml_order');
 Route::get('/customer', [CustomerController::class, 'showCustomerXML'])->name('xml_customer');
  Route::get('/rating', [RatingController::class, 'showRatingXML'])->name('xml_rating');
});
// ======================XML Routes End=========================

// ======================XSLT Routes Start=========================
Route::prefix('xslt')->group(function () {
     Route::get('/menu', [DishController::class, 'transformMenuXSLT'])->name('xslt_menu');
    Route::get('/xslt', [PaymentController::class, 'transformPaymentsXSLT'])->name('xslt_payment');
Route::get('/order', [OrderController::class, 'transformOrderXSLT'])->name('xslt_order'); // Change path to /ord
    Route::get('/customer', [CustomerController::class, 'transformCustomerXSLT'])->name('xslt_customer');
        Route::get('/rating', [RatingController::class, 'transformRatingXSLT'])->name('xslt_rating');
});
// ======================XSLT Routes End=========================


// ======================XML Download Start=========================
Route::prefix('download_xml')->group(function () {
Route::get('/downloadOrderXML', [OrderController::class, 'downloadOrderXML'])->name('download_order_xml');

// Customers XML Download Route
Route::get('/downloadCustomerXML', [CustomerController::class, 'downloadCustomerXML'])->name('download_customer_xml');

// Ratings XML Download Route
Route::get('/downloadRatingXML', [RatingController::class, 'downloadRatingXML'])->name('download_rating_xml');

// Menu XML Download Route
Route::get('/downloadMenuXML', [DishController::class, 'downloadMenuXML'])->name('download_menu_xml');

// Payments XML Download Route
Route::get('/downloadPaymentXML', [PaymentController::class, 'downloadPaymentXML'])->name('download_payment_xml');
});
// ======================XML Download End=========================


Route::post('/rating/submit/{dish_id}', [FrontEndController::class, 'submitRating'])->name('submit.rating');

Route::prefix('review_rating')->group(function(){
   Route::get('/review/manage', [RatingController::class, 'index'])->name('review_manage');
    Route::get('average-ratings', [RatingController::class, 'averageRatings'])->name('average_rating');
});


Route::middleware(['web'])->group(function () {
    Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('apply.coupon');
    Route::post('/remove-coupon', [CartController::class, 'removeCoupon'])->name('remove.coupon');
});





/*==================WishListStart here =====================================*/
//Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
//Route::get('/wishlist/view', [WishlistController::class, 'viewWishlist'])->name('wishlist.view');
Route::post('/remove-from-wishlist', function (Request $request) {
    $dishId = $request->input('dish_id');
    
    $customerService = new CustomerService();
    $customerService->removeFromWishlist($dishId);

    return back()->with('success', 'Dish removed from your wishlist!');
})->name('wishlist.remove');

Route::post('/wishlist/add/{dish_id}', function ($dishId) {
    $customerService = new CustomerService();
    $customerService->addToWishlist($dishId);

    return redirect()->back()->with('success', 'Item added to your wishlist!');
})->name('wishlist.add');
/*==================WishListEnd here =====================================*/

/*==================Check Out Start here =====================================*/
Route::get('/checkout/payment', function () {
    return view('FrontEnd.checkOut.check_payment');
})->name('checkout_payment');


Route::post('/checkout/new/order', function (Request $request, PaymentService $paymentService) {
    $paymentType = $request->input('payment_type', 'Cash');

    if ($paymentType === 'Cash') {
          $paymentType = $request->input('payment_type', 'Cash');
    $response = $paymentService->processOrder($request,$paymentType);
    return $response instanceof \Illuminate\Http\RedirectResponse ? $response : redirect('checkout/order/complete');
       
    } elseif ($paymentType === 'Stripe') {
        // Redirect to the Stripe payment page
        return redirect()->route('stripe_payment_page');
    } else {
        return redirect()->back()->withErrors('Invalid payment type selected.');
    }
})->name('new_order');

Route::get('/checkout/order/complete', function () {
    return view('FrontEnd.checkOut.order_complete');
})->name('order_complete');


// Stripe payment specific routes

Route::get('/stripe-payment', function () {
    return view('FrontEnd.checkOut.stripe');
})->name('stripe_payment_page');

Route::post('/stripe/payment', function (Request $request, PaymentService $paymentService) {
    $paymentType = $request->input('payment_type', 'Stripe'); 

    // Process the order with Stripe
    $response = $paymentService->processOrder($request, $paymentType);

    // Ensure the response is a redirect to order_complete
    return $response instanceof \Illuminate\Http\RedirectResponse 
        ? $response 
        : redirect()->route('order_complete');
})->name('stripe.payment');
/*===================Check Out End here =====================================*/




 /*===================Cart Start here =====================================*/


Route::get('/cart/show', function (CartService $cartService) {
    $cartItems = $cartService->getCartContents(); // Use the method to get cart items
    return view('FrontEnd.cart.show', compact('cartItems'));
})->name('cart.show');

Route::post('/cart/add', function (Illuminate\Http\Request $request, CartService $cartService) {
    $validated = $request->validate([
        'dish_id' => 'required|integer|exists:dishes,dish_id',
        'qty' => 'required|integer|min:1',
    ]);

    $dishId = $validated['dish_id'];
    $qty = $validated['qty'];

    try {
        $cartService->addDish($dishId, $qty);
        return redirect()->route('cart.show')->with('message', 'Dish added to cart');
    } catch (\Exception $e) {
        return redirect()->route('cart.show')->withErrors(['message' => $e->getMessage()]);
    }
})->name('cart.add');



Route::post('/cart/update', function (Illuminate\Http\Request $request, CartService $cartService) {
    $validated = $request->validate([
        'row_id' => 'required|string',
        'qty' => 'required|integer|min:1',
    ]);

    $rowId = $validated['row_id'];
    $qty = $validated['qty'];

    try {
        $cartService->updateDish($rowId, $qty);
    } catch (\Exception $e) {
        return back()->withErrors(['message' => $e->getMessage()]);
    }

    return back()->with('message', 'Dish updated in cart');
})->name('cart.update');

// Route to remove a dish from the cart
Route::post('/cart/remove', function (Illuminate\Http\Request $request, CartService $cartService) {
    $rowId = $request->input('row_id');

    if (is_null($rowId)) {
        return back()->withErrors(['message' => 'Row ID is missing.']);
    }

    try {
        $cartService->removeDish($rowId);
    } catch (\Exception $e) {
        return back()->withErrors(['message' => $e->getMessage()]);
    }

    return back()->with('message', 'Dish removed from cart');
})->name('cart.remove');


 /*===================Cart End here =====================================*/


   
  /*==================Customer Start here =====================================*/
Route::get('/register/customer', function () {
    return view('FrontEnd.customer.register');
})->name('sign_up');

Route::post('/register/customer/store', function (\Illuminate\Http\Request $request) {
    Customer::register($request);
    return redirect()->route('homepage');
})->name('register.submit');

// Login routes
Route::get('/login/customer', function () {
    return view('FrontEnd.customer.login');
})->name('login_in');

Route::post('/login/customer/store', function (\Illuminate\Http\Request $request) {
    $customer = Customer::authenticate($request);
    if ($customer) {
        return redirect()->route('homepage');
    } else {
        return redirect()->route('login_in')->with('sms', 'Your Password is incorrect, Please provide us your correct password');
    }
})->name('login.submit');

// Logout route
Route::post('/logout/customer', function (CartService $cartService) {
    // Clear the cart for the current user
    $cartService->clearCart();
 Customer::logout();
    // Log out the user (assuming Customer is the correct model for authentication)
    auth()->guard('customer')->logout(); // Adjust the guard name if necessary

    return redirect('/');
})->name('log_out');

// Shipping routes
Route::get('/shipping', function () {
    $customer = Customer::findCustomer(Session::get('customer_id'));
    return view('FrontEnd.checkOut.shipping', compact('customer'));
})->name('shipping.form');

Route::post('/shipping', function (\Illuminate\Http\Request $request) {
    Shipping::saveShippingDetails($request);
    return redirect()->route('checkout_payment');
})->name('shipping.submit');

// Checkout payment route (assuming it exists)
Route::get('/checkout/payment', function () {
    return view('FrontEnd.checkOut.checkout_payment');
})->name('checkout_payment');




// Custom Forgot Password Routes
use App\Http\Controllers\CustomPasswordResetController;

Route::get('password/forgot', [CustomPasswordResetController::class, 'showForgotForm'])->name('password.custom.request');
Route::post('password/email', [CustomPasswordResetController::class, 'sendResetLink'])->name('password.custom.email');

Route::get('password/reset/{token}', [CustomPasswordResetController::class, 'showResetForm'])->name('password.custom.reset.form');
Route::post('password/reset', [CustomPasswordResetController::class, 'resetPassword'])->name('password.custom.reset');





 /*==================Customer End here =====================================*/


/*===================Coupon add here =====================================*/
//Route::get('/add',[App\Http\Controllers\DishController::class, 'index'])->name('show_dish_table');
//Route::post('/save',[App\Http\Controllers\DishController::class, 'save_dish'])->name('save_dish_data');
//Route::get('/manage',[App\Http\Controllers\DishController::class, 'manage_dish'])->name('manage_dish_table');
//Route::get('/inactive/{dish_id}',[App\Http\Controllers\DishController::class, 'inactive'])->name('dish_inactive');
//Route::get('/active/{dish_id}',[App\Http\Controllers\DishController::class, 'active'])->name('dish_active');
//Route::get('/delete/{dish_id}',[App\Http\Controllers\DishController::class, 'dish_delete'])->name('delete_dish');
//Route::post('/update',[App\Http\Controllers\DishController::class, 'dish_update'])->name('update_dish');
/*===================Coupon end here =====================================*/



Route::prefix('category')->group(function(){
/*===================Factory Category add here =====================================*/
// Route for adding a category

    Route::get('/category/add', function (CategoryFactoryInterface $factory) {
    return $factory->getAddCategoryPage();
})->name('category_add');
    
Route::post('/category/save', function (Illuminate\Http\Request $request, CategoryFactoryInterface $factory) {
    $validatedData = $request->validate([
        'category_name' => 'required|string|max:255',
        'order_number' => 'required|integer',
        'category_status' => 'required|boolean',
        'added_on' => 'required|date',
    ]);

    $factory->createCategory($validatedData);
    return back()->with('sms', 'Category Saved');
})->name('category.save');

// Route for updating a category
Route::post('/category/update', function (Illuminate\Http\Request $request, CategoryFactoryInterface $factory) {
    $validatedData = $request->validate([
        'category_name' => 'required|string|max:255',
        'order_number' => 'required|integer',
        'category_id' => 'required|exists:categories,category_id',
    ]);

    $factory->updateCategory($validatedData['category_id'], $validatedData);
    return redirect('/category/manage')->with('sms', 'Category updated');
})->name('category_update');

// Route for activating a category
Route::get('/category/activate/{category_id}', function ($id, CategoryFactoryInterface $factory) {
    $factory->activateCategory($id);
    return back();
})->name('category_activate');

// Route for deactivating a category
Route::get('/category/deactivate/{category_id}', function ($id, CategoryFactoryInterface $factory) {
    $factory->deactivateCategory($id);
    return back();
})->name('category_deactivate');

// Route for deleting a category
Route::get('/category/delete/{category_id}', function ($id, CategoryFactoryInterface $factory) {
    $factory->deleteCategory($id);
    return back();
})->name('category_delete');

// Route for managing categories
Route::get('/category/manage', function (CategoryFactoryInterface $factory) {
    $categories = $factory->getAllCategories();
    return view('BackEnd.category.manageCategory', compact('categories'));
})->name('manage_cate');

});
/*===================Factory Category add here =====================================*/




Route::prefix('delivery_boy')->group(function(){
/*===================Factory Delivery Man add here =====================================*/

Route::get('/add', function (DeliverBoyFactoryInterface $factory) {
        return $factory->getAddDeveliverBoyPage();
    })->name('deliveryBoy_add');

    
Route::post('/delivery-boy/save', function (Request $request, DeliverBoyFactoryInterface $factory) {
     
    $validatedData = $request->validate([
        'delivery_boy_name' => 'required|string|max:255',
        'delivery_boy_phone_number' => 'required|string|max:20',
        'delivery_boy_password' => 'required|string|min:6',
        'delivery_boy_status' => 'required|boolean',
        'added_on' => 'required|date',
    ]);

    $factory->createBoy($validatedData);

    return back()->with('sms', 'Boy Saved');
})->name('delivery_save');


Route::get('/delivery-boy/manage', function () {
    $factory = App::make(DeliverBoyFactoryInterface::class);
    $boys = $factory->getAllBoys();
    return view('BackEnd.deliveryBoy.manage', compact('boys'));
})->name('delivery_boy_manage');

Route::get('/delivery-boy/delete/{delivery_boy_id}', function ($deliveryBoyId) {
    $factory = App::make(DeliverBoyFactoryInterface::class);
    $factory->deleteBoy($deliveryBoyId);
    return back()->with('sms', 'Delivery Boy Deleted');
})->name('delivery_boy_delete');

Route::get('/delivery-boy/inactive/{delivery_boy_id}', function ($deliveryBoyId) {
    $factory = App::make(DeliverBoyFactoryInterface::class);
    $factory->deactivateBoy($deliveryBoyId);
    return back();
})->name('delivery_boy_inactive');

Route::get('/delivery-boy/active/{delivery_boy_id}', function ($deliveryBoyId) {
    $factory = App::make(DeliverBoyFactoryInterface::class);
    $factory->activateBoy($deliveryBoyId);
    return back();
})->name('delivery_boy_active');

Route::post('/delivery-boy/update', function (Request $request) {
    $factory = App::make(DeliverBoyFactoryInterface::class);

    $validatedData = $request->validate([
        'delivery_boy_id' => 'required|exists:deliver_boys,delivery_boy_id',
        'delivery_boy_name' => 'required|string|max:255',
        'delivery_boy_phone_number' => 'required|string|max:20',
    ]);

    $factory->updateBoy($validatedData['delivery_boy_id'], $validatedData);
    
    return back()->with('sms', 'Boy updated');
})->name('delivery_boy_update');

/*===================Factory Delivery Man add here =====================================*/
});



Route::prefix('coupon')->group(function(){
/*===================Factory Coupon add here =====================================*/
// Route to show the form for adding a new coupon
Route::get('/coupon/add', function (CouponFactoryInterface $factory) {
    return $factory->getAddCouponPage();
})->name('coupon_add');

// Route to save a new coupon
Route::post('/coupon/save', function (Request $request, CouponFactoryInterface $factory) {
    $validatedData = $request->validate([
        'coupon_code' => 'required|string|max:255',
        'coupon_type' => 'required|string|max:255',
        'coupon_value' => 'required|numeric',
        'cart_min_value' => 'required|numeric',
        'expired_on' => 'required|date',
        'coupon_status' => 'required|boolean',
        'added_on' => 'required|date',
    ]);

    $factory->createCoupon($validatedData);

    return back()->with('sms', 'Coupon Saved');
})->name('coupon_save');

// Route to manage and list all coupons
Route::get('/coupon/manage', function (CouponFactoryInterface $factory) {
    $coupons = $factory->getAllCoupons();
    return view('BackEnd.Coupon.manage', compact('coupons'));
})->name('coupon_manage');

// Route to activate a coupon
Route::get('/coupon/activate/{coupon_id}', function ($couponId, CouponFactoryInterface $factory) {
    $factory->activateCoupon($couponId);
    return back()->with('sms', 'Coupon Activated');
})->name('coupon_activate');

// Route to deactivate a coupon
Route::get('/coupon/deactivate/{coupon_id}', function ($couponId, CouponFactoryInterface $factory) {
    $factory->deactivateCoupon($couponId);
    return back()->with('sms', 'Coupon Deactivated');
})->name('coupon_deactivate');

// Route to delete a coupon
Route::get('/coupon/delete/{coupon_id}', function ($couponId, CouponFactoryInterface $factory) {
    $factory->deleteCoupon($couponId);
    return back()->with('sms', 'Coupon Deleted');
})->name('coupon_delete');

// Route to update a coupon
Route::post('/coupon/update', function (Request $request, CouponFactoryInterface $factory) {
    $validatedData = $request->validate([
        'coupon_id' => 'required|exists:coupons,coupon_id',
        'coupon_code' => 'required|string|max:255',
        'coupon_type' => 'required|string|max:255',
        'coupon_value' => 'required|numeric',
        'cart_min_value' => 'required|numeric',
        'expired_on' => 'nullable|date',
        'coupon_status' => 'nullable|boolean',
        'added_on' => 'nullable|date',
    ]);

    $factory->updateCoupon($validatedData['coupon_id'], $validatedData);
    
    return back()->with('sms', 'Coupon Updated');
})->name('coupon_update');
/*===================Factory Coupon add here =====================================*/
});



Route::prefix('dish')->group(function(){
/*===================Factory Dish add here =====================================*/
Route::get('add-dish', function (DishFactoryInterface $factory) {
    return $factory->getAddDishPage();
})->name('add_dish');

Route::post('save-dish', function (Request $request, DishFactoryInterface $factory) {
    $factory->createDish($request);
    return redirect()->route('add_dish')->with('sms', 'Data Saved');
})->name('save_dish_data');

Route::get('manage-dish', function (DishFactoryInterface $factory) {
    $dishes = $factory->getAllDishes();
    return view('BackEnd.dish.manage', ['dishes' => $dishes, 'categories' => category::where('category_status', 1)->get()]);
})->name('manage_dish');

Route::post('update-dish', function (DishFactoryInterface $factory, Request $request) {
    $dishId = $request->input('dish_id');  // Extract the dishId from the request
    $factory->updateDish($dishId, $request);
    return redirect()->route('manage_dish')->with('sms', 'Dish updated successfully!');
})->name('update_dish');

Route::get('inactive-dish/{dish_id}', function ($dish_id, DishFactoryInterface $factory) {
    $factory->deactivateDish($dish_id);
    return back();
})->name('dish_inactive');

Route::get('active-dish/{dish_id}', function ($dish_id, DishFactoryInterface $factory) {
    $factory->activateDish($dish_id);
    return back();
})->name('dish_active');

Route::get('delete-dish/{dish_id}', function ($dish_id, DishFactoryInterface $factory) {
    $factory->deleteDish($dish_id);
    return back();
})->name('delete_dish');
/*===================Factory Dish add here =====================================*/
});




Route::prefix('order')->group(function(){
/*===================Factory Order add here =====================================*/
Route::get('manage-order', function (OrderFactoryInterface $factory) {
    return $factory->manageOrder();
})->name('manage_order');

Route::get('view-order/{order_id}', function (OrderFactoryInterface $factory, $orderId) {
    return $factory->viewOrder($orderId);
})->name('view_order');

Route::get('view-invoice/{order_id}', function (OrderFactoryInterface $factory, $orderId) {
    return $factory->viewInvoice($orderId);
})->name('view_invoice');

Route::get('download-invoice/{order_id}', function (OrderFactoryInterface $factory, $orderId) {
    return $factory->downloadInvoice($orderId);
})->name('download_invoice');

Route::get('delete-order/{order_id}', function (OrderFactoryInterface $factory, $orderId) {
    $factory->deleteOrder($orderId);  // Delete the order
    return back()->with('sms', 'Order Deleted Successfully');  // Redirect back with success message
})->name('delete_order');

/*===================Factory Order add here =====================================*/
});


require __DIR__.'/auth.php';

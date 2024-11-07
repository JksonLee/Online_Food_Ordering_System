<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\Dish;
use App\Models\Rating;
use App\Models\Coupon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;


class FrontEndController extends Controller
{
    // Home page: displaying all dishes
    public function index()
    {
        $dishes = Dish::where('dish_status', 1)->get();
        return view('FrontEnd.include.home', compact('dishes'));
    }

    // Displaying dishes for a specific category
    public function dish_show($id)
    {
        // Querying dishes based on category and status
       $filteredDishes = Dish::with('coupons') // Assuming you have a coupons relationship in the Dish model
                              ->where('category_id', $id)
                              ->where('dish_status', 1)
                              ->get();
        
        // Fetch all categories for the filter section
        $categories = category::all();  

       $coupons = Coupon::where('coupon_status', 1)->get();
         
        // Pass the dishes and categories to the view
        return view('FrontEnd.include.dish', compact('filteredDishes', 'categories', 'coupons'));
    }

    // Search functionality with filters
    public function search(Request $request)
{
    // Fetch categories for the filter
    $categories = Category::all();

        // Fetch coupons for the view
    $coupons = Coupon::where('coupon_status', 1)->get();
    
    // Get search and filter inputs
    $query = $request->input('query');
    $category = $request->input('category');
    $price_range = $request->input('price_range');
    $rating = $request->input('rating');

    
    // Initialize the query
    $dishes = Dish::with('ratings')->where('dish_status', 1);

    // Apply search filter for dish name, dish detail
    if ($query) {
        $dishes->where(function($q) use ($query) {
            $q->where('dish_name', 'LIKE', "%$query%")
              ->orWhere('dish_detail', 'LIKE', "%$query%");
        });
    }

    // Filter by category if a specific category is selected
    if ($category) {
        $dishes->where('category_id', $category);
    }

    // Filter by price range
    if ($price_range) {
        if ($price_range == 'low') {
            $dishes->where('full_price', '<=', 10);
        } elseif ($price_range == 'mid') {
            $dishes->whereBetween('full_price', [11, 30]);
        } elseif ($price_range == 'high') {
            $dishes->where('full_price', '>', 30);
        }
    }

    // Filter by rating using the average rating of the dish
    if ($rating) {
        $dishes->whereHas('ratings', function ($q) use ($rating) {
            $q->havingRaw('AVG(rating) >= ?', [$rating]);
        });
    }

    // Get the filtered dishes
    $filteredDishes = $dishes->get();

    // Pass the filtered dishes and categories to the view
    return view('FrontEnd.include.dish', compact('filteredDishes', 'categories','coupons'));
}

  public function submitRating(Request $request, $dish_id)
{
    // Assuming the customer is authenticated, get the customer ID from session or auth
    $customer_id = session('customer_id'); // or Auth::id() if using Laravel's Auth system

    // Validate the form data
    $request->validate([
        'rating' => 'required|integer|between:1,5',
        'review' => 'required|string|max:255',
    ]);

    // Check if customer is logged in or session exists
    if (!$customer_id) {
        return redirect()->back()->withErrors(['error' => 'You need to be logged in to submit a review.']);
    }

    // Create a new Rating object and save it to the database
    $rating = new Rating();
    $rating->customer_id = $customer_id;  // Fetch customer_id securely
    $rating->dish_id = $dish_id;
    $rating->rating = $request->input('rating');
    $rating->review = $request->input('review');
    $rating->save();

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Your review has been submitted successfully.');
}

// Fetch all coupons and pass them to the view
    public function showCoupons()
    {
        $coupons = Coupon::all();  // Fetch all coupons from the database
        return view('FrontEnd.coupons', compact('coupons'));  // Pass coupons to the view
    }


    
}
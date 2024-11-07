<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Add dish to wishlist
    public function add(Request $request)
    {
        $wishlist = new Wishlist;
        $wishlist->customer_id = Auth::id(); // Get the authenticated user's ID
        $wishlist->dish_id = $request->input('dish_id'); // Get the dish ID from the request
        $wishlist->save();

        return back()->with('success', 'Dish added to your wishlist!');
    }

    // Display wishlist items in the profile
    public function viewWishlist()
    {
        $wishlistItems = Wishlist::where('customer_id', Auth::id())
                                 ->with('dish')  // Load the related dish data
                                 ->get();

        return view('profile', compact('wishlistItems'));
    }
}
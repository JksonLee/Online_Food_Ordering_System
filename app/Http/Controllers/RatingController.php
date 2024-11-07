<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Dish;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
      public function store(Request $request, $dishId) {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string'
        ]);

        Rating::create([
            'customer_id' => Auth::id(),
            'dish_id' => $dishId,
            'rating' => $request->rating,
            'review' => $request->review
        ]);

        return redirect()->back()->with('success', 'Rating added successfully!');
    }
    
     public function index()
    {
        // Fetch reviews with customer and dish relationships
        $reviews = Rating::with('customer', 'dish')->get();

        // Pass data to the view
        return view('BackEnd.Review.reviewrating', compact('reviews'));
    }
    
    // Method to fetch and display average ratings for dishes
    public function averageRatings()
    {
         $dishes =  DB::table('dishes')
        ->leftJoin('ratings', 'dishes.dish_id', '=', 'ratings.dish_id')
        ->select('dishes.dish_id as id', 'dishes.dish_name', 'dishes.dish_image', DB::raw('AVG(ratings.rating) as average_rating'))
        ->groupBy('dishes.dish_id', 'dishes.dish_name', 'dishes.dish_image')
        ->orderBy('average_rating', 'desc') // Sorting by average rating in descending order
        ->get();


        // Pass data to the view
        return view('BackEnd.Review.averagerating', compact('dishes'));
    }
    
    
    
     public function showRatingXML()
    {
        // Fetch ratings with dishes and customer details
        $ratings = DB::table('ratings')
            ->join('dishes', 'ratings.dish_id', '=', 'dishes.dish_id')
            ->join('customers', 'ratings.customer_id', '=', 'customers.customer_id')
            ->select('dishes.dish_id', 'dishes.dish_name', 'dishes.dish_image', 'dishes.full_price', 'dishes.half_price', 'customers.email as customer_email', 'ratings.rating', 'ratings.review', 'ratings.created_at as review_timestamp')
            ->get();

        // Generate XML structure
        $xmlData = $this->generateRatingXML($ratings);

        // Return the XML response with appropriate headers
        return response($xmlData, 200)
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Apply XSLT transformation to XML rating data.
     */
    public function transformRatingXSLT()
    {
        // Fetch ratings with dishes and customer details
        $ratings = DB::table('ratings')
            ->join('dishes', 'ratings.dish_id', '=', 'dishes.dish_id')
            ->join('customers', 'ratings.customer_id', '=', 'customers.customer_id')
            ->select('dishes.dish_id', 'dishes.dish_name', 'dishes.dish_image', 'dishes.full_price', 'dishes.half_price', 'customers.email as customer_email', 'ratings.rating', 'ratings.review', 'ratings.created_at as review_timestamp')
            ->get();

        // Generate XML
        $xmlData = $this->generateRatingXML($ratings);

        // Apply XSLT transformation to the generated XML
        $xsltData = $this->applyXsltTransformation($xmlData, 'rating');

        // Return the transformed HTML response
        return response($xsltData, 200)
            ->header('Content-Type', 'text/html');
    }

    /**
     * Generate the XML for ratings with dishes and reviews.
     * @param \Illuminate\Support\Collection $ratings
     * @return string
     */
    private function generateRatingXML($ratings)
    {
        $xml = new \SimpleXMLElement('<ratings/>');

        foreach ($ratings as $rating) {
            $ratingElement = $xml->addChild('rating');
            $ratingElement->addChild('dish_id', $rating->dish_id);
            $ratingElement->addChild('dish_name', $rating->dish_name);
         $imageUrl = asset($rating->dish_image);
        $ratingElement->addChild('dish_image', $imageUrl);
            $ratingElement->addChild('full_price', $rating->full_price);
            $ratingElement->addChild('half_price', $rating->half_price);
            $ratingElement->addChild('customer_email', $rating->customer_email);
            $ratingElement->addChild('rating', $rating->rating);
            $ratingElement->addChild('review', $rating->review);
            $ratingElement->addChild('review_timestamp', $rating->review_timestamp);
        }

        return $xml->asXML();
    }

    /**
     * Apply XSLT transformation to XML data.
     * @param string $xmlData - The raw XML data
     * @param string $type - The type of XSLT file (rating, etc.)
     * @return string - Transformed HTML
     */
    private function applyXsltTransformation($xmlData, $type)
    {
        $xslPath = resource_path("views/BackEnd/xslt/{$type}.xsl");

        if (!file_exists($xslPath)) {
            die("XSLT file not found at: " . realpath($xslPath));
        }

        $xslt = new \XSLTProcessor();
        $xsl = new \DOMDocument();
        $xsl->load($xslPath);

        $xml = new \DOMDocument();
        $xml->loadXML($xmlData);

        $xslt->importStylesheet($xsl);

        return $xslt->transformToXML($xml);
    }
    
    public function downloadRatingXML()
    {
        // Fetch the rating data
        $ratings = DB::table('ratings')
            ->join('dishes', 'ratings.dish_id', '=', 'dishes.dish_id')
            ->join('customers', 'ratings.customer_id', '=', 'customers.customer_id')
            ->select('dishes.dish_id', 'dishes.dish_name', 'dishes.dish_image', 'dishes.full_price', 'dishes.half_price', 'customers.email as customer_email', 'ratings.rating', 'ratings.review', 'ratings.created_at as review_timestamp')
            ->get();

        // Generate XML structure
        $xmlData = $this->generateRatingXML($ratings);

        // Return the XML response with appropriate headers for download
        return response()->stream(
            function () use ($xmlData) {
                echo $xmlData;
            },
            200,
            [
                'Content-Type' => 'application/xml',
                'Content-Disposition' => 'attachment; filename="ratings.xml"',
            ]
        );
    }
    
}

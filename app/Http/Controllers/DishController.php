<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\Dish;
use DB;
use Illuminate\Http\Request;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = category::where('category_status',1)->get();
        return view('BackEnd.dish.add',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function save_dish(Request $request)
    {
        $imgName = $request->file('dish_image');
        $image = $imgName->getClientOriginalName();
        $directory = 'BackEndSourceFile/dish_img/';
        $imgUrl = $directory.$image;
        $imgName->move($directory,$image);
        
        $dish = new Dish();
        $dish->dish_name = $request->dish_name;
         $dish->category_id = $request->category_id;
         $dish->dish_detail = $request->dish_detail;
         $dish->dish_image = $imgUrl;
         $dish->dish_status = $request->dish_status;
         $dish->full_price = $request->full_price;
         $dish->half_price = $request->half_price;
         $dish->save();
           
               return back()->with('sms','Data Saved');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function manage_dish()
    {
        
 $categories = category::where('category_status',1)->get();
        $dishes = DB::table('dishes')
                       ->join('categories','dishes.category_id','=','categories.category_id')
                       ->select('dishes.*','categories.category_name')
                       ->get();  
                       
        return view('BackEnd.dish.manage',compact('dishes','categories'));
    }

   public function dish_update(Request $request)
   {
       $dish = Dish::find($request->dish_id);
       
       $img_main = $request->file('dish_image');
       
       if($img_main)
       {
       
           $img_name = $img_main->getClientOriginalName();
           $directory = 'BackEndSourceFile/dish_img/';
           $imgUrl = $directory.$img_name;
           $img_main->move($directory,$img_name);
           
           
           $old_img = $dish->dish_image;
           if(file_exists($old_img)){
               unlink($old_img);
               
           }
           
            $dish->dish_name = $request->dish_name;
         $dish->category_id = $request->category_id;
         $dish->dish_detail = $request->dish_detail;
          $dish->dish_image = $imgUrl;
         $dish->full_price = $request->full_price;
         $dish->half_price = $request->half_price;
      
       }
       else{
           $dish->dish_name = $request->dish_name;
           $dish->category_id = $request->category_id;
           $dish->dish_detail = $request->dish_detail;
           $dish->full_price = $request->full_price;
           $dish->half_price = $request->half_price;
       }
       $dish->save();
       return back()->with('sms','Updated data Successfully');
       
       
   }
    
    public function inactive($dish_id)
    {
       $dish = Dish::find($dish_id);
       $dish->dish_status = 0;
       $dish->save();
       
       return back();
    }

      public function active($dish_id)
    {
       $dish = Dish::find($dish_id);
       $dish->dish_status = 1;
       $dish->save();
       
       return back();
    }

      public function dish_delete($dish_id)
    {
       $dish = Dish::find($dish_id);
       $dish->delete();
       
       return back();
    }
    
       public function showMenuXML()
    {
        // Fetch dishes with their categories
        $dishes = DB::table('dishes')
                    ->join('categories', 'dishes.category_id', '=', 'categories.category_id')
                    ->select(
                        'dishes.dish_id', 
                        'dishes.dish_name', 
                        'categories.category_name', 
                        'dishes.dish_detail', 
                        'dishes.dish_image', 
                            'dishes.full_price',
                            'dishes.half_price',
                        'dishes.created_at as added_on'
                    )
                    ->get();

        // Generate XML structure
        $xmlData = $this->generateMenuXML($dishes);

        // Return the XML response with appropriate headers
        return response($xmlData, 200)
                 ->header('Content-Type', 'application/xml');
    }

    /**
     * Transform the XML menu data using XSLT.
     */
    public function transformMenuXSLT()
    {
        // Fetch dishes with their categories
        $dishes = DB::table('dishes')
                    ->join('categories', 'dishes.category_id', '=', 'categories.category_id')
                    ->select(
                        'dishes.dish_id', 
                        'dishes.dish_name', 
                        'categories.category_name', 
                        'dishes.dish_detail', 
                        'dishes.dish_image', 
                            'dishes.full_price',
                            'dishes.half_price',
                        'dishes.created_at as added_on'
                    )
                    ->get();

        // Generate XML
        $xmlData = $this->generateMenuXML($dishes);

        // Apply XSLT transformation
        $xsltData = $this->applyXsltTransformation($xmlData, 'menu');

        // Return the transformed HTML response
        return response($xsltData, 200)->header('Content-Type', 'text/html');
    }

    /**
     * Generate the XML for the menu.
     * @param \Illuminate\Support\Collection $dishes
     * @return string
     */
    private function generateMenuXML($dishes)
    {
        // Initialize XML structure with root element <menu>
        $xml = new \SimpleXMLElement('<menu/>');

        // Loop through each dish and add data as XML
        foreach ($dishes as $dish) {
        $dishElement = $xml->addChild('dish');
        $dishElement->addChild('dish_id', $dish->dish_id);
        $dishElement->addChild('dish_name', $dish->dish_name);
        $dishElement->addChild('category_name', $dish->category_name);
        $dishElement->addChild('dish_detail', $dish->dish_detail);
        $dishElement->addChild('dish_image', asset($dish->dish_image));
        $dishElement->addChild('full_price', $dish->full_price); // Add full price
        $dishElement->addChild('half_price', $dish->half_price); // Add half price
        $dishElement->addChild('added_on', $dish->added_on);
        }

        // Convert the SimpleXMLElement object to a string
        return $xml->asXML();
    }

    /**
     * Apply XSLT transformation to XML data.
     * @param string $xmlData - The raw XML data
     * @param string $type - The type of XSLT file (menu, etc.)
     * @return string - Transformed HTML
     */
    private function applyXsltTransformation($xmlData, $type)
    {
        $xslPath = resource_path("views/BackEnd/xslt/{$type}.xsl");

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

        // Transform the XML into HTML and return
        return $xslt->transformToXML($xml);
    }
    
     public function downloadMenuXML()
    {
        // Fetch the menu data
        $menuItems = DB::table('dishes')
                    ->join('categories', 'dishes.category_id', '=', 'categories.category_id')
                    ->select(
                        'dishes.dish_id', 
                        'dishes.dish_name', 
                        'categories.category_name', 
                        'dishes.dish_detail', 
                        'dishes.dish_image', 
                            'dishes.full_price',
                            'dishes.half_price',
                        'dishes.created_at as added_on'
                    )
                    ->get();

        // Generate XML structure
        $xmlData = $this->generateMenuXML($menuItems);

        // Return the XML response with appropriate headers for download
        return response()->stream(
            function () use ($xmlData) {
                echo $xmlData;
            },
            200,
            [
                'Content-Type' => 'application/xml',
                'Content-Disposition' => 'attachment; filename="menu.xml"',
            ]
        );
    }
    
}

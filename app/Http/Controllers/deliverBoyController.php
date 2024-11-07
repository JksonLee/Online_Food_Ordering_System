<?php

namespace App\Http\Controllers;

use App\Models\DeliverBoy;
use Illuminate\Http\Request;

class deliverBoyController extends Controller
{
    public function index()
    {
        return view('BackEnd.deliveryBoy.add');
    }
    
    public function save_boy(Request $request)
    {
        
      $boy = new DeliverBoy();//Get from the Model der
     
      $boy->delivery_boy_name = $request->delivery_boy_name;
      $boy->delivery_boy_phone_number = $request->delivery_boy_phone_number;
      $boy->delivery_boy_password = $request->delivery_boy_password;
      $boy->delivery_boy_status = $request->delivery_boy_status;
      $boy->added_on = $request->added_on;
      $boy->save();
      
      return back()->with('sms','Boy Saved');
    }
          
   public function boy_manage()
   {
      $boys = DeliverBoy::all();
      return view('BackEnd.deliveryBoy.manage',compact('boys'));
   } 
    
    public function boy_delete($delivery_boy_id)
    {
        $boy = DeliverBoy::find($delivery_boy_id);
    
        $boy->delete();
        
        return back()->with('sms','Delivery Boy Deleted');
        
    }
   
     public function boy_inactive($delivery_boy_id)
    {
        $boy = DeliverBoy::find($delivery_boy_id);
    
        $boy->delivery_boy_status = 0;
        $boy ->save();
        
        return back();
        
    }
    
        public function boy_active($delivery_boy_id)
    {
        $boy = DeliverBoy::find($delivery_boy_id);
    
        $boy->delivery_boy_status = 1;
        $boy ->save();
        
        return back();
        
    }
    
       public function boy_update(Request $request)
    {
        $boy = DeliverBoy::find($request->delivery_boy_id);
    
        $boy->delivery_boy_name = $request->delivery_boy_name;
        $boy->delivery_boy_phone_number = $request->delivery_boy_phone_number;
        $boy->save();
        
        return back()->with('sms','Boy updated');
        
    }
    
    
}

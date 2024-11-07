<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    protected $fillable = 
        [
         'dish_name',
         'dish_detail',
         'dish_image',
         'dish_status',
        
       
        ];
    
    protected $primaryKey = 'dish_id';
    
      // Define the relationship to the Rating model
    public function ratings() {
        return $this->hasMany(Rating::class, 'dish_id', 'dish_id');
    }
    
        // Calculate the average rating
    public function averageRating() {
        return $this->ratings()->avg('rating');
    }
    
  public function coupons()
{
    return $this->hasMany(Coupon::class, 'dish_id', 'dish_id');
}
    
    
}

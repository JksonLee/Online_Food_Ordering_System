<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    
    
    protected $fillable = [
        'customer_id',
        'dish_id',
        'rating',
        'review',
    ];

    // Define relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class,'dish_id');
    }
}

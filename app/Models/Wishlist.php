<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'dish_id'];

    // Define the relationship to the Customer model
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Define the relationship to the Dish model
    public function dish()
    {
        return $this->belongsTo(Dish::class, 'dish_id');
    }
}
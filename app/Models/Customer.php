<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'customer_id';
    
     public function ratings()
    {
        return $this->hasMany(Rating::class, 'customer_id');
    }
    
     public function payments()
    {
        return $this->hasMany(Payment::class, 'customer_id');  // Assuming 'customer_id' is the foreign key in the payments table
    }
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliverBoy extends Model
{
protected $fillable = 
        [
         'delivery_boy_name',
         'delivery_boy_phone_number',
         'delivery_boy_password',
         'delivery_boy_status',
         'added_on' 
        ];

protected $primaryKey = 'delivery_boy_id';
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays (e.g., when converting to JSON).
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Automatically cast certain attributes to specific data types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Specify the table name if it differs from 'admins'
    // protected $table = 'custom_admin_table';
}

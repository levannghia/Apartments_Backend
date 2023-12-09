<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartments extends Model
{
    use HasFactory;

    protected $fillable = [
        'bathrooms',
        'bedrooms',
        'property_id',
        'rent',
        'sqft',
        'unit',
    ];
}

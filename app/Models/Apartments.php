<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartments extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'bathrooms',
        'bedrooms',
        'property_id',
        'rent',
        'sqft',
        'unit',
    ];

    public function properties() {
        return $this->belongsTo(Properties::class);
    }

    public function galleries()
    {
        return $this->morphMany(Galleries::class, 'galleryable');
    }
}

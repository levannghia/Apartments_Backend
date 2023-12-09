<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Properties extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'rent_high',
        'rent_low',
        'bedroom_low',
        'bedroom_high',
        'city',
        'state',
        'street',
        'zip',
        'lat',
        'lng',
        'stars',
        'about',
    ];

    public function setNameAttribute($value){
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}

<?php

namespace App\Models;

use App\Http\Resources\PropertiesResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Galleries;

class Properties extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'rent_high',
        'rent_low',
        'bedroom_low',
        'bedroom_high',
        'city_id',
        'state_id',
        'street_id',
        'website',
        'zip',
        'lat',
        'lng',
        'stars',
        'about',
        'phone_number',
    ];

    public function setNameAttribute($value){
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function apartments(){
        return $this->hasMany(Apartments::class, 'property_id');
    }

    public function galleries()
    {
        return $this->morphMany(Galleries::class, 'galleryable');
    }

    public function city(){
        return $this->hasOne(City::class, 'matp', 'city_id');
    }

    public function state(){
        return $this->hasOne(State::class, 'maqh', 'state_id');
    }

    public function street(){
        return $this->hasOne(Street::class, 'xaid', 'street_id');
    }

    public function getResource()
    {
        return new PropertiesResource($this);
    }
}

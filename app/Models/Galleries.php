<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galleries extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
    ];

    public function galleryable()
    {
        return $this->morphTo();
    }
}

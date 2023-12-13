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

    public function getFileSize()
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = $this->size > 0 ? floor(log($this->size, 1024)) : 0;

        return number_format($this->size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }
}

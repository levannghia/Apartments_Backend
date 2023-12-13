<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'xaid';
    protected $table = "xa_phuong_thi_tran";
}

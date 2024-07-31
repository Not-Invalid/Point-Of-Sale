<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'brand_name',
        'brand_image'
    ];

    protected $table = 'brand';
    protected $primaryKey = 'brand_id';
    public $incrementing = false; 
    protected $keyType = 'string'; 
}
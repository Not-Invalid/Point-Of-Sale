<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_name',
        'desc_product',
        'stock',
        'unit_price',
        'id_brand',
        'id_category',
        'product_image'
    ];

    protected $table = 'products';
    protected $primaryKey = 'product_id';
    public $incrementing = false; 
    protected $keyType = 'string'; 

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'id_brand');
    }

    public function categories()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }
}

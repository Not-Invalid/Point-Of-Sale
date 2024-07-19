<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_number',
        'product_name', 
        'id_brand', 
        'id_category', 
        'qty', 
        'unit_price',
        'total'
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'id_brand');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }
    
    
    protected $table = 'transaction';
}

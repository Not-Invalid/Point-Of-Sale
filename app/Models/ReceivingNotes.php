<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivingNotes extends Model
{
    use HasFactory;

    protected $table = 'receiving_notes';

    protected $fillable = [
        'input_date',
        'product_id',
        'id_brand',
        'id_category',
        'quantity',
        'description',
        'remarks_references',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'id_brand', 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category', 'category_id');
    }
}

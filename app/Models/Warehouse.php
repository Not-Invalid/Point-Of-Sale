<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id',
        'warehouse_name',
        'location'
    ];

    protected $table = 'warehouse';
    protected $primaryKey = 'warehouse_id';
    public $incrementing = false; 
    protected $keyType = 'string'; 

}

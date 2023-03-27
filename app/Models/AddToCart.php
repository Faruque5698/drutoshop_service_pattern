<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class AddToCart extends Model
{
    use HasFactory;

    public function products()
    {
    	return $this->belongsTo(Product::class, 'product_id','id');
    }

    protected $casts = [
        'user_id' => 'integer',
        'product_id' => 'integer',
        'product_quantity' => 'integer',

        'product_price' => 'double:2',
        'product_total_price' => 'double:2',
    ];
}

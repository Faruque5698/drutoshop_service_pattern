<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavouriteProduct extends Model
{
    use HasFactory;
    protected $casts = ['product_id'=>"integer"];

    public function products(){
        return $this->belongsTo(Product::class, 'product_id','id');
    }
}

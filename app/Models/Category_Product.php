<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_Product extends Model
{
    protected $table = "category_product";

    protected $fillable = ['category_id', 'product_id'];

    public function Category(){
        return $this->belongsTo(Category::class);
    }

    public function Product(){
        return $this->belongsTo(Product::class);
    }
}

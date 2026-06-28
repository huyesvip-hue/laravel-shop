<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\ProductVariant;
class Product extends Model
{
    protected $fillable = [
    'name',
    'category_id',
    'price',
    'sale_price',
    'description',
    'thumbnail',
    'status'
];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}

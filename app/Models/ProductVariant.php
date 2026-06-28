<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Color;
use App\Models\Size;
use App\Models\Product;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'color_id',
        'size_id',
        'stock',
        'price_adjust'
    ];

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
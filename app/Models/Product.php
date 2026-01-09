<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['brand_id', 'category_id', 'product_code', 'product_name', 'description', 'paint_base', 'finish_type', 'volume', 'coverage_area', 'cost_price', 'price', 'stock_quantity', 'low_stock_alert', 'image_url', 'rating_avg', 'total_sold', 'is_featured', 'is_active'];

    protected $primaryKey = 'product_id';

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    public function productViews()
    {
        return $this->hasMany(ProductView::class, 'product_id');
    }
}

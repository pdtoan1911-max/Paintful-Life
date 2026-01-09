<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['brand_name', 'country_origin', 'logo_url', 'is_active'];

    protected $primaryKey = 'brand_id';

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }
}

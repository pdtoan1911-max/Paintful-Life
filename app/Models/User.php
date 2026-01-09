<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['email', 'password_hash', 'full_name', 'phone_number', 'address', 'city', 'user_type', 'is_active', 'last_login'];

    protected $primaryKey = 'user_id';

    protected $hidden = ['password_hash'];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function productViews()
    {
        return $this->hasMany(ProductView::class, 'user_id');
    }
}

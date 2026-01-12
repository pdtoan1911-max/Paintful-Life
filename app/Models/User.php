<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['email', 'password_hash', 'full_name', 'phone_number', 'address', 'city', 'user_type', 'is_active', 'last_login'];

    protected $primaryKey = 'user_id';

    protected $hidden = ['password_hash'];

    /**
     * Use custom password field for authentication.
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

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

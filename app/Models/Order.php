<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'order_code', 'customer_name', 'phone_number', 'shipping_address', 'city', 'subtotal', 'shipping_fee', 'total_amount', 'payment_method', 'payment_status', 'order_status', 'note'];

    protected $primaryKey = 'order_id';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorOrder extends Model
{
    use HasFactory;


    protected $fillable = [
        'status', 'country_id', 'user_name', 'user_id', 'order_id', 'total_price', 'total_commission', 'total_tax'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('warehouse_id', 'product_price', 'qty', 'commission', 'vendor_order_id', 'product_type', 'product_combination_id')
            ->withTimestamps();
    }



    public function country()
    {
        return $this->belongsTo(Country::class);
    }


    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('id', 'like', "%$search%")
                ->orWhere('total_price', 'like', "%$search%")
                ->orWhere('user_name', 'like', "%$search%")
                ->orWhere('total_commission', 'like', "%$search%")
                ->orWhere('order_id', 'like', "%$search%");
        });
    }


    public function scopeWhenCountry($query, $country_id)
    {
        return $query->when($country_id, function ($q) use ($country_id) {
            return $q->where('country_id', 'like', "%$country_id%");
        });
    }

    public function scopeWhenStatus($query, $status)
    {
        return $query->when($status, function ($q) use ($status) {
            return $q->where('Status', 'like', "%$status%");
        });
    }
    public function scopeWhenPaymentStatus($query, $payment_status)
    {
        return $query->when($payment_status, function ($q) use ($payment_status) {
            return $q->where('payment_status', 'like', "%$payment_status%");
        });
    }
}

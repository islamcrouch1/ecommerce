<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstallmentRequest extends Model
{
    use HasFactory;



    protected $fillable = [
        'name', 'installment_amount',  'product_price', 'installment_company_id', 'advanced_amount', 'admin_expenses', 'months', 'status', 'is_seen', 'product_combination_id', 'product_id', 'address',  'house', 'special_mark', 'block', 'avenue', 'floor_no', 'notes', 'user_id', 'session_id', 'phone', 'phone2', 'country_id', 'state_id', 'city_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function installment_company()
    {
        return $this->belongsTo(InstallmentCompany::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
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

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('name', 'like', "%$search%")
                ->orWhere('phone', 'like', "$search");
        });
    }
}

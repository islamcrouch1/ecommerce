<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_sent',  'due_date',  'is_seen', 'admin_id',  'order_id', 'serial', 'currency_id',  'discount_amount',  'discount_amount',  'payment_status',  'status',  'customer_id', 'branch_id', 'warehouse_id', 'notes', 'total_price', 'subtotal_price', 'shipping_amount', 'shipping_method_id'
    ];


    public function taxes()
    {
        return $this->belongsToMany(Tax::class)->withPivot('tax_id', 'amount');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('invoice_id', 'product_id', 'product_tax', 'unit_id', 'qty', 'total', 'cost', 'product_discount', 'product_wht', 'warehouse_id', 'product_combination_id', 'product_price')
            ->withTimestamps();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function scopeWhenBranch($query, $branch_id)
    {
        return $query->when($branch_id, function ($q) use ($branch_id) {
            return $q->where('branch_id', 'like', "%$branch_id%");
        });
    }

    public function scopeWhenOrder($query, $order_id)
    {
        return $query->when($order_id, function ($q) use ($order_id) {
            return $q->where('order_id', 'like', "%$order_id%");
        });
    }


    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('id', 'like', "%$search%")
                ->orWhere('total_price', 'like', "%$search%")
                ->orWhere('serial', 'like', "%$search%");
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

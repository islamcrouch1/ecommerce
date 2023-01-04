<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'seo_meta_tag', 'digital_file', 'product_weight', 'product_type', 'discount_price', 'video_url', 'product_slug', 'product_max_order', 'product_min_order', 'is_featured', 'on_sale', 'brand_id', 'seo_desc', 'name_en', 'name_ar', 'description_ar', 'description_en', 'vendor_price', 'max_price', 'extra_fee', 'sale_price', 'total_profit', 'country_id', 'created_by', 'status', 'updated_by', 'sku', 'unlimited', 'best_selling', 'top_collection', 'product_length', 'product_width', 'product_height', 'shipping_amount', 'shipping_method_id'
    ];

    // protected $appends = ['profit_percent'];

    public function vendor()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'ubdated_by');
    }


    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }


    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function affiliate_stocks()
    {
        return $this->hasMany(AffiliateStock::class);
    }

    public function fav()
    {
        return $this->hasMany(Favorite::class);
    }

    public function limits()
    {
        return $this->hasMany(Limit::class);
    }


    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function combinations()
    {
        return $this->hasMany(ProductCombination::class);
    }



    public function carts()
    {
        return $this->belongsToMany(Cart::class)
            ->withPivot('stock_id', 'price', 'quantity', 'vendor_price', 'product_type')
            ->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class)
            ->withPivot('category_id');
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class)
            ->withPivot('brand_id');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)
            ->withPivot('attribute_id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }


    public function aorder()
    {
        return $this->belongsTo(Aorder::class);
    }


    public function vendor_orders()
    {
        return $this->belongsToMany(Vorder::class)
            ->withPivot('stock_id', 'price', 'quantity', 'total', 'vendor_order_id')
            ->withTimestamps();
    }




    public static function getProducts($status = null, $category_id = null)
    {
        if (Auth::user()->HasRole('vendor')) {

            if ($category_id == null) {
                $products = Product::select('products.id', 'sku', 'vendor_id', 'status', 'country_id', 'name_ar', 'name_en', 'description_ar', 'description_en', 'vendor_price', 'extra_fee')->where('vendor_id', Auth::user()->id)->get()->toArray();
            } else {
                $products = Product::where('vendor_id', Auth::user()->id)
                    ->when($category_id, function ($q) use ($category_id) {
                        return $q->whereHas('categories', function ($query) {
                            $query->where('category_id', 'like', request()->category_id);
                        });
                    })->select('products.id', 'sku', 'vendor_id', 'status', 'country_id', 'name_ar', 'name_en', 'description_ar', 'description_en', 'vendor_price', 'extra_fee')->get()->toArray();
            }
        } else {

            if ($category_id == null) {
                $products = Product::select('products.id', 'sku', 'vendor_id', 'status', 'country_id', 'name_ar', 'name_en', 'description_ar', 'description_en', 'vendor_price', 'extra_fee')->get()->toArray();
            } else {
                $products = Product::when($category_id, function ($q) use ($category_id) {
                    return $q->whereHas('categories', function ($query) {
                        $query->where('category_id', 'like', request()->category_id);
                    });
                })->select('products.id', 'sku', 'vendor_id', 'status', 'country_id', 'name_ar', 'name_en', 'description_ar', 'description_en', 'vendor_price', 'extra_fee')->get()->toArray();
            }

            // $products = DB::table('products')->where('status', $status == null ? '!=' : '=', $status)
            //     ->join('category_product', function ($q) {
            //         $q->on('category_product.product_id', '=', 'products.id');
            //     })->where('category_product.category_id', $category_id == null ? '!=' : '=', $category_id)
            //     ->select('products.id', 'sku', 'vendor_id', 'status', 'country_id', 'name_ar', 'name_en', 'description_ar', 'description_en', 'vendor_price', 'extra_fee')->get()->toArray();
        }

        foreach ($products as $index => $product) {

            $color_str = '';
            $size_str = '';
            $stock_str = '';
            $image_str = '';


            $stocks = Stock::where('product_id', $product['id'])->get();


            $stocks1 = $stocks->unique('color_id');
            $stocks2 = $stocks->unique('size_id');

            foreach ($stocks1 as $stock) {
                $color_str .= $stock->color_id . ',';
            }

            foreach ($stocks2 as $stock) {
                $size_str .= $stock->size_id . ',';
            }

            foreach ($stocks as $stock) {
                $stock_str .= $stock->quantity . ',';
            }

            $color_str =   substr($color_str, 0, -1);
            $size_str =   substr($size_str, 0, -1);
            $stock_str =  substr($stock_str, 0, -1);

            $products[$index]['colors'] = $color_str;
            $products[$index]['sizes'] = $size_str;
            $products[$index]['stock'] = $stock_str;

            $images = ProductImage::where('product_id', $product['id'])->get();

            foreach ($images as $image) {
                $image_str .= 'https://sonoo.online/storage/images/products/' . $image->url . ',';
            }

            $image_str =  substr($image_str, 0, -1);
            $products[$index]['images'] = $image_str;

            if ($status != null) {
                if ($products[$index]['status'] != $status) {
                    unset($products[$index]);
                }
            }
        }

        $description_ar =  'تم تنزيل شيت المنتجات';
        $description_en  = 'Product file has been downloaded ';
        addLog('admin', 'exports', $description_ar, $description_en);

        return $products;
    }

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('name_ar', 'like', "%$search%")
                ->orWhere('name_en', 'like', "%$search%")
                ->orWhere('description_ar', 'like', "%$search%")
                ->orWhere('description_en', 'like', "%$search%")
                ->orWhere('SKU', 'like', "%$search%");
        });
    }

    public function scopeWhenCategory($query, $category_id)
    {
        if ($category_id == null) {
            return $query;
        } else {
            return $query->when($category_id, function ($q) use ($category_id) {
                return $q->whereHas('categories', function ($query) {
                    $query->where('category_id', 'like', request()->category_id);
                });
            });
        }
    }



    public function scopeWhenStatus($query, $status)
    {
        return $query->when($status, function ($q) use ($status) {
            return $q->where('Status', 'like', "%$status%");
        });
    }


    public function scopeWhenCountry($query, $country_id)
    {
        return $query->when($country_id, function ($q) use ($country_id) {
            return $q->where('country_id', 'like', "$country_id");
        });
    }
}

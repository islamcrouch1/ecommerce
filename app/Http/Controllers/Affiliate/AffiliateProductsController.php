<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Country;
use App\Models\Product;
use App\Models\Slide;
use Illuminate\Http\Request;

class AffiliateProductsController extends Controller
{
    public function index()
    {
        $country = Country::findOrFail(Auth()->user()->country_id);
        $slides1 = Slide::where('slider_id', 1)->get();
        $slides2 = Slide::where('slider_id', 2)->get();
        $slides3 = Slide::where('slider_id', 3)->get();


        $categories = Category::where('country_id', $country->id)
            ->where('parent_id', null)
            ->get();

        $products = Product::where('country_id', $country->id)
            ->whereHas('stocks', function ($query) {
                $query->where('quantity', '!=', '0');
            })
            ->where('status', "active")
            ->whenSearch(request()->search)
            ->latest()
            ->paginate(20);

        return view('affiliate.products.index', compact('categories', 'products', 'slides1', 'slides2', 'slides3'));
    }

    public function showProduct(Product $product)
    {
        $scountry = Country::findOrFail(Auth()->user()->country_id);
        $categories = Category::with('products')
            ->where('country_id', $scountry->id)
            ->where('parent_id', $product->categories()->first()->id)
            ->get();
        return view('affiliate.products.product', compact('categories', 'product'));
    }


    public function showCatProducts($category)
    {
        $country = Country::findOrFail(Auth()->user()->country_id);
        $scategory = Category::find($category);

        $slides1 = Slide::where('slider_id', 1)->get();
        $slides2 = Slide::where('slider_id', 2)->get();
        $slides3 = Slide::where('slider_id', 3)->get();

        $cat = $scategory->id;

        $products = Product::whereHas('categories', function ($query) use ($cat) {
            $query->where('category_id', 'like', $cat);
        })
            ->whereHas('stocks', function ($query) {
                $query->where('quantity', '!=', '0');
            })
            ->where('country_id', $country->id)
            ->where('status', "active")
            ->whenSearch(request()->search)
            ->paginate(20);

        $categories = Category::with('products')
            ->where('country_id', $country->id)
            ->where('parent_id', $scategory->id)
            ->get();

        return view('affiliate.products.index', compact('categories', 'products', 'scategory', 'slides1', 'slides2', 'slides3'));
    }
}

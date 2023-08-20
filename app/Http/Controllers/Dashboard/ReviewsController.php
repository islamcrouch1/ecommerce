<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:reviews-read')->only('index', 'show');
        $this->middleware('permission:reviews-create')->only('create', 'store');
        $this->middleware('permission:reviews-update')->only('edit', 'update');
        $this->middleware('permission:reviews-delete|reviews-trash')->only('destroy', 'trashed');
        $this->middleware('permission:reviews-restore')->only('restore');
    }


    public function index()
    {
        return view('dashboard.reviews.index');
    }


    public function reviewsDelete(Request $request)
    {

        $request->validate([
            'review' => "required|string|max:255",
        ]);


        $reviews = Review::where('session_id', '100094')->where('review', $request->review)->get();

        foreach ($reviews as $review) {
            $review->delete();
        }

        alertSuccess('review deleted successfully', 'تم حذف التقييمات بنجاح');
        return redirect()->route('reviews.index');
    }



    public function store(Request $request)
    {

        $request->validate([
            'rating' => "required|numeric|lt:5.1|gt:0",
            'review' => "required|string|max:255",
            'products' => "nullable|array",
            'categories' => "nullable|array",
        ]);


        if (!isset($request->products)) {
            $products = [];
        } else {
            $products = $request->products;
        }


        if (!isset($request->categories)) {
            $categories = [];
        } else {
            $categories = $request->categories;
        }



        $products = Product::where(function ($query) use ($products, $categories) {
            $query->whereIn('id', $products)
                ->orWhereIn('category_id', $categories);
        })

            ->get();


        foreach ($products as $product) {
            $review = Review::create([
                'product_id' => $product->id,
                'rating' => $request->rating,
                'review' => $request->review,
                'session_id' => '100094',
            ]);
        }





        alertSuccess('review created successfully', 'تم اضافة التقييم بنجاح');
        return redirect()->route('reviews.index');
    }
}

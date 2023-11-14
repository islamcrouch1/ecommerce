<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Product;
use App\Models\ProductCombination;
use App\Models\ProductCombinationDtl;
use App\Models\Slide;
use App\Models\Testimonial;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Twilio\Rest\Client;


class EcommerceHomeController extends Controller
{




    public function index(Request $request)
    {



        // if ($request->path() == '/' || $request->path() == 'home') {
        // } else {
        //     return;
        // }



        // snapchatEvent('ADD_CART');


        $country = getCountry();

        // if (Auth::check()) {
        //     $cart_items = CartItem::where('user_id', Auth::id())->get();
        // } else {
        //     $cart_items = CartItem::where('session_id', $request->session()->token())->get();
        // }

        // $categories = Category::whereNull('parent_id')->where('country_id', $country->id)->orderBy('sort_order', 'asc')->get();


        $slides = Slide::where('slider_id', '3')->orderBy('sort_order', 'asc')->get();

        // $products = Product::whereHas('stocks', function ($query) {
        //     $query->where('qty', '!=', '0');
        // })
        //     ->where('status', "active")
        //     ->whenSearch(request()->search)
        //     ->latest()
        //     ->paginate(20);


        $top_collections = getTopCollections();
        $best_selling = getBestSelling();
        $is_featured = getIsFeatured();
        $on_sale = getOnSale();

        $testimonials = Testimonial::where('country_id', $country->id)->get();


        addViewRecord();



        return view('ecommerce.home', compact('slides', 'top_collections', 'best_selling', 'is_featured', 'on_sale', 'testimonials'));
    }






    public function about(Request $request)
    {
        addViewRecord();
        return view('ecommerce.about');
    }

    public function contact(Request $request)
    {
        addViewRecord();


        $n1 = rand(0, 10);
        $n2 = rand(0, 10);

        return view('ecommerce.contact', compact('n1', 'n2'));
    }

    public function terms(Request $request)
    {
        addViewRecord();
        return view('ecommerce.terms');
    }


    public function getProductPrice(Request $request)
    {

        $request->validate([
            'variations' => "required|string",
            'product_id' => "required|string",
        ]);



        $product = Product::findOrFail($request->product_id);
        $attributes_count = $product->attributes->count();
        $variations = explode(",", $request->variations);
        $selected_attributes_count = count($variations);

        if ($selected_attributes_count < $attributes_count) {
            return 1;
        } elseif ($selected_attributes_count = $attributes_count) {
            $combinations = ProductCombination::where('product_id', $product->id)->get();

            foreach ($combinations as $combination) {
                $count = $combination->variations->whereIn('variation_id', $variations);
                $count =  count($count);
                if ($count == $selected_attributes_count) {

                    $product = $combination->product;
                    return getProductPrice($product, $combination);
                }
            }
        } else {
            return 2;
        }
    }


    public function whatsapp()
    {


        $otp = rand(1000, 9999);
        $recipient = '+201121184148';
        $link = "https://yfbstore.com/ecommerce/product/61";

        $twilio_whatsapp_number = getenv("TWILIO_WHATSAPP_NUMBER");
        $account_sid = getenv("TWILIO_ACCOUNT_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKENN");

        $client = new Client($account_sid, $auth_token);
        $message = "Your registration tyttty pin code is $otp and your link is $link";
        return $client->messages->create("whatsapp:$recipient", array('from' => "whatsapp:$twilio_whatsapp_number", 'body' => $message));
    }




    public function contactCreate(Request $request)
    {

        $request->validate([
            'name' => "required|string|max:255",
            'phone' => "required|string|max:255",
            'message' => "required|string",
            'n1' => "required|integer",
            'n2' => "required|integer",
            'answer' => "required|integer",
        ]);


        if ($request->n1 + $request->n2 == $request->answer) {
            $contact = Contact::create([
                'user_id' => Auth::check() ? Auth::id() : null,
                'name' => $request->name,
                'phone' => $request->phone,
                'message' => $request->message,
            ]);
            alertSuccess('The message has been sent successfully', 'تم ارسال الرسالة بنجاح');
        } else {
            alertSuccess('Error in sending, try again later', 'حدث خطا اثناء الارسال يرجى المحاولة لاحقا');
        }

        return redirect()->route('ecommerce.contact');
    }
}

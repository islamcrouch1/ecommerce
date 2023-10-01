<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Attribute;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Country;
use App\Models\Entry;
use App\Models\InstallmentCompany;
use App\Models\Product;
use App\Models\ProductCombination;
use App\Models\ProductCombinationDtl;
use App\Models\ProductImage;
use App\Models\ProductVariation;
use App\Models\ShippingMethod;
use App\Models\Size;
use App\Models\Stock;
use App\Models\Unit;
use App\Models\User;
use App\Models\Variation;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Goutte;
use Drnxloc\LaravelHtmlDom\HtmlDomParser;
use Spatie\Crawler\Crawler;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator|affiliate|vendor');
        $this->middleware('permission:products-read')->only('index', 'show');
        $this->middleware('permission:products-create')->only('create', 'store');
        $this->middleware('permission:products-update|products-trash')->only('edit', 'update');
        $this->middleware('permission:products-delete|products-trash')->only('destroy', 'trashed');
        $this->middleware('permission:products-restore')->only('restore');
    }


    public function urlImport()
    {



        // ->setNodeBinary('C:\Programs\\nodejs\\node.exe')
        // ->setNpmBinary('/C:/Program Files/nodejs/node_modules/npm/bin')


        $url = 'https://ar.aliexpress.com/item/1005005279555903.html';
    }


    public function index()
    {
        $categories = Category::whereNull('parent_id')->get();
        $countries = Country::all();


        $user = Auth::user();

        $products = Product::where('vendor_id', null)
            ->whenSearch(request()->search)
            ->whenCategory(request()->category_id)
            ->whenCountry(request()->country_id)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(100);


        foreach ($products as $product) {
            checkProductUnit($product);
        }

        return view('dashboard.products.index', compact('products', 'categories', 'countries', 'user'));
    }





    public function deleteMedia(Request $request)
    {

        $request->validate([
            'media_id' => "required|integer",
            'image_id' => "required|integer",
        ]);

        deleteImage($request->media_id);
        $image = ProductImage::findOrFail($request->image_id);
        $image->delete();

        return 1;
    }


    public function vendorsIndex()
    {
        $categories = Category::whereNull('parent_id')->get();
        $countries = Country::all();

        $is_vendors = true;

        $products = Product::whereNotNull('vendor_id')
            ->whenSearch(request()->search)
            ->whenCategory(request()->category_id)
            ->whenCountry(request()->country_id)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(100);

        return view('dashboard.products.index', compact('products', 'categories', 'countries', 'is_vendors'));
    }

    public function show(Product $product)
    {
        $scountry = Country::findOrFail(Auth()->user()->country_id);

        $categories = Category::with('products')
            ->where('country_id', $scountry->id)
            ->where('parent', $product->categories()->first()->id)
            ->get();

        return view('dashboard.products.show', compact('categories', 'product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();
        $countries = Country::all();
        $brands = Brand::where('status', 'active')->get();
        $attributes = Attribute::all();
        $shipping_methods = ShippingMethod::whereIn('id', [1, 2, 3])->get();
        $installment_companies = InstallmentCompany::all();
        $units = Unit::all();
        return view('dashboard.products.create', compact('attributes', 'units', 'categories', 'countries', 'brands', 'shipping_methods', 'installment_companies'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $request->validate([
            'name_ar' => "required|string",
            'name_en' => "required|string",
            'sku' => "nullable|string|unique:products",
            'product_slug' => "nullable|string|unique:products",
            'images' => "nullable|array",
            'category' => "required|string",
            'description_ar' => "nullable|string",
            'description_en' => "nullable|string",
            'sale_price' => "required|numeric|gte:0",
            'discount_price' => "required|numeric|gte:0",
            'categories' => "nullable|array",
            'brands' => "nullable|array",
            'product_type' =>  "required|string",
            'digital_file' => "nullable|file",
            'status' => "required|string",
            'video_url' => "nullable|string",
            'attributes' => "nullable|array",
            'product_min_order' => "required|numeric|gte:0",
            'product_max_order' => "required|numeric|gte:0",
            'extra_fee'  => "nullable|numeric",
            'seo_meta_tag' => "nullable|string",
            'seo_desc' => "nullable|string",
            'product_weight' => "nullable|numeric|gte:0",
            'product_length' => "nullable|numeric|gte:0",
            'product_width' => "nullable|numeric|gte:0",
            'product_height'  => "nullable|numeric|gte:0",
            'shipping_amount' => "nullable|numeric|gte:0",
            'shipping_method' => "nullable|string",
            'cost' => "nullable|numeric|gte:0",
            'image' => "nullable|image",
            'installment_companies' => "nullable|array",

            'code' => "nullable|string",
            'can_sold' => "nullable|string",
            'can_purchased' => "nullable|string",
            'can_manufactured' => "nullable|string",

            'unit_id' => "required|integer",

        ]);


        $product_type = $request['product_type'];
        $slug = createSlug($request->product_slug ? $request->product_slug : ($request->name_ar . '-' . $request->name_en));

        // for digital product
        if ($product_type == 'digital' && !$request->hasFile('digital_file')) {
            alertError('please upload digital file', 'يرجى ارفاق الملف الرقمي للمنتج الرقمي');
            return redirect()->back()->withInput();
        }

        if ($product_type == 'digital' && $request->hasFile('digital_file')) {
            $path = storeFile($request->file('digital_file'), 'products');
        }

        if ($request->sale_price < $request->discount_price) {
            alertError('discount price must be lower than regular price', 'يجب ان يكون سعر الخصم اقل من السعر العادي');
            return redirect()->back()->withInput();
        }


        // for variable product
        if ($product_type == 'variable') {
            if (empty($request['attributes'])) {
                alertError('please select product attribute', 'يرجى تحديد سمات المنتج');
                return redirect()->back()->withInput();
            } else {
                foreach ($request['attributes'] as $attr) {
                    if (empty($request['variations-' . $attr])) {
                        alertError('please select product variations', 'يرجى تحديد متغيرات المنتج');
                        return redirect()->back()->withInput();
                    }
                }
            }
        }


        if ($request->hasFile('image')) {
            $media_id = saveMedia('image', $request['image'], 'products');
        }



        $category = Category::find($request->category);


        $product = Product::create([
            'created_by' => Auth::id(),
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'category_id' => $request['category'],
            'media_id' => isset($media_id) ? $media_id : null,
            'product_slug' => $slug,
            'sku' => $request['sku'],
            'description_ar' => $request['description_ar'],
            'description_en' => $request['description_en'],
            'sale_price' => $request['sale_price'],
            'discount_price' => $request['discount_price'],
            'product_type' => $product_type,

            'product_weight' =>  $request['product_weight'],
            'product_length' =>  $request['product_length'],
            'product_width' =>  $request['product_width'],
            'product_height' =>  $request['product_height'],
            'shipping_amount' =>  $request['shipping_amount'],
            'shipping_method_id' =>  $request['shipping_method'],

            'video_url' => $request['video_url'],
            'product_min_order' => $request['product_min_order'],
            'product_max_order' => $request['product_max_order'],
            'seo_meta_tag' => $request['seo_meta_tag'],
            'seo_desc' => $request['seo_desc'],
            'extra_fee' => $request['extra_fee'],
            'digital_file' => isset($path) ? $path : null,
            'country_id' => $category->country_id,
            'status' => $request['status'],

            'code' => $request['code'],
            'can_sold' => $request['can_sold'],
            'can_purchased' => $request['can_purchased'],
            'can_manufactured' => $request['can_manufactured'],

            'unit_id' => $request['unit_id'],

            'cost' => ($product_type == 'digital' || $product_type == 'service') ? $request['cost'] : 0,
        ]);



        $product->categories()->attach($request['categories']);
        $product->brands()->attach($request['brands']);
        $product->installment_companies()->sync($request->installment_companies);




        if ($request->duplicate && !isset($request->images)) {
            $ref_product = Product::find($request->ref_product);

            foreach ($ref_product->images as $image) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'media_id' => $image->media_id,
                ]);
            }
        } else {
            if ($files = $request->file('images')) {
                foreach ($files as $file) {
                    $media_id = saveMedia('image', $file, 'products');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'media_id' => $media_id,
                    ]);
                }
            }
        }


        if ($product_type == 'variable') {

            $product->attributes()->attach($request['attributes']);

            $combination_array = [];

            foreach ($request['attributes'] as $attr) {
                foreach ($request['variations-' . $attr] as $var) {
                    ProductVariation::create([
                        'attribute_id' => $attr,
                        'variation_id' => $var,
                        'product_id' => $product->id
                    ]);
                }

                $combination_array[] = $request['variations-' . $attr];
            }

            $arrays = getCombinations($combination_array);

            if (!is_array($arrays[0])) {
                $array = $arrays;
                unset($arrays);
                foreach ($array as $index => $item) {
                    $arrays[$index][] = $item;
                }
            }



            foreach ($arrays as $key => $array) {
                $com = ProductCombination::create([
                    'product_id' => $product->id,
                    'sku' => ($product->sku != null ? $product->sku : $product->id) . '-' . ($key + 1),
                    'discount_price' => $product->discount_price,
                    'sale_price' => $product->sale_price,
                ]);

                foreach ($array as $variation) {
                    ProductCombinationDtl::create([
                        'product_combination_id' => $com->id,
                        'variation_id' => $variation,
                        'product_id' => $product->id,
                    ]);
                }
            }
        } elseif ($product_type == 'simple') {
            $com = ProductCombination::create([
                'product_id' => $product->id,
                'sku' => $product->sku,
                'discount_price' => $product->discount_price,
                'sale_price' => $product->sale_price,
            ]);
        }


        if ($request['limited'] == 'on') {
            $product->update([
                'unlimited' => '1',
            ]);
        }

        if ($request['is_featured'] == 'on') {
            $product->update([
                'is_featured' => '1',
            ]);
        }

        if ($request['on_sale'] == 'on') {
            $product->update([
                'on_sale' => '1',
            ]);
        }

        if ($request['top_collection'] == 'on') {
            $product->update([
                'top_collection' => '1',
            ]);
        }

        if ($request['best_selling'] == 'on') {
            $product->update([
                'best_selling' => '1',
            ]);
        }


        $description_ar = ' تم إضافة منتج ' . '  منتج رقم' . ' #' . $product->id . ' - SKU ' . $product->sku;
        $description_en  = "product added " . " product ID " . ' #' . $product->id . ' - SKU ' . $product->sku;
        addLog('admin', 'products', $description_ar, $description_en);


        alertSuccess('Product Created successfully', 'تم إنشاء المنتج بنجاح');
        return redirect()->route('products.index');

        // if ($product->product_type == 'simple' || $product->product_type == 'variable') {
        //     alertSuccess('Product Created successfully, Please enter stock details', 'تم إنشاء المنتج بنجاح, يرجى ادخال تفاصيل المخزون للمتغيرات');
        //     return redirect()->route('products.stock.create', ['product' => $product->id]);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($product)
    {
        $categories = Category::whereNull('parent_id')->get();
        $brands = Brand::where('status', 'active')->get();
        $countries = Country::all();
        $product = Product::find($product);
        $attributes = Attribute::all();
        $shipping_methods = ShippingMethod::whereIn('id', [1, 2, 3])->get();
        $installment_companies = InstallmentCompany::all();
        $units = Unit::all();
        return view('dashboard.products.edit', compact('categories', 'units', 'countries', 'product', 'brands', 'shipping_methods', 'attributes', 'installment_companies'));
    }


    public function duplicate(Product $product)
    {
        $categories = Category::whereNull('parent_id')->get();
        $brands = Brand::where('status', 'active')->get();
        $countries = Country::all();
        $attributes = Attribute::all();
        $shipping_methods = ShippingMethod::whereIn('id', [1, 2, 3])->get();
        return view('dashboard.products.duplicate', compact('categories', 'countries', 'product', 'brands', 'shipping_methods', 'attributes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {

        $request->validate([
            'name_ar' => "required|string",
            'name_en' => "required|string",
            'sku' => "nullable|string|unique:products,sku," . $product->id,
            // 'product_slug' => "required|string|unique:products,product_slug," . $product->id,
            'images' => "nullable|array",
            'category' => "required|string",
            'description_ar' => "nullable|string",
            'description_en' => "nullable|string",
            'sale_price' => "required|numeric|gte:0",
            'discount_price' => "required|numeric|gte:0",
            'categories' => "nullable|array",
            'brands' => "nullable|array",
            'digital_file' => "nullable|file",
            'status' => "required|string",
            'video_url' => "nullable|string",
            'attributes' => "nullable|array",
            'product_min_order' => "required|numeric|gte:0",
            'product_max_order' => "required|numeric|gte:0",
            'extra_fee'  => "nullable|numeric|gte:0",
            'seo_meta_tag' => "nullable|string",
            'seo_desc' => "nullable|string",

            'product_weight' => "nullable|numeric|gte:0",
            'cost' => "nullable|numeric|gte:0",
            'product_length' => "nullable|numeric|gte:0",
            'product_width' => "nullable|numeric|gte:0",
            'product_height'  => "nullable|numeric|gte:0",
            'shipping_amount' => "nullable|numeric|gte:0",
            'shipping_method' => "nullable|string",
            'image' => "nullable|image",
            'installment_companies' => "nullable|array",


            'code' => "nullable|string",
            'can_sold' => "nullable|string",
            'can_purchased' => "nullable|string",
            'can_manufactured' => "nullable|string",

        ]);



        $product_type = $product->product_type;
        $slug = createSlug($request->product_slug ? $request->product_slug : ($request->name_ar . '-' . $request->name_en));



        if ($request->sale_price < $request->discount_price) {
            alertError('discount price must be lower than regular price', 'يجب ان يكون سعر الخصم اقل من السعر العادي');
            return redirect()->back()->withInput();
        }

        if ($request->hasFile('digital_file') && $product_type == 'digital') {
            Storage::delete($product->digital_file);
            $path = storeFile($request->file('digital_file'), 'products');
        }



        if ($files = $request->file('images')) {
            foreach ($files as $file) {
                $media_id = saveMedia('image', $file, 'products');
                ProductImage::create([
                    'product_id' => $product->id,
                    'media_id' => $media_id,
                ]);
            }
        }


        // send notification to the vendor
        if ($product->vendor_id != null) {
            if ($product->status != $request->status) {

                $title_ar = 'اشعار من الإدارة';
                $title_en = 'Notification From Admin';

                switch ($request->status) {
                    case 'active':
                        $body_ar = "تم تغيير حالة المنتج الخاص بك الى نشط";
                        $body_en  = "Your product status has been changed to Active";
                        break;
                    case 'rejected':
                        $body_ar = "تم تغيير حالة المنتج الخاص بك الى مرفوض";
                        $body_en  = "Your product status has been changed to Rejected";
                        break;
                    case 'pause':
                        $body_ar = "تم تغيير حالة المنتج الخاص بك الى معطل مؤقتا";
                        $body_en  = "Your product status has been changed to pause";
                        break;
                    case 'pending':
                        $body_ar = "تم تغيير حالة المنتج الخاص بك الى معلق";
                        $body_en  = "Your product status has been changed to pending";
                        break;
                    default:
                        # code...
                        break;
                }

                $url = route('vendor-products.index');
                addNoty($product->vendor, Auth::user(), $url, $title_en, $title_ar, $body_en, $body_ar);
            }
        }


        if ($product_type == 'variable') {
            if (empty($request['attributes'])) {
                alertError('please select product attribute', 'يرجى تحديد سمات المنتج');
                return redirect()->back()->withInput();
            }

            // else {
            //     foreach ($request['attributes'] as $attr) {
            //         if (empty($request['variations-' . $attr])) {
            //             alertError('please select product variations', 'يرجى تحديد متغيرات المنتج');
            //             return redirect()->back()->withInput();
            //         }
            //     }
            // }

        }


        if ($request->hasFile('image')) {
            if ($product->media_id != null) {
                deleteImage($product->media_id);
            }
            $media_id = saveMedia('image', $request['image'], 'products');
            $product->update([
                'media_id' => $media_id,
            ]);
        }


        if ($product->category_id != $request['category']) {

            $branch_id = getUserBranchId(Auth::user());

            $new_category = Category::findOrFail($request['category']);

            foreach ($product->combinations as $combination) {

                $product_account = getItemAccount($combination, $new_category, 'assets_account', $branch_id);
                $cs_product_account = getItemAccount($combination, $new_category, 'cs_account', $branch_id);

                $product_account_old = getItemAccount($combination, $combination->product->category, 'assets_account', $branch_id);
                $cs_product_account_old = getItemAccount($combination, $combination->product->category, 'cs_account', $branch_id);


                $entries = $product_account_old->entries;

                foreach ($entries as $entry) {
                    $entry->update([
                        'account_id' => $product_account->id
                    ]);
                }

                $entries = $cs_product_account_old->entries;

                foreach ($entries as $entry) {
                    $entry->update([
                        'account_id' => $cs_product_account->id
                    ]);
                }
            }
        }


        $product->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'category_id' => $request['category'],
            'sku' => $request['sku'],
            // 'product_slug' => createSlug($request['product_slug']),
            'description_ar' => $request['description_ar'],
            'description_en' => $request['description_en'],
            'sale_price' => $request['sale_price'],
            'discount_price' => $request['discount_price'],

            'product_slug' => $slug,

            'product_weight' =>  $request['product_weight'],
            'product_length' =>  $request['product_length'],
            'product_width' =>  $request['product_width'],
            'product_height' =>  $request['product_height'],
            'shipping_amount' =>  $request['shipping_amount'],
            'shipping_method_id' =>  $request['shipping_method'],

            'video_url' => $request['video_url'],
            'product_min_order' => $request['product_min_order'],
            'product_max_order' => $request['product_max_order'],
            'seo_meta_tag' => $request['seo_meta_tag'],
            'seo_desc' => $request['seo_desc'],
            'extra_fee' => $request['extra_fee'],
            'status' => $request['status'],
            'extra_fee' => $request['extra_fee'],
            'updated_by' => Auth::id(),
            'digital_file' =>  isset($path) ? $path : null,

            'code' => $request['code'],
            'can_sold' => $request['can_sold'],
            'can_purchased' => $request['can_purchased'],
            'can_manufactured' => $request['can_manufactured'],

            'cost' => ($product_type == 'digital' || $product_type == 'service') ? $request['cost'] : 0,

            'unlimited' => $request['limited'] == 'on' ? '1' : '0',
            'on_sale' => $request['on_sale'] == 'on' ? '1' : '0',
            'is_featured' => $request['is_featured'] == 'on' ? '1' : '0',
            'top_collection' => $request['top_collection'] == 'on' ? '1' : '0',
            'best_selling' => $request['best_selling'] == 'on' ? '1' : '0',


        ]);



        if ($product->product_type == 'simple') {
            foreach ($product->combinations as $combination) {
                $combination->update([
                    'sku' => $request['sku'],
                    'sale_price' => $request['sale_price'],
                    'discount_price' => $request['discount_price'],
                ]);
            }
        }



        if ($product_type == 'variable') {

            $attributes = $request['attributes'];
            $variations = $product->variations->pluck('variation_id')->toArray();

            foreach ($product->attributes as $attribute) {

                if (!in_array($attribute->id, $attributes)) {
                    foreach ($attribute->variations as $variation) {
                        if (in_array($variation->id, $variations)) {
                            $combinations = $product->combinations()->whereHas('variations', function ($q) use ($variation) {
                                return $q->where('variation_id', $variation->id);
                            })->get();

                            foreach ($combinations as $combination) {
                                if ($combination->stocks->count() > 0) {
                                    alertError('The attribute cannot be deleted', 'لا يمكن حذف المتغير');
                                    return redirect()->back()->withInput();
                                }
                            }
                        }
                    }
                }
            }


            $product->attributes()->sync($request['attributes']);

            $attributes = $product->attributes->pluck('id')->toArray();

            $new_variations = [];

            $combination_array = [];

            foreach ($attributes as $attr) {
                if (isset($request['variations-' . $attr])) {
                    foreach ($request['variations-' . $attr] as $var) {

                        $variation = $product->variations()->where('variation_id', $var)->first();
                        if ($variation == null) {
                            ProductVariation::create([
                                'attribute_id' => $attr,
                                'variation_id' => $var,
                                'product_id' => $product->id
                            ]);
                        }
                        array_push($new_variations, $var);
                    }
                    $combination_array[$attr] = $request['variations-' . $attr];
                }
            }


            foreach ($variations as $variation) {

                $count = 0;

                if (!in_array($variation, $new_variations)) {
                    $combinations = $product->combinations()->whereHas('variations', function ($q) use ($variation) {
                        return $q->where('variation_id', $variation);
                    })->get();

                    foreach ($combinations as $combination) {
                        $av_qty = productQuantityWebsite($product->id, $combination->id, null, null);
                        if ($av_qty > 0) {
                            $count++;
                        } else {
                            foreach ($combination->variations as $com_var) {
                                $com_var->delete();
                            }
                            $combination->delete();
                        }
                    }

                    if ($count > 0) {
                        alertError('some attributes cannot be deleted', 'بعض المتغيرات لا يمكن حذفها');
                        $variation = Variation::findOrFail($variation);
                        array_push($combination_array[$variation->attribute_id], strval($variation->id));
                    } else {
                        $product->variations()->where('variation_id', $variation)->first()->delete();
                    }
                }
            }


            $combination_array = array_values($combination_array);


            $arrays = getCombinations($combination_array);


            if (!empty($arrays) && !is_array($arrays[0])) {
                $array = $arrays;
                unset($arrays);
                foreach ($array as $index => $item) {
                    $arrays[$index][] = $item;
                }
            }


            foreach ($arrays as $key => $array) {


                $count = count($array);


                $combinations = $product->combinations()->where(function ($q) use ($array) {
                    foreach ($array as $variation) {
                        $q->whereHas('variations', function ($q) use ($variation) {
                            $q->where('variation_id', $variation);
                        });
                    }

                    return $q;
                })->get();


                if ($combinations->count() == 0) {
                    $com = ProductCombination::create([
                        'product_id' => $product->id,
                        'sku' => $product->sku . '-' . ($key + 1),
                        'discount_price' => $product->discount_price,
                        'sale_price' => $product->sale_price,
                    ]);

                    foreach ($array as $variation) {
                        ProductCombinationDtl::create([
                            'product_combination_id' => $com->id,
                            'variation_id' => $variation,
                            'product_id' => $product->id,
                        ]);
                    }
                }
            }
        }


        $product->categories()->sync($request['categories']);
        $product->brands()->sync($request['brands']);
        $product->installment_companies()->sync($request->installment_companies);



        $description_ar = ' تم تعديل منتج ' . '  منتج رقم' . ' #' . $product->id . ' - SKU ' . $product->sku;
        $description_en  = "product updated " . " product ID " . ' #' . $product->id . ' - SKU ' . $product->sku;
        addLog('admin', 'products', $description_ar, $description_en);

        alertSuccess('Product updated successfully', 'تم تحديث المنتج بنجاح');

        if ($product->vendor_id == null) {
            return redirect()->route('products.index');
        } else {
            return redirect()->route('products.vendors');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($product)
    {


        $product = Product::withTrashed()->where('id', $product)->first();



        if ($product->trashed() && auth()->user()->hasPermission('products-delete')) {
            if ($product->product_type == 'digital') {
                Storage::disk('public')->delete($product->digital_file);
            }
            foreach ($product->images as $image) {

                deleteImage($image->media->id);
                $image->delete();
            }
            foreach ($product->stocks as $stock) {
                if ($stock->image != null) {
                    Storage::disk('public')->delete('/images/products/' . $stock->image);
                    $stock->delete();
                }
            }
            $product->forceDelete();
            alertSuccess('product deleted successfully', 'تم حذف المنتج بنجاح');
            return redirect()->route('products.trashed');
        } elseif (!$product->trashed() && auth()->user()->hasPermission('products-trash') && checkProductForTrash($product)) {
            $product->delete();
            alertSuccess('product trashed successfully', 'تم حذف المنتج مؤقتا');
            return redirect()->route('products.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the product cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو المنتج لا يمكن حذفها حاليا');
            return redirect()->back()->withInput();
        }
    }


    public function trashed()
    {


        $categories = Category::whereNull('parent_id')->get();
        $countries = Country::all();


        $user = Auth::user();

        $products = Product::onlyTrashed()
            ->where('vendor_id', null)
            ->whenSearch(request()->search)
            ->whenCategory(request()->category_id)
            ->whenCountry(request()->country_id)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(100);


        return view('dashboard.products.index', compact('user', 'products', 'categories', 'countries'));
    }

    public function restore($product)
    {
        $product = Product::withTrashed()->where('id', $product)->first()->restore();
        alertSuccess('Product restored successfully', 'تم استعادة المنتج بنجاح');
        return redirect()->route('products.index');
    }

    public function stockCreate($product)
    {

        $user = Auth::user();

        $warehouses = Warehouse::where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
            ->where('vendor_id', null)
            ->get();
        $product = Product::findOrFail($product);
        return view('dashboard.products.stock', compact('product', 'warehouses'));
    }

    public function variableCreate($product)
    {
        $product = Product::findOrFail($product);
        return view('dashboard.products.variables', compact('product'));
    }

    public function stockProductCreate()
    {
        $user = Auth::user();

        $warehouses = Warehouse::where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
            ->where('vendor_id', null)
            ->get();
        $product = Product::findOrFail(request()->product);
        return view('dashboard.products.stock', compact('product', 'warehouses'));
    }

    public function stockStore(Request $request, Product $product)
    {

        $request->validate([
            'warehouse_id' => "required|string",
            'qty' => "required|array",
            'purchase_price' => "required|array",
            'stock_status' => "required|array",
        ]);



        $warehouse = Warehouse::findOrFail($request->warehouse_id);
        $branch_id = $warehouse->branch->id;

        if (settingAccount('funding_assets_account', $branch_id) == null) {
            alertError('please select the default funding assets account in settings page', 'الرجاء تحديد حساب تمويل الأصول المتداولة الافتراضية في صفحة الإعدادات');
            return redirect()->back()->withInput();
        }

        if (settingAccount('assets_account', $branch_id) == null) {
            alertError('please select the default assets account for products in settings page', 'الرجاء تحديد حساب الأصول الافتراضية للمنتجات في صفحة الإعدادات');
            return redirect()->back()->withInput();
        }

        if (settingAccount('cs_account', $branch_id) == null) {
            alertError('please select the default liability account for cost of goods sold in settings page', 'الرجاء تحديد حساب حقوق الملكية الافتراضية لتكلفة البضاعة المباعة في صفحة الإعدادات');
            return redirect()->back()->withInput();
        }


        $funding_assets_account = Account::findOrFail(settingAccount('funding_assets_account', $branch_id));




        foreach ($product->combinations as $index => $combination) {

            if ($request->qty[$index] > 0) {


                if ($request->stock_status[$index] == 'OUT') {
                    if ($request->qty[$index] > productQuantity($product->id, $combination->id, $warehouse->id)) {
                        alertError('There are not enough quantities in the specified warehouse for stock exchange', 'لا توجد كميات كافية في المخزن المحدد لصرف المخزون');
                        if (url()->previous() == route('products.stock.add')) {
                            return redirect()->route('products.stock.create', ['product' => $product->id]);
                        } else {
                            return redirect()->back()->withInput();
                        }
                    }
                }



                if ($request->stock_status[$index] == 'IN') {

                    // calculate product cost in add stock
                    updateCost($combination, $request->purchase_price[$index], $request->qty[$index], 'add', $branch_id);

                    $combination->update([
                        'warehouse_id' => $warehouse->id,
                    ]);
                }

                Stock::create([
                    'product_combination_id' => $combination->id,
                    'product_id' => $product->id,
                    'warehouse_id' => $warehouse->id,
                    'qty' => $request->qty[$index],
                    'stock_status' => $request->stock_status[$index],
                    'stock_type' => 'StockAdjustment',
                    'reference_price' => $request->purchase_price[$index],
                    'created_by' => Auth::id()
                ]);


                $product_account = getItemAccount($combination, $combination->product->category, 'assets_account', $branch_id);
                $cs_product_account = getItemAccount($combination, $combination->product->category, 'cs_account', $branch_id);

                Entry::create([
                    'account_id' => $product_account->id,
                    'type' => $request->stock_status[$index] == 'IN' ? 'stockIN' : 'stockOut',
                    'dr_amount' => $request->stock_status[$index] == 'IN' ? ($request->purchase_price[$index] * $request->qty[$index]) : 0,
                    'cr_amount' => $request->stock_status[$index] == 'OUT' ? ($combination->costs->where('branch_id', $branch_id)->first()->cost * $request->qty[$index]) : 0,
                    'description' => 'stock adjustment# ' . $combination->id,
                    'reference_id' => $combination->id,
                    'branch_id' => $branch_id,
                    'created_by' => Auth::id(),
                ]);


                if ($request->stock_status[$index] == 'IN') {

                    entry::create([
                        'account_id' => $funding_assets_account->id,
                        'type' => 'stockIN',
                        'dr_amount' => 0,
                        'cr_amount' => ($request->purchase_price[$index] * $request->qty[$index]),
                        'description' => 'stock adjustment# ' . $combination->id,
                        'branch_id' => $branch_id,
                        'created_by' => Auth::id(),
                    ]);
                }

                if ($request->stock_status[$index] == 'OUT') {

                    Entry::create([
                        'account_id' => $cs_product_account->id,
                        'type' => 'stockOut',
                        'dr_amount' => ($combination->costs->where('branch_id', $branch_id)->first()->cost * $request->qty[$index]),
                        'cr_amount' => 0,
                        'description' => 'stock adjustment# ' . $combination->id,
                        'reference_id' => $combination->id,
                        'branch_id' => $branch_id,
                        'created_by' => Auth::id(),
                    ]);
                }
            }
        }


        alertSuccess('Product stock updated successfully', 'تم تحديث مخزون المنتج بنجاح');

        if (url()->previous() == route('products.stock.add')) {
            return redirect()->route('stock.management.add');
        } else {
            return redirect()->route('products.index');
        }
    }

    public function variableStore(Request $request, Product $product)
    {

        $request->validate([
            'sku' => "required|array",
            'sale_price' => "required|array",
            'discount_price' => "required|array",
            'limit' => "required|array",
            'images' => "nullable|array",
        ]);



        foreach ($product->combinations as $index => $combination) {

            if ($request->sale_price[$index] <= $request->discount_price[$index]) {
                alertError('discount price must be lower than regular price', 'يجب ان يكون سعر الخصم اقل من السعر العادي');
                if (url()->previous() == route('products.stock.add')) {
                    return redirect()->route('products.stock.create', ['product' => $product->id]);
                } else {
                    return redirect()->back()->withInput();
                }
            }


            $combination->update([
                'sku' => $request->sku[$index],
                'sale_price' => $request->sale_price[$index],
                'discount_price' => $request->discount_price[$index],
                'limit' => $request->limit[$index],
            ]);

            if ($product->product_type == 'simple') {
                $product->update([
                    'sale_price' => $request->sale_price[$index],
                    'discount_price' => $request->discount_price[$index],
                ]);
            }

            if ($request->has('images')) {
                if (array_key_exists($combination->id, $request->images)) {
                    $media_id = saveMedia('image', $request->images[$combination->id][0], 'combinations');
                    if ($combination->media_id != null) {
                        deleteImage($combination->media_id);
                    }
                    $combination->update([
                        'media_id' => $media_id,
                    ]);
                }
            }
        }


        alertSuccess('Product variables updated successfully', 'تم تحديث متغيرات المنتج بنجاح');

        return redirect()->route('products.index');
    }
    public function colorCreate($product)
    {
        $colors = Color::all();
        $sizes = Size::all();
        $product = Product::find($product);
        return view('dashboard.products.color', compact('colors', 'sizes', 'product'));
    }

    public function colorStore(Request $request, Product $product)
    {
        $request->validate([
            'color' => "required|string",
            'size' => "required|string",
        ]);

        foreach ($product->stocks as $stock) {
            if ($request->color == $stock->color->id && $request->size == $stock->size->id) {
                alertError('This item is already in the product, please modify the product to increase the stock', 'هذا العنصر موجود بالفعل في المنتج يرجى التعديل على المنتج لزيادة المخزون');
                return redirect()->route('products.stock.create', ['product' => $product->id]);
            }
        }

        $stock = Stock::create([
            'color_id' => $request['color'],
            'size_id' => $request['size'],
            'product_id' => $product->id,
        ]);

        alertSuccess('Inventory has been added to the product successfully', 'تم اضافة المخزون الى المنتج بنجاح');
        return redirect()->route('products.stock.create', ['product' => $product->id]);
    }

    public function colorDestroy(Stock $stock)
    {
        $product_id = $stock->product_id;
        $stock->delete();
        alertSuccess('Stock deleted successfully', 'تم حذف المخزون بنجاح');
        return redirect()->route('products.stock.create', ['product' => $product_id]);
    }


    public function myStockShow($lang, Product $product)
    {

        $scountry = Country::findOrFail(Auth()->user()->country_id);

        $categories = Category::with('products')
            ->where('country_id', $scountry->id)
            ->where('parent', 'null')
            ->get();

        $categories = Category::with('products')
            ->where('country_id', $scountry->id)
            ->where('parent', $product->categories()->first()->id)
            ->get();


        return view('dashboard.aff-prod.mystock_product', compact('categories', 'product'));
    }

    public function myStockOrder($lang, Request $request, Product $product)
    {

        $user = Auth::user();


        $request->validate([
            'quantity' => 'required|array',
            'payment' => 'required|string',
        ]);

        $vendor_price = $request->price;

        $count = 0;
        $check_quantity = 0;
        $quantity_count = 0;

        foreach ($request->quantity as $quantity1) {

            $quantity_count += $quantity1;
        }

        $total_price = $quantity_count * $product->min_price;



        foreach ($product->stocks as $key => $stock) {

            if ($request->quantity[$key] > $stock->stock) {
                $count = $count + 1;
            }
            if ($request->quantity[$key] <= 0) {
                $check_quantity += 1;
            }
        }



        if ($count > 0) {

            if (app()->getLocale() == 'ar') {

                session()->flash('success', 'تم تحديث الكميات المتاحة لهذا المنتج .. يرجى مراجعة الكميات المطلوبة ومحاولة عمل الطلب مرة أخرى');
            } else {

                session()->flash('success', 'The quantities available for this product have been updated.. Please review the required quantities and try to make the order again');
            }


            return redirect()->route('mystock.add', ['lang' => app()->getLocale(), 'product' => $product->id]);
        }

        if ($check_quantity == $key + 1) {

            if (app()->getLocale() == 'ar') {

                session()->flash('success', 'يرجى إضافة كميات الى طلبك لكي يمكنك من اتمام الطلب');
            } else {

                session()->flash('success', 'Please add quantities to your order so that you can complete the order');
            }


            return redirect()->route('mystock.add', ['lang' => app()->getLocale(), 'product' => $product->id]);
        }


        if ($vendor_price != $product->vendor_price) {

            if (app()->getLocale() == 'ar') {

                session()->flash('success', 'تم تحديث سعر هذا المنتج .. يرجى مراجعة السعر الحالي للمنتج');
            } else {

                session()->flash('success', 'The price of this product has been updated.. Please check the current price of the product');
            }


            return redirect()->route('mystock.add', ['lang' => app()->getLocale(), 'product' => $product->id]);
        }




        $order = Aorder::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'country_id' => Auth::user()->country->id,
            'total_price' => $total_price,
            'product_id' => $product->id,
            'status' => 'pending'
        ]);


        foreach ($product->stocks as $key => $stock) {

            $stock = Astock::create([
                'product_id' => $product->id,
                'color_id' => $stock->color_id,
                'aorder_id' => $order->id,
                'size_id' => $stock->size_id,
                'image' => $stock->image == NULL ? NULL : $stock->image,
                'stock' => $request->quantity[$key],
            ]);
        }

        return redirect()->route('mystock.orders', ['lang' => app()->getLocale(), 'user' => $user->id]);
    }

    public function myStockorders($lang, $user)
    {
        $orders = Aorder::where('user_id', $user)
            ->whenSearch(request()->search)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(100);

        $user = User::find($user);

        return view('dashboard.orders.mystock_orders')->with('orders', $orders)->with('user', $user);
        // return view('dashboard.orders.mystock_orders' , compact($orders , $user));


    }



    public function myStockordersAdmin($lang, Request $request)
    {


        if (!$request->has('from') || !$request->has('to')) {

            $request->merge(['from' => Carbon::now()->subDay(365)->toDateString()]);
            $request->merge(['to' => Carbon::now()->toDateString()]);
        }

        $orders = Aorder::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->whenSearch(request()->search)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(100);


        return view('dashboard.all_orders.stock_orders')->with('orders', $orders);
    }

    public function myStockCancel($lang, Aorder $order)
    {

        if ($order->status == 'pending') {

            $order->update([
                'status' => 'canceled'
            ]);
        }

        return redirect()->back()->withInput();
    }

    public function myStockProduct($lang, Product $product, Aorder $order)
    {

        $scountry = Country::findOrFail(Auth()->user()->country_id);

        $categories = Category::with('products')
            ->where('country_id', $scountry->id)
            ->where('parent', 'null')
            ->get();

        $categories = Category::with('products')
            ->where('country_id', $scountry->id)
            ->where('parent', $product->categories()->first()->id)
            ->get();


        return view('dashboard.aff-prod.sproduct', compact('categories', 'product', 'order'));
    }

    public function myStockProducts($lang)
    {
        // $category = Category::all();

        $scountry = Country::findOrFail(Auth()->user()->country_id);

        $user = Auth::user();


        $orders = Aorder::where('user_id', $user->id)
            ->latest()
            ->paginate(100);



        return view('dashboard.aff-prod.mystock_products', compact('orders', 'user'));
    }

    public function myStockordersChange($lang, Request $request, Aorder $order)
    {



        $request->validate([

            'status' => "required|string|max:255",

        ]);

        $product = $order->product;
        $astocks = $product->astocks->where('order_id', $order->id)->values();





        if ($order->status == 'pending' && $request->status == 'confirmed') {
            $order->update([
                'status' => 'confirmed'
            ]);


            foreach ($product->stocks as $key => $stock) {
                $stock->update([
                    'stock' => $stock->stock - $astocks[$key]->stock
                ]);
            }
        }

        if ($order->status == 'pending' && $request->status == 'rejected') {
            $order->update([
                'status' => 'rejected'
            ]);
        }


        switch ($order->status) {
            case "pending":
                $status_en = "pending";
                $status_ar = "معلق";
                break;
            case "confirmed":
                $status_en = "confirmed";
                $status_ar = "مؤكد";
                break;
            case "rejected":
                $status_en = "rejected";
                $status_ar = "مرفوض";
                break;
            case "canceled":
                $status_en = "canceled";
                $status_ar = "ملغي";
                break;
            default:
                break;
        }




        $title_ar = 'اشعار من الإدارة';
        $body_ar = "تم تغيير حالة الطلب الخاص بك الى " . $status_ar;
        $title_en = 'Notification From Admin';
        $body_en  = "Your order status has been changed to " . $status_en;


        $notification1 = Notification::create([
            'user_id' => $order->user->id,
            'user_name'  => Auth::user()->name,
            'user_image' => asset('storage/images/users/' . Auth::user()->profile),
            'title_ar' => $title_ar,
            'body_ar' => $body_ar,
            'title_en' => $title_en,
            'body_en' => $body_en,
            'date' => $order->updated_at,
            'status' => 0,
            'url' =>  route('mystock.orders', ['lang' => app()->getLocale(), 'user' => $order->user->id]),
        ]);



        $date =  Carbon::now();
        $interval = $notification1->created_at->diffForHumans($date);

        $data = [
            'notification_id' => $notification1->id,
            'user_id' => $order->user->id,
            'user_name'  => Auth::user()->name,
            'user_image' => asset('storage/images/users/' . Auth::user()->profile),
            'title_ar' => $title_ar,
            'body_ar' => $body_ar,
            'title_en' => $title_en,
            'body_en' => $body_en,
            'date' => $interval,
            'status' => $notification1->status,
            'url' =>  route('mystock.orders', ['lang' => app()->getLocale(), 'user' => $order->user->id]),
            'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $order->user->id, 'notification' => $notification1->id]),

        ];


        try {
            event(new NewNotification($data));
        } catch (Exception $e) {
        }


        return redirect()->route('stock.orders', app()->getLocale());
    }



    public function updateStatusBulk(Request $request)
    {

        $request->validate([
            'selected_status' => "required|string|max:255",
            'selected_items' => "required|array",
        ]);

        foreach ($request->selected_items as $product) {

            $product = Product::findOrFail($product);

            if ($product->status != $request->selected_status) {

                $this->changeStatus($product, $request->selected_status);

                alertSuccess('Products status updated successfully', 'تم تحديث حالة المنتجات بنجاح');
            } else {
                alertError('The status of some products cannot be changed', 'لا يمكن تغيير حالة بعض المنتجات');
            }
        }

        return redirect()->back()->withInput();
    }

    public function updateStatus(Request $request, Product $product)
    {

        $request->validate([
            'status' => "required|string|max:255",
        ]);


        if ($product->status != $request->status) {

            $this->changeStatus($product, $request->status);

            alertSuccess('Product status updated successfully', 'تم تحديث حالة المنتج بنجاح');
        } else {
            alertError('Product status cannot be updated', 'لا يمكن تحديث حالة المنتج');
        }

        return redirect()->back()->withInput();
    }

    private function changeStatus($product, $status)
    {

        if ($product->vendor_id != null) {
            $title_ar = 'اشعار من الإدارة';
            $title_en = 'Notification From Admin';

            switch ($status) {
                case 'active':
                    $body_ar = "تم تغيير حالة المنتج الخاص بك الى نشط";
                    $body_en  = "Your product status has been changed to Active";
                    break;
                case 'rejected':
                    $body_ar = "تم تغيير حالة المنتج الخاص بك الى مرفوض";
                    $body_en  = "Your product status has been changed to Rejected";
                    break;
                case 'pause':
                    $body_ar = "تم تغيير حالة المنتج الخاص بك الى معطل مؤقتا";
                    $body_en  = "Your product status has been changed to pause";
                    break;
                case 'pending':
                    $body_ar = "تم تغيير حالة المنتج الخاص بك الى معلق";
                    $body_en  = "Your product status has been changed to pending";
                    break;
                default:
                    # code...
                    break;
            }

            $url = route('vendor-products.index');
            addNoty($product->vendor, Auth::user(), $url, $title_en, $title_ar, $body_en, $body_ar);
        }


        $product->update([
            'status' => $status,
            'admin_id' => Auth::id(),
        ]);

        $description_ar = ' تم تعديل منتج ' . '  منتج رقم' . ' #' . $product->id . ' - SKU ' . $product->sku;
        $description_en  = "product updated " . " product ID " . ' #' . $product->id . ' - SKU ' . $product->sku;
        addLog('admin', 'products', $description_ar, $description_en);
    }
}

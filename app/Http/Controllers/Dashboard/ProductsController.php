<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Country;
use App\Models\Product;
use App\Models\ProductCombination;
use App\Models\ProductCombinationDtl;
use App\Models\ProductImage;
use App\Models\ProductVariation;
use App\Models\ShippingMethod;
use App\Models\Size;
use App\Models\Stock;
use App\Models\User;
use App\Models\Variation;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

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



    public function index()
    {
        $categories = Category::whereNull('parent_id')->get();
        $countries = Country::all();



        $products = Product::whenSearch(request()->search)
            ->whenCategory(request()->category_id)
            ->whenCountry(request()->country_id)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(100);

        return view('Dashboard.products.index', compact('products', 'categories', 'countries'));
    }

    public function show(Product $product)
    {
        $scountry = Country::findOrFail(Auth()->user()->country_id);

        $categories = Category::with('products')
            ->where('country_id', $scountry->id)
            ->where('parent', $product->categories()->first()->id)
            ->get();

        return view('Dashboard.products.show', compact('categories', 'product'));
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
        return view('Dashboard.products.create', compact('attributes', 'categories', 'countries', 'brands', 'shipping_methods'));
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
            'sku' => "required|string|unique:products",
            'product_slug' => "required|string|unique:products",
            'images' => "required|array",
            'description_ar' => "required|string",
            'description_en' => "required|string",
            'sale_price' => "required|numeric",
            'discount_price' => "required|numeric",
            'categories' => "required|array",
            'brands' => "nullable|array",
            'product_type' => "required|string",
            'digital_file' => "nullable|file",
            'status' => "required|string",
            'video_url' => "nullable|string",
            'attributes' => "nullable|array",
            'product_min_order' => "required|numeric",
            'product_max_order' => "required|numeric",
            'extra_fee'  => "required|numeric",
            'seo_meta_tag' => "nullable|string",
            'seo_desc' => "nullable|string",

            'product_weight' => "nullable|numeric",
            'product_length' => "nullable|numeric",
            'product_width' => "nullable|numeric",
            'product_height'  => "nullable|numeric",
            'shipping_amount' => "nullable|numeric",
            'shipping_method' => "nullable|string",

        ]);

        $product_type = $request['product_type'];

        if ($product_type == 'digital') {
            if ($request->hasFile('digital_file')) {
                $extension = $request->digital_file->extension();
                $path = $request->file('digital_file')->store('files/products');
            } else {
                alertError('please upload digital file', 'يرجى ارفاق الملف الرقمي للمنتج الرقمي');
                return redirect()->back();
            }
        }

        if ($product_type == 'simple' || $product_type == 'variable') {

            if (!isset($request['product_weight']) || !isset($request['product_length']) || !isset($request['product_width']) || !isset($request['product_height'])) {
                alertError('You must enter product information such as weight, length, width and height', 'يجب ادخال معلومات المنتج من وزن وطول وعرض وارتفاع ');
                return redirect()->back();
            }
        }

        if ($request->sale_price <= $request->discount_price) {
            alertError('discount price must be lower than regular price', 'يجب ان يكون سعر الخصم اقل من السعر العادي');
            return redirect()->back();
        }


        // if (!checkVendor($request->vendor_id)) {
        //     alertError('The vendor ID entered is incorrect', 'رقم التاجر المدخل غير صحيح');
        //     return redirect()->route('products.index');
        // }

        if ($product_type == 'variable') {
            if (empty($request['attributes'])) {
                alertError('please select product attribute', 'يرجى تحديد سمات المنتج');
                return redirect()->back();
            } else {
                foreach ($request['attributes'] as $attr) {
                    if (empty($request['variations-' . $attr])) {
                        alertError('please select product variations', 'يرجى تحديد متغيرات المنتج');
                        return redirect()->back();
                    }
                }
            }
        }





        $product = Product::create([
            'created_by' => Auth::id(),
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'product_slug' => createSlug($request['product_slug']),
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
            'digital_file' => $product_type == 'digital' ? $path : null,
            'country_id' => 1,
            'status' => $request['status'],
        ]);

        $product->categories()->attach($request['categories']);
        $product->brands()->attach($request['brands']);

        // CalculateProductPrice($product);

        if ($files = $request->file('images')) {
            foreach ($files as $file) {
                $media_id = saveMedia('image', $file, 'products');
                ProductImage::create([
                    'product_id' => $product->id,
                    'media_id' => $media_id,
                ]);
            }
        }


        function combinations($arrays, $i = 0)
        {
            if (!isset($arrays[$i])) {
                return array();
            }
            if ($i == count($arrays) - 1) {
                return $arrays[$i];
            }

            // get combinations from subsequent arrays
            $tmp = combinations($arrays, $i + 1);

            $result = array();

            // concat each array from tmp with each element from $arrays[$i]
            foreach ($arrays[$i] as $v) {
                foreach ($tmp as $t) {
                    $result[] = is_array($t) ?
                        array_merge(array($v), $t) :
                        array($v, $t);
                }
            }

            return $result;
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

            $arrays = combinations($combination_array);

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

        if ($product->product_type == 'simple' || $product->product_type == 'variable') {
            alertSuccess('Product Created successfully, Please enter stock details', 'تم إنشاء المنتج بنجاح, يرجى ادخال تفاصيل المخزون للمتغيرات');
            return redirect()->route('products.stock.create', ['product' => $product->id]);
        } else {
            alertSuccess('Product Created successfully', 'تم إنشاء المنتج بنجاح');
            return redirect()->route('products.index');
        }
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
        $shipping_methods = ShippingMethod::whereIn('id', [1, 2, 3])->get();
        return view('Dashboard.products.edit', compact('categories', 'countries', 'product', 'brands', 'shipping_methods'));
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
            'sku' => "required|string|unique:products,sku," . $product->id,
            'product_slug' => "required|string|unique:products,product_slug," . $product->id,
            'images' => "nullable|array",
            'description_ar' => "required|string",
            'description_en' => "required|string",
            'sale_price' => "required|numeric",
            'discount_price' => "required|numeric",
            'categories' => "required|array",
            'brands' => "nullable|array",
            'digital_file' => "nullable|file",
            'status' => "required|string",
            'video_url' => "nullable|string",
            'attributes' => "nullable|array",
            'product_min_order' => "required|numeric",
            'product_max_order' => "required|numeric",
            'extra_fee'  => "required|numeric",
            'seo_meta_tag' => "nullable|string",
            'seo_desc' => "nullable|string",

            'product_weight' => "nullable|numeric",
            'product_length' => "nullable|numeric",
            'product_width' => "nullable|numeric",
            'product_height'  => "nullable|numeric",
            'shipping_amount' => "nullable|numeric",
            'shipping_method' => "nullable|string",
        ]);


        $product_type = $product->product_type;


        if ($request->sale_price <= $request->discount_price) {
            alertError('discount price must be lower than regular price', 'يجب ان يكون سعر الخصم اقل من السعر العادي');
            return redirect()->back();
        }

        if ($request->hasFile('digital_file') && $product_type == 'digital') {
            $extension = $request->digital_file->extension();
            Storage::delete($product->digital_file);
            $path = $request->file('digital_file')->store('files/products');
        } else {
            $path = $product->digital_file;
        }


        if ($product_type == 'simple' || $product_type == 'variable') {

            if (!isset($request['product_weight']) || !isset($request['product_length']) || !isset($request['product_width']) || !isset($request['product_height'])) {
                alertError('You must enter product information such as weight, length, width and height', 'يجب ادخال معلومات المنتج من وزن وطول وعرض وارتفاع ');
                return redirect()->back();
            }
        }



        if ($files = $request->file('images')) {
            foreach ($product->images as $image) {
                deleteImage($image->media->media_id);
                $image->delete();
            }
            foreach ($files as $file) {
                $media_id = saveMedia('image', $file, 'products');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $media_id,
                ]);
            }
        }


        $vendor = User::findOrFail($product->created_by);
        if ($vendor->hasRole('vendor')) {
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



        $product->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'sku' => $request['sku'],
            'product_slug' => createSlug($request['product_slug']),
            'description_ar' => $request['description_ar'],
            'description_en' => $request['description_en'],
            'sale_price' => $request['sale_price'],
            'discount_price' => $request['discount_price'],

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
            'updated' => Auth::id(),
            'digital_file' => $product_type == 'digital' ? $path : null,
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


        $product->categories()->detach();
        $product->brands()->detach();
        $product->categories()->attach($request['categories']);
        $product->brands()->attach($request['brands']);


        // CalculateProductPrice($product);

        $product->update([
            'unlimited' => $request['limited'] == 'on' ? '1' : '0',
        ]);

        $product->update([
            'on_sale' => $request['on_sale'] == 'on' ? '1' : '0',
        ]);

        $product->update([
            'is_featured' => $request['is_featured'] == 'on' ? '1' : '0',
        ]);

        $product->update([
            'top_collection' => $request['top_collection'] == 'on' ? '1' : '0',
        ]);

        $product->update([
            'best_selling' => $request['best_selling'] == 'on' ? '1' : '0',
        ]);


        $description_ar = ' تم تعديل منتج ' . '  منتج رقم' . ' #' . $product->id . ' - SKU ' . $product->sku;
        $description_en  = "product updated " . " product ID " . ' #' . $product->id . ' - SKU ' . $product->sku;
        addLog('admin', 'products', $description_ar, $description_en);

        alertSuccess('Product updated successfully', 'تم تحديث المنتج بنجاح');
        return redirect()->route('products.index');
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
                Storage::disk('public')->delete($product->digital_fil);
            }
            foreach ($product->images as $image) {
                deleteImage($image->media->media_id);
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
            return redirect()->back();
        }
    }


    public function trashed()
    {
        $categories = Category::all();
        $countries = Country::all();
        $products = Product::onlyTrashed()
            ->whenSearch(request()->search)
            ->whenCategory(request()->category_id)
            ->whenCountry(request()->country_id)
            ->paginate(100);
        return view('Dashboard.products.index')->with('products', $products)->with('categories', $categories)->with('countries', $countries);
    }

    public function restore($product)
    {
        $product = Product::withTrashed()->where('id', $product)->first()->restore();
        alertSuccess('Product restored successfully', 'تم استعادة المنتج بنجاح');
        return redirect()->route('products.index');
    }

    public function stockCreate($product)
    {
        $warehouses = Warehouse::all();
        $product = Product::findOrFail($product);
        return view('Dashboard.products.stock ')->with('product', $product)->with('warehouses', $warehouses);
    }

    public function stockProductCreate()
    {
        $warehouses = Warehouse::all();
        $product = Product::findOrFail(request()->product);
        return view('Dashboard.products.stock ')->with('product', $product)->with('warehouses', $warehouses);
    }

    public function stockStore(Request $request, Product $product)
    {


        $request->validate([
            'warehouse_id' => "nullable|array",
            'sku' => "required|array",
            'qty' => "required|array",
            'purchase_price' => "required|array",
            'sale_price' => "required|array",
            'discount_price' => "required|array",
            'limit' => "required|array",
            'images' => "nullable|array",
            'stock_status' => "required|array",
        ]);


        foreach ($product->combinations as $index => $combination) {


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


        foreach ($product->combinations as $index => $combination) {

            if ($request->qty[$index] > 0) {



                if ($request->sale_price[$index] <= $request->discount_price[$index]) {
                    alertError('discount price must be lower than regular price', 'يجب ان يكون سعر الخصم اقل من السعر العادي');
                    if (url()->previous() == route('products.stock.add')) {
                        return redirect()->route('products.stock.create', ['product' => $product->id]);
                    } else {
                        return redirect()->back();
                    }
                }



                if ($request->warehouse_id[$index] == null) {
                    alertError('Please select the store to add stock quantities', 'يرجى تحديد المخزن لاضافة كميات المخزون');
                    if (url()->previous() == route('products.stock.add')) {
                        return redirect()->route('products.stock.create', ['product' => $product->id]);
                    } else {
                        return redirect()->back();
                    }
                }



                if ($request->stock_status[$index] == 'OUT') {
                    if ($request->qty[$index] > productQuantity($product->id, $combination->id, $request->warehouse_id[$index])) {
                        alertError('There are not enough quantities in the specified warehouse for stock exchange', 'لا توجد كميات كافية في المخزن المحدد لصرف المخزون');
                        if (url()->previous() == route('products.stock.add')) {
                            return redirect()->route('products.stock.create', ['product' => $product->id]);
                        } else {
                            return redirect()->back();
                        }
                    }
                }

                $combination->update([
                    'warehouse_id' => $request->warehouse_id[$index],
                    'sku' => $request->sku[$index],
                    'qty' => $request->qty[$index],
                    'sale_price' => $request->sale_price[$index],
                    'discount_price' => $request->discount_price[$index],
                    'limit' => $request->limit[$index],
                ]);

                Stock::create([
                    'product_combination_id' => $combination->id,
                    'product_id' => $product->id,
                    'warehouse_id' => $request->warehouse_id[$index],
                    'qty' => $request->qty[$index],
                    'stock_status' => $request->stock_status[$index],
                    'stock_type' => 'StockAdjustment',
                    'reference_price' => $request->purchase_price[$index],
                    'created_by' => Auth::id()
                ]);

                if ($product->product_type == 'simple') {
                    $product->update([
                        'sale_price' => $request->sale_price[$index],
                        'discount_price' => $request->discount_price[$index],
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

    public function colorCreate($product)
    {
        $colors = Color::all();
        $sizes = Size::all();
        $product = Product::find($product);
        return view('Dashboard.products.color', compact('colors', 'sizes', 'product'));
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


        return view('Dashboard.aff-prod.mystock_product', compact('categories', 'product'));
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

        return view('Dashboard.orders.mystock_orders')->with('orders', $orders)->with('user', $user);
        // return view('Dashboard.orders.mystock_orders' , compact($orders , $user));


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


        return view('Dashboard.all_orders.stock_orders')->with('orders', $orders);
    }

    public function myStockCancel($lang, Aorder $order)
    {

        if ($order->status == 'pending') {

            $order->update([
                'status' => 'canceled'
            ]);
        }

        return redirect()->back();
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


        return view('Dashboard.aff-prod.sproduct', compact('categories', 'product', 'order'));
    }

    public function myStockProducts($lang)
    {
        // $category = Category::all();

        $scountry = Country::findOrFail(Auth()->user()->country_id);

        $user = Auth::user();


        $orders = Aorder::where('user_id', $user->id)
            ->latest()
            ->paginate(100);



        return view('Dashboard.aff-prod.mystock_products', compact('orders', 'user'));
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

        return redirect()->route('products.index');
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

        return redirect()->route('products.index');
    }

    private function changeStatus($product, $status)
    {
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

        $product->update([
            'status' => $status,
            'admin_id' => Auth::id(),
        ]);

        $description_ar = ' تم تعديل منتج ' . '  منتج رقم' . ' #' . $product->id . ' - SKU ' . $product->sku;
        $description_en  = "product updated " . " product ID " . ' #' . $product->id . ' - SKU ' . $product->sku;
        addLog('admin', 'products', $description_ar, $description_en);
    }
}

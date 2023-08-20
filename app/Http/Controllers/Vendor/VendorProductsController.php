<?php

namespace App\Http\Controllers\Vendor;

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
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class VendorProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:vendor');
    }

    public function index()
    {


        $categories = Category::whereNull('parent_id')->get();
        $countries = Country::all();

        $products = Product::where('vendor_id', Auth::id())
            ->whenSearch(request()->search)
            ->whenCategory(request()->category_id)
            ->whenCountry(request()->country_id)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(100);

        return view('vendor.products.index')->with('products', $products)->with('categories', $categories)->with('countries', $countries);
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')
            ->where('country_id', Auth::user()->country_id)
            ->get();
        $countries = Country::all();
        $brands = Brand::where('status', 'active')->get();
        $attributes = Attribute::all();
        $shipping_methods = ShippingMethod::whereIn('id', [1, 2, 3])->get();
        return view('vendor.products.create', compact('countries', 'categories', 'attributes', 'brands', 'shipping_methods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => "required|string",
            'name_en' => "required|string",
            'images' => "required|array",
            'description_ar' => "required|string",
            'description_en' => "required|string",
            'category' => "required|string",
            'sku' => "required|string|unique:products",

            'sale_price' => "required|numeric",
            'discount_price' => "required|numeric",
            'product_type' => "required|string",
            'video_url' => "nullable|string",
            'attributes' => "nullable|array",

            'product_weight' => "nullable|numeric",
            'product_length' => "nullable|numeric",
            'product_width' => "nullable|numeric",
            'product_height'  => "nullable|numeric",
            'image' => "nullable|image",


        ]);


        $product_type = $request['product_type'];

        if ($product_type == 'simple' || $product_type == 'variable') {

            if (!isset($request['product_weight']) || !isset($request['product_length']) || !isset($request['product_width']) || !isset($request['product_height'])) {
                alertError('You must enter product information such as weight, length, width and height', 'يجب ادخال معلومات المنتج من وزن وطول وعرض وارتفاع ');
                return redirect()->back()->withInput();
            }
        }

        if ($request->sale_price <= $request->discount_price) {
            alertError('discount price must be lower than regular price', 'يجب ان يكون سعر الخصم اقل من السعر العادي');
            return redirect()->back()->withInput();
        }

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
        } else {
            $media_id = null;
        }


        $product = Product::create([
            'vendor_id' => Auth::id(),
            'created_by' => Auth::id(),
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'media_id' => $media_id,

            // 'product_slug' => createSlug($request['name_en']),
            'description_ar' => $request['description_ar'],
            'description_en' => $request['description_en'],
            'sale_price' => $request['sale_price'],
            'discount_price' => $request['discount_price'],
            'product_type' => $product_type,
            'sku' => $request['sku'],
            'category_id' => $request['category'],

            'product_weight' =>  $request['product_weight'],
            'product_length' =>  $request['product_length'],
            'product_width' =>  $request['product_width'],
            'product_height' =>  $request['product_height'],

            'video_url' => $request['video_url'],
            'product_min_order' => 1,
            'product_max_order' => 5,
            'country_id' => Auth::user()->country_id,
        ]);

        // $product->categories()->attach($request['catgeory']);

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


        if (Auth::user()->warehouses->count() == 0) {
            $warehouse = Warehouse::create([
                'name_ar' => 'مخزن تاجر' . ' - ' . Auth::user()->name,
                'name_en' => 'vendor warehouse' . ' - ' .  Auth::user()->name,
                'code' => Auth::id(),
                'country_id' => Auth::user()->country_id,
                'vendor_id' => Auth::id(),
            ]);
        }


        $description_ar = ' تم إضافة منتج ' . '  منتج رقم' . ' #' . $product->id . ' - SKU ' . $product->sku;
        $description_en  = "product added " . " product ID " . ' #' . $product->id . ' - SKU ' . $product->sku;
        addLog('vendor', 'products', $description_ar, $description_en);

        alertSuccess('Product Created successfully, Please enter product stock', 'تم إنشاء المنتج بنجاح, يرجى ادخال المخزون لهذا المنتج');
        return redirect()->route('vendor-products.stock.create', ['product' => $product->id]);
    }



    public function edit($product)
    {
        $categories = Category::whereNull('parent_id')
            ->where('country_id', Auth::user()->country_id)
            ->get();

        $countries = Country::all();
        $product = Product::find($product);
        return view('vendor.products.edit', compact('categories', 'product'));
    }

    public function update(Request $request, Product $vendor_product)
    {
        $request->validate([
            'name_ar' => "required|string",
            'name_en' => "required|string",
            'sku' => "nullable|string|unique:products,sku," . $vendor_product->id,
            'images' => "nullable|array",
            'description_ar' => "required|string",
            'description_en' => "required|string",
            'category' => "required|string",

            'sale_price' => "required|numeric",
            'discount_price' => "required|numeric",

            'video_url' => "nullable|string",

            'product_weight' => "nullable|numeric",
            'product_length' => "nullable|numeric",
            'product_width' => "nullable|numeric",
            'product_height'  => "nullable|numeric",
            'image' => "nullable|image",


        ]);


        $product_type = $vendor_product->product_type;

        if ($request->sale_price <= $request->discount_price) {
            alertError('discount price must be lower than regular price', 'يجب ان يكون سعر الخصم اقل من السعر العادي');
            return redirect()->back()->withInput();
        }

        if ($product_type == 'simple' || $product_type == 'variable') {

            if (!isset($request['product_weight']) || !isset($request['product_length']) || !isset($request['product_width']) || !isset($request['product_height'])) {
                alertError('You must enter product information such as weight, length, width and height', 'يجب ادخال معلومات المنتج من وزن وطول وعرض وارتفاع ');
                return redirect()->back()->withInput();
            }
        }


        if ($files = $request->file('images')) {

            foreach ($vendor_product->images as $image) {
                deleteImage($image->media->id);
                $image->delete();
            }
            foreach ($files as $file) {
                $media_id = saveMedia('image', $file, 'products');
                ProductImage::create([
                    'product_id' => $vendor_product->id,
                    'media_id' => $media_id,
                ]);
            }
        }

        if ($request->hasFile('image')) {
            deleteImage($vendor_product->media_id);
            $media_id = saveMedia('image', $request['image'], 'products');
            $vendor_product->update([
                'media_id' => $media_id,
            ]);
        }

        $vendor_product->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'sku' => $request['sku'],
            // 'product_slug' => createSlug($request['name_en']),
            'description_ar' => $request['description_ar'],
            'description_en' => $request['description_en'],
            'sale_price' => $request['sale_price'],
            'discount_price' => $request['discount_price'],
            'category_id' => $request['category'],
            'product_weight' =>  $request['product_weight'],
            'product_length' =>  $request['product_length'],
            'product_width' =>  $request['product_width'],
            'product_height' =>  $request['product_height'],

            'video_url' => $request['video_url'],
        ]);

        // $vendor_product->categories()->detach();
        // $vendor_product->categories()->attach($request['categories']);

        // CalculateProductPrice($vendor_product);

        alertSuccess('Product updated successfully', 'تم تحديث المنتج بنجاح');
        return redirect()->route('vendor-products.index');
    }

    public function destroy($product)
    {
        $product = Product::withTrashed()->where('id', $product)->first();
        if (!$product->trashed() && checkProductForTrash($product)) {
            $product->delete();
            alertSuccess('product trashed successfully', 'تم حذف المنتج مؤقتا');
            return redirect()->route('vendor-products.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the product cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو المنتج لا يمكن حذفها حاليا');
            return redirect()->back()->withInput();
        }
    }

    public function stockCreate($product)
    {
        $product = Product::findOrFail($product);
        return view('vendor.products.stock ')->with('product', $product);
    }


    public function stockStore(Request $request, Product $product)
    {
        $request->validate([
            'qty' => "required|array",
            'sale_price' => "required|array",
            'discount_price' => "required|array",
            'images' => "nullable|array",
            'stock_status' => "required|array",
            'sku' => "required|array",
        ]);



        foreach ($product->combinations as $index => $combination) {

            if ($request->qty[$index] > 0) {


                if ($request->sale_price[$index] <= $request->discount_price[$index]) {
                    alertError('discount price must be lower than regular price', 'يجب ان يكون سعر الخصم اقل من السعر العادي');
                    if (url()->previous() == route('products.stock.add')) {
                        return redirect()->route('products.stock.create', ['product' => $product->id]);
                    } else {
                        return redirect()->back()->withInput();
                    }
                }


                if (Auth::user()->warehouses->count() == 0) {
                    alertError('Please select the store to add stock quantities', 'يرجى تحديد المخزن لاضافة كميات المخزون');
                    return redirect()->back()->withInput();
                }


                $warehouse = Auth::user()->warehouses->first();



                if ($request->stock_status[$index] == 'OUT') {
                    if ($request->qty[$index] > productQuantity($product->id, $combination->id, $warehouse->id)) {
                        alertError('There are not enough quantities in the specified warehouse for stock exchange', 'لا توجد كميات كافية في المخزن المحدد لصرف المخزون');
                        return redirect()->back()->withInput();
                    }
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


                if ($request->stock_status[$index] == 'IN') {
                    $combination->update([
                        'warehouse_id' => $warehouse->id,
                        'qty' => $request->qty[$index],
                        'sale_price' => $request->sale_price[$index],
                        'discount_price' => $request->discount_price[$index],
                        'sku' => $request->sku[$index],
                    ]);
                }

                Stock::create([
                    'product_combination_id' => $combination->id,
                    'product_id' => $product->id,
                    'warehouse_id' => $warehouse->id,
                    'qty' => $request->qty[$index],
                    'stock_status' => $request->stock_status[$index],
                    'stock_type' => 'StockAdjustment',
                    'created_by' => Auth::id()
                ]);



                if ($product->product_type == 'simple' && $request->stock_status[$index] == 'IN') {
                    $product->update([
                        'sale_price' => $request->sale_price[$index],
                        'discount_price' => $request->discount_price[$index],
                    ]);
                }
            }
        }


        alertSuccess('Product stock updated successfully', 'تم تحديث مخزون المنتج بنجاح');
        return redirect()->route('vendor-products.index');
    }

    public function colorCreate($product)
    {
        $colors = Color::all();
        $sizes = Size::all();
        $product = Product::find($product);
        return view('vendor.products.color', compact('colors', 'sizes', 'product'));
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
        return redirect()->route('vendor-products.stock.create', ['product' => $product->id]);
    }

    public function colorDestroy(Stock $stock)
    {
        $product_id = $stock->product_id;
        $stock->delete();
        alertSuccess('Stock deleted successfully', 'تم حذف المخزون بنجاح');
        return redirect()->route('vendor-products.stock.create', ['product' => $product_id]);
    }
}

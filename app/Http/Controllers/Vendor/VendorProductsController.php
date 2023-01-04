<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Country;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Size;
use App\Models\Stock;
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
        $colors = Color::all();
        $sizes = Size::all();
        return view('vendor.products.create', compact('colors', 'categories', 'sizes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => "required|string",
            'name_en' => "required|string",
            'sku' => "nullable|string|unique:products",
            'images' => "required|array",
            'description_ar' => "required|string",
            'description_en' => "required|string",
            'vendor_price' => "required|string",
            'categories' => "required|array",
            'colors'  => "array|required",
            'sizes'  => "array|required",
        ]);


        $product = Product::create([
            'vendor_id' => Auth::user()->id,
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'sku' => $request['sku'],
            'description_ar' => $request['description_ar'],
            'description_en' => $request['description_en'],
            'vendor_price' => $request['vendor_price'],
            'country_id' => Auth::user()->country_id,
            'status' => 'pending',
        ]);

        $product->categories()->attach($request['categories']);

        CalculateProductPrice($product);

        if ($files = $request->file('images')) {
            foreach ($files as $file) {
                Image::make($file)->save(public_path('storage/images/products/' . $file->hashName()), 80);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $file->hashName(),
                ]);
            }
        }

        foreach ($request->colors as $color) {
            foreach ($request->sizes as $size) {
                $stock = Stock::create([
                    'color_id' => $color,
                    'size_id' => $size,
                    'product_id' => $product->id,
                    'quantity' => 0,
                ]);
            }
        }


        $description_ar = ' تم إضافة منتج ' . '  منتج رقم' . ' #' . $product->id . ' - SKU ' . $product->sku;
        $description_en  = "product added " . " product ID " . ' #' . $product->id . ' - SKU ' . $product->sku;
        addLog('vendor', 'products', $description_ar, $description_en);

        alertSuccess('Product Created successfully, Please enter stock according to colors and sizes', 'تم إنشاء المنتج بنجاح, يرجى ادخال المخزون على حسب الألوان والمقاسات');
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
            'images' => "array",
            'description_ar' => "required|string",
            'description_en' => "required|string",
            'vendor_price' => "required|string",
            'categories' => "required|array",
        ]);

        if ($files = $request->file('images')) {

            foreach ($vendor_product->images as $image) {
                Storage::disk('public')->delete('/images/products/' . $image->image);
                $image->delete();
            }

            foreach ($files as $file) {
                Image::make($file)->save(public_path('storage/images/products/' . $file->hashName()), 80);
                ProductImage::create([
                    'product_id' => $vendor_product->id,
                    'image' => $file->hashName(),
                ]);
            }
        }

        $vendor_product->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'sku' => $request['sku'],
            'description_ar' => $request['description_ar'],
            'description_en' => $request['description_en'],
            'vendor_price' => $request['vendor_price'],
        ]);

        $vendor_product->categories()->detach();
        $vendor_product->categories()->attach($request['categories']);

        CalculateProductPrice($vendor_product);

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
            return redirect()->back();
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
            'stock' => "required|array",
            'image' => "nullable|array"
        ]);

        $stock = $request->stock;

        foreach ($product->stocks as $index => $product_stock) {
            if ($request->has('image')) {
                if (array_key_exists($product_stock->id, $request->image)) {
                    Image::make($request->image[$product_stock->id][0])->save(public_path('storage/images/products/' . $request->image[$product_stock->id][0]->hashName()), 60);
                    $product_stock->update([
                        'image' => $request->image[$product_stock->id][0]->hashName(),
                    ]);
                }
            }
            $product_stock->update([
                'quantity' => $stock[$index],
            ]);
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

<?php

namespace App\Imports;

use App\Models\Account;
use App\Models\Category;
use App\Models\Color;
use App\Models\Country;
use App\Models\Entry;
use App\Models\Media;
use App\Models\Product;
use App\Models\ProductCombination;
use App\Models\ProductCombinationDtl;
use App\Models\ProductImage;
use App\Models\ProductVariation;
use App\Models\Size;
use App\Models\Stock;
use App\Models\User;
use App\Models\Variation;
use App\Models\Warehouse;
use Exception;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;


class ProductImport implements

    WithValidation,
    WithHeadingRow,
    ToCollection,
    SkipsOnError,
    SkipsOnFailure,
    SkipsEmptyRows

{

    use Importable, SkipsErrors, SkipsFailures, RegistersEventListeners;

    public function rules(): array
    {
        return [
            'name_ar' => "required|string",
            'name_en' => "required|string",
            'sku' => "required|string|unique:products",
            'images' => "required|string",
            'category' => "required|integer",
            'description_ar' => "nullable|string",
            'description_en' => "nullable|string",
            'sale_price' => "required|numeric",
            'discount_price' => "required|numeric",
            'brands' => "nullable|string",
            'product_type' => "required|string",
            'attributes' => "nullable",
            'status' => "required|string",
            'warehouse_id' => "required|integer",
            'variations_sku' => "nullable|string",
            'variations_qty' => "nullable|string",
            'variations_cost' => "nullable|string",
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }


    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {


            $validator = Validator::make($row->toArray(), [
                'name_ar' => "required|string",
                'name_en' => "required|string",
                'sku' => "required|string|unique:products",
                'images' => "required|string",
                'category' => "required|integer",
                'description_ar' => "nullable|string",
                'description_en' => "nullable|string",
                'sale_price' => "required|numeric",
                'discount_price' => "required|numeric",
                'brands' => "nullable|string",
                'product_type' => "required|string",
                'attributes' => "nullable",
                'status' => "required|string",
                'warehouse_id' => "required|integer",
                'variations_sku' => "nullable|string",
                'variations_qty' => "nullable|string",
                'variations_cost' => "nullable|string",

            ])->validate();







            // if ($validator->fails()) {
            //     return redirect()->back()
            //         ->withErrors($validator);
            // }



            if ($row['images'] == '') {
                alertError('The image link field is required, it cannot be left blank', 'الحقل الخاص برابط الصور مطلوب , لايمكن تركه فارغا');
                return redirect()->back()->withInput();
            }

            if (Category::find($row['category']) == null) {
                alertError('The category id used is incorrect, please check the data', 'رقم القسم المستخدم غير صحيح يرجى مراجعة البيانات');
                return redirect()->back()->withInput();
            }

            if ($row['sale_price'] <= $row['discount_price']) {
                alertError('discount price must be lower than regular price', 'يجب ان يكون سعر الخصم اقل من السعر العادي');
                return redirect()->back()->withInput();
            }

            $product_type = $row['product_type'];




            if ($product_type == 'variable') {


                if ($row['attributes'] == '') {
                    alertError('please add product attributes', 'يرجى اضافة سمات المنتجات');
                    return redirect()->back()->withInput();
                }


                $attributes = explode(',', $row['attributes']);


                if (empty($attributes)) {
                    alertError('please select product attribute', 'يرجى تحديد سمات المنتج');
                    return redirect()->back()->withInput();
                } else {


                    foreach ($attributes as $attr) {

                        if (!isset($row['variations_' . $attr])) {
                            alertError('please select product variations', 'يرجى تحديد متغيرات المنتج');
                            return redirect()->back()->withInput();
                        }
                    }
                }
            }

            $category = Category::find($row['category']);


            $product = Product::create([
                'created_by' => Auth::id(),
                'name_ar' => $row['name_ar'],
                'name_en' => $row['name_en'],
                'category_id' => $row['category'],
                'product_slug' => createSlug($row['name_en']),
                'sku' => $row['sku'],
                'description_ar' => $row['description_ar'],
                'description_en' => $row['description_en'],
                'sale_price' => $row['sale_price'],
                'discount_price' => $row['discount_price'],
                'product_type' => $product_type,
                'product_min_order' => 1,
                'product_max_order' => 5,
                'country_id' => $category->country_id,
                'status' => $row['status'],

            ]);







            $images = explode(',', $row['images']);

            foreach ($images as $image) {

                try {
                    $url = $image;
                    $contents = file_get_contents($url);

                    $name = substr($url, strrpos($url, '/') + 1);

                    $rand = rand();

                    // resize(300, null, function ($constraint) {
                    //     $constraint->aspectRatio();
                    // })->


                    // $img = Image::make($media);
                    // $img->save(public_path('storage/images/' . $folder . '/' . $media->hashName()), setting('compression_ratio') == null ? 100 : setting('compression_ratio'));

                    Image::make($contents)->save(public_path('storage/images/products/' . $rand  . '-' . $row['sku'] . $name), setting('compression_ratio') == null ? 100 : setting('compression_ratio'));

                    $new_name = $rand . '-' . $row['sku'] . $name;

                    $media = Media::create([
                        'created_by' => Auth::id(),
                        'name' => $new_name,
                        'extension' => 'png',
                        'height' => '500',
                        'width' => '500',
                        'path' => 'storage/images/products/' . $rand  . '-' . $row['sku'] . $name,
                    ]);

                    // $media_id = saveMedia('image', $contents, 'products');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'media_id' => $media->id,
                    ]);

                    // Image::make($contents)->save(public_path('storage/images/products/' . $rand  . '-' . $row['sku'] . $name), setting('compression_ratio') == null ? 100 : setting('compression_ratio'));

                    // ProductImage::create([

                    //     'product_id' => $product->id,
                    //     'image' => $rand . '-' . $row['sku'] . $name,
                    // ]);
                } catch (Exception $e) {
                }
            }



            if ($product_type == 'variable') {

                $product->attributes()->attach($attributes);

                $combination_array = [];

                foreach ($attributes as $attr) {

                    $row['variations_' . $attr] = explode(',', $row['variations_' . $attr]);

                    $variations = [];

                    foreach ($row['variations_' . $attr] as $index => $var) {

                        $var = Variation::where('name_ar', $var)->orWhere('name_en', $var)->first();
                        if ($var) {
                            $variations[$index] = $var->id;
                            ProductVariation::create([
                                'attribute_id' => $attr,
                                'variation_id' => $var->id,
                                'product_id' => $product->id
                            ]);
                        } else {
                            alertError('some of entered attributes for feature number - ' . $attr . ' - not fount on the system please review your data', 'بعض المتغيرات المدخلة للسمة رقم - ' . $attr . ' - غير معرفة على النظام يرجى مراجعة المدخلات');
                            return redirect()->back()->withInput();
                        }
                    }

                    $row['variations_' . $attr] = $variations;

                    $combination_array[] = $row['variations_' . $attr];
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



            if (isset($row['is_featured']) && $row['is_featured'] == 1) {
                $product->update([
                    'is_featured' => '1',
                ]);
            }

            if (isset($row['on_sale']) && $row['on_sale'] == 1) {
                $product->update([
                    'on_sale' => '1',
                ]);
            }

            if (isset($row['top_collection']) && $row['top_collection'] == 1) {
                $product->update([
                    'top_collection' => '1',
                ]);
            }

            if (isset($row['best_selling']) && $row['best_selling'] == 1) {
                $product->update([
                    'best_selling' => '1',
                ]);
            }


            if ($row['variations_sku'] == '') {
                alertError('please add sku for variations', 'يرجى اضافة sku المتغيرات');
                return redirect()->back()->withInput();
            }

            if ($row['variations_cost'] == '') {
                alertError('please add variations cost', 'يرجى اضافة اسعار تكلفة المتغيرات');
                return redirect()->back()->withInput();
            }

            if ($row['variations_qty'] == '') {
                alertError('please add variatoions quantities', 'يرجى اضافة كميات المتغيرات');
                return redirect()->back()->withInput();
            }

            $variations_sku = explode(',', $row['variations_sku']);
            $variations_cost = explode(',', $row['variations_cost']);
            $variations_qty = explode(',', $row['variations_qty']);


            if (count($variations_sku) != $product->combinations->count() ||  count($variations_cost) != $product->combinations->count() ||  count($variations_qty) != $product->combinations->count()) {
                alertError('variations data is missing', 'بيانات بعض المتغيرات غير كاملة - اسعار تكلفة - كميات - sku');
                return redirect()->back()->withInput();
            }


            $warehouse = Warehouse::findOrFail($row['warehouse_id']);
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

            $variations_sku = explode(',', $row['variations_sku']);


            foreach ($product->combinations as $index => $combination) {
                $combination->update([
                    'sku' => $variations_sku[$index],
                ]);
            }


            $variations_qty = explode(',', $row['variations_qty']);
            $variations_cost = explode(',', $row['variations_cost']);


            foreach ($product->combinations as $index => $combination) {

                if (!isset($variations_qty[$index])) {
                    $qty = 0;
                } else {
                    $qty = $variations_qty[$index];
                }

                if ($qty > 0) {

                    // if ($request->sale_price[$index] <= $request->discount_price[$index]) {
                    //     alertError('discount price must be lower than regular price', 'يجب ان يكون سعر الخصم اقل من السعر العادي');
                    //     if (url()->previous() == route('products.stock.add')) {
                    //         return redirect()->route('products.stock.create', ['product' => $product->id]);
                    //     } else {
                    //         return redirect()->back()->withInput();
                    //     }
                    // }

                    // if ($request->stock_status[$index] == 'OUT') {
                    //     if ($request->qty[$index] > productQuantity($product->id, $combination->id, $warehouse->id)) {
                    //         alertError('There are not enough quantities in the specified warehouse for stock exchange', 'لا توجد كميات كافية في المخزن المحدد لصرف المخزون');
                    //         if (url()->previous() == route('products.stock.add')) {
                    //             return redirect()->route('products.stock.create', ['product' => $product->id]);
                    //         } else {
                    //             return redirect()->back()->withInput();
                    //         }
                    //     }
                    // }

                    // if ($request->has('images')) {
                    //     if (array_key_exists($combination->id, $request->images)) {
                    //         $media_id = saveMedia('image', $request->images[$combination->id][0], 'combinations');
                    //         if ($combination->media_id != null) {
                    //             deleteImage($combination->media_id);
                    //         }
                    //         $combination->update([
                    //             'media_id' => $media_id,
                    //         ]);
                    //     }
                    // }

                    // if ($request->stock_status[$index] == 'IN') {

                    // calculate product cost in add stock

                    if (!isset($variations_cost[$index])) {
                        $cost = 0;
                    } else {
                        $cost = $variations_cost[$index];
                    }

                    updateCost($combination, $cost, $variations_qty[$index], 'add', $branch_id);


                    // }

                    Stock::create([
                        'product_combination_id' => $combination->id,
                        'product_id' => $product->id,
                        'warehouse_id' => $warehouse->id,
                        'qty' => $variations_qty[$index],
                        'stock_status' => 'IN',
                        'stock_type' => 'StockAdjustment',
                        'reference_price' => $cost,
                        'created_by' => Auth::id()
                    ]);


                    $product_account = getItemAccount($combination, $combination->product->category, 'assets_account', $branch_id);
                    $cs_product_account = getItemAccount($combination, $combination->product->category, 'cs_account', $branch_id);

                    if ($cost > 0) {
                        Entry::create([
                            'account_id' => $product_account->id,
                            'type' => 'stockIN',
                            'dr_amount' => ($cost * $variations_qty[$index]),
                            'cr_amount' => 0,
                            'description' => 'stock adjustment# ' . $combination->id,
                            'reference_id' => $combination->id,
                            'branch_id' => $branch_id,
                            'created_by' => Auth::id(),
                        ]);


                        entry::create([
                            'account_id' => $funding_assets_account->id,
                            'type' => 'stockIN',
                            'dr_amount' => 0,
                            'cr_amount' => ($cost * $variations_qty[$index]),
                            'description' => 'stock adjustment# ' . $combination->id,
                            'branch_id' => $branch_id,
                            'created_by' => Auth::id(),
                        ]);
                    }


                    // if ($request->stock_status[$index] == 'OUT') {

                    //     Entry::create([
                    //         'account_id' => $cs_product_account->id,
                    //         'type' => 'stockOut',
                    //         'dr_amount' => ($combination->costs->where('branch_id', $branch_id)->first()->cost * $request->qty[$index]),
                    //         'cr_amount' => 0,
                    //         'description' => 'stock adjustment# ' . $combination->id,
                    //         'reference_id' => $combination->id,
                    //         'branch_id' => $branch_id,
                    //         'created_by' => Auth::id(),
                    //     ]);
                    // }



                    // if ($product->product_type == 'simple' && $request->stock_status[$index] == 'IN') {
                    //     $product->update([
                    //         'sale_price' => $request->sale_price[$index],
                    //         'discount_price' => $request->discount_price[$index],
                    //     ]);
                    // }
                }
            }



            $description_ar = ' تم إضافة منتج ' . '  منتج رقم' . ' #' . $product->id . ' - SKU ' . $product->sku . ' - ' . ' تم إضافة هذا المنتج من الشيت';
            $description_en  = "product added " . " product ID " . ' #' . $product->id . ' - SKU ' . $product->sku . ' - ' . ' This product was added from the sheet';
            addLog('admin', 'products', $description_ar, $description_en);
        }
    }
}

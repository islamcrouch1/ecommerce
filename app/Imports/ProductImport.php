<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Color;
use App\Models\Country;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Size;
use App\Models\Stock;
use App\Models\User;
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
            'sku' => "nullable|string|unique:products",
            'images' => "required|string",
            'description_ar' => "required|string",
            'description_en' => "required|string",
            'vendor_price' => "required|numeric",
            'categories' => "required",
            'status' => "required|string",
            'colors'  => "required",
            'sizes'  => "required",
            'extra_fee'  => "nullable|numeric",
            'quantities' => "required",
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
                'description_ar' => "required|string",
                'description_en' => "required|string",
                'vendor_price' => "required|numeric",
                'categories' => "required",
                'status' => "required|string",
                'colors'  => "required",
                'sizes'  => "required",
                'extra_fee'  => "nullable|numeric",
                'quantities' => "required",
            ])->validate();


            // if ($validator->fails()) {
            //     return redirect()->back()
            //         ->withErrors($validator);
            // }


            $vendor = User::find($row['vendor_id']);
            if ($vendor == NULL || !$vendor->hasRole('vendor')) {
                alertError('The vendor number entered is incorrect', 'رقم التاجر المدخل غير صحيح');
                return redirect()->back();
            }

            if ($row['images'] == '') {
                alertError('The image link field is required, it cannot be left blank', 'الحقل الخاص برابط الصور مطلوب , لايمكن تركه فارغا');
                return redirect()->back();
            }

            if (Country::where('id', $row['country_id'])->count() == 0) {
                alertError('The country id used is incorrect, please check the data', 'رقم الدولة المستخدم غير صحيح يرجى مراجعة البيانات');
                return redirect()->back();
            }

            if (isset($row['extra_fee'])) {
                $extra_fee = str_replace(' ', '', $row['extra_fee']);
            } else {
                $extra_fee = 0;
            }


            $categories = explode(',', $row['categories']);
            foreach ($categories as $category) {
                if (Category::where('id', $category)->count() == 0) {
                    alertError('The category id used is incorrect, please check the data', 'رقم القسم المستخدم غير صحيح يرجى مراجعة البيانات');
                    return redirect()->back();
                }
            }

            $check = Auth::user()->HasRole('vendor');

            $product = Product::create([
                'vendor_id' => $check ? Auth::user()->id : $row['vendor_id'],
                'name_ar' => $row['name_ar'],
                'name_en' => $row['name_en'],
                'sku' => str_replace(' ', '', $row['sku']),
                'description_ar' => $row['description_ar'],
                'description_en' => $row['description_en'],
                'vendor_price' => str_replace(' ', '', $row['vendor_price']),
                'extra_fee' => $check ? 0 : $extra_fee,
                'country_id' => 1,
                'status' => $check ? 'pending' : str_replace(' ', '', $row['status']),
                'admin_id' => $check ? null : Auth::id(),
            ]);

            $product->categories()->attach($categories);
            CalculateProductPrice($product);

            $colors = explode(',', $row['colors']);
            $sizes = explode(',', $row['sizes']);
            $quantities = explode(',', $row['quantities']);

            foreach ($colors as $color) {

                if (Color::where('id', $color)->count() == 0) {
                    $product->forceDelete();
                    alertError('The color id used is incorrect, please check the data', 'رقم اللون المستخدم غير صحيح يرجى مراجعة البيانات');
                    return redirect()->back();
                }

                foreach ($sizes as $size) {

                    if (Size::where('id', $size)->count() == 0) {
                        $product->forceDelete();
                        alertError('The size id used is incorrect, please check the data', 'رقم المقاس المستخدم غير صحيح يرجى مراجعة البيانات');
                        return redirect()->back();
                    }

                    $stock = Stock::create([
                        'color_id' => $color,
                        'size_id' => $size,
                        'product_id' => $product->id,
                        'stock' => 0,
                    ]);
                }
            }

            foreach ($product->stocks as $index => $stock) {
                $stock->update([
                    'quantity' => isset($quantities[$index]) ? $quantities[$index] : '0',
                ]);
            }

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

                    Image::make($contents)->save(public_path('storage/images/products/' . $rand  . '-' . $row['sku'] . $name), 80);

                    ProductImage::create([

                        'product_id' => $product->id,
                        'image' => $rand . '-' . $row['sku'] . $name,
                    ]);
                } catch (Exception $e) {
                }
            }

            $description_ar = ' تم إضافة منتج ' . '  منتج رقم' . ' #' . $product->id . ' - SKU ' . $product->sku . ' - ' . ' تم إضافة هذا المنتج من الشيت';
            $description_en  = "product added " . " product ID " . ' #' . $product->id . ' - SKU ' . $product->sku . ' - ' . ' This product was added from the sheet';
            addLog('admin', 'products', $description_ar, $description_en);
        }
    }
}

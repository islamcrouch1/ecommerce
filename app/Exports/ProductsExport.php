<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ProductsExport implements FromCollection, WithHeadings
{



    protected $request, $is_vendors;

    public function __construct($request, $is_vendors)
    {
        $this->request     = $request;
        $this->is_vendors     = $is_vendors;
    }

    public function headings(): array
    {

        return [

            'id',
            'SKU',
            'status',
            'country_id',
            'category_id',
            'name_ar',
            'name_en',
            'description_ar',
            'description_en',
            'product_type',

        ];
    }


    public function collection()
    {
        return collect(Product::getProducts($this->request, $this->is_vendors));
    }
}

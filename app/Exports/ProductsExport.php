<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ProductsExport implements FromCollection, WithHeadings
{



    protected $status, $category_id;

    public function __construct($status, $category_id)
    {

        $this->status     = $status;
        $this->category_id     = $category_id;
    }

    public function headings(): array
    {

        return [

            'id',
            'SKU',
            'vendor_id',
            'status',
            'country_id',
            'name_ar',
            'name_en',
            'description_ar',
            'description_en',
            'vendor_price',
            'extra_fee',
            'colors',
            'sizes',
            'quantities',
            'images',

        ];
    }


    public function collection()
    {
        return collect(Product::getProducts($this->status, $this->category_id));
    }
}

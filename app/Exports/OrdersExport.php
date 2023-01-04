<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class OrdersExport implements FromCollection, WithHeadings
{

    protected $status, $from, $to;

    public function __construct($status, $from, $to)
    {

        $this->status     = $status;
        $this->from     = $from;
        $this->to     = $to;
    }

    public function headings(): array
    {

        return [
            '#',
            'order_id',
            'created_at',
            'updated_at',
            'product_id',
            'vendor_price',
            'selling_price',
            'affiliate_commission',
            'sonoo_commission',
            'total_price',
            'total_commission',
            'quantity',
            'stock_id',
            'product_type',
            'color',
            'size',
            'product_name_ar',
            'product_name_en',
            'affiliate_id',
            'status',
            'customer_name',
            'customer_phone',
            'customer_phone2',
            'address',
            'house',
            'special_mark',
            'notes',
            'SKU',
            'vendor_id',
        ];
    }


    public function collection()
    {

        return collect(Order::getOrders($this->status, $this->from, $this->to));
    }
}

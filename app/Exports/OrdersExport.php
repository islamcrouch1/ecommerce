<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class OrdersExport implements FromCollection, WithHeadings
{

    protected $request;

    public function __construct($request)
    {
        $this->request     = $request;
    }

    public function headings(): array
    {

        return [
            'order_id',
            'client_name',
            'phone',
            'address',
            'status',
            'payment_method',
            'payment_status',
            'total',
            'shipping',
            'created_at',
        ];
    }


    public function collection()
    {

        return collect(Order::getOrders($this->request));
    }
}

<?php

namespace App\Exports;

use App\Models\Withdrawal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class WithdrawalsExport implements FromCollection, WithHeadings
{

    protected $request;

    public function __construct($request)
    {
        $this->request     = $request;
    }

    public function headings(): array
    {

        return [
            'id',
            'user_id',
            'data',
            'amount',
            'status',
            'created_at',
            'name',
            'type',
        ];
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect(Withdrawal::getWithdrawal($this->request));
    }
}

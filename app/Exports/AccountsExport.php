<?php

namespace App\Exports;

use App\Models\Account;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;



class AccountsExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $request;

    public function __construct($request)
    {
        $this->request     = $request;
    }

    public function headings(): array
    {
        return [
            'id',
            'name_ar',
            'name_en',
            'code',
            'type',
            'branch_id',
            'created_at',
        ];
    }


    public function collection()
    {
        return collect(Account::geAccounts($this->request));
    }
}

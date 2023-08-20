<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;


class UsersExport implements FromCollection, WithHeadings
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
            'name',
            'phone',
            'email',
            'gender',
            'created_at',
            'type'
        ];
    }


    public function collection()
    {
        return collect(User::getUsers($this->request));
    }
}

<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;


class UsersExport implements FromCollection, WithHeadings
{

    use Exportable;

    protected $role_id, $from, $to;

    public function __construct($role_id, $from, $to)
    {
        $this->role_id     = $role_id;
        $this->from     = $from;
        $this->to     = $to;
    }

    public function headings(): array
    {
        return [
            'id',
            'created_at',
            'name',
            'phone',
            'email',
            'gender',
            'type'
        ];
    }


    public function collection()
    {
        return collect(User::getUsers($this->role_id, $this->from, $this->to));
    }
}

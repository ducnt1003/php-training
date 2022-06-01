<?php

namespace App\Exports;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;



class UsersExport implements FromQuery, WithHeadings, WithColumnWidths, WithMapping
{
    use Exportable;

    public function __construct(HttpRequest $data)
    {
        $this->columns = $data->options;
        $this->search = $data->search;
        //$this->sort = $request->sort;
        $this->role_id = $data->role_id;
    }

    public function query()
    {
        return User::select('id','name','email','role_id')->with(['role'])->orderBy('users.id', 'asc');
    }

    public function headings(): array
    {
        return array_map('ucfirst', $this->columns);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 30,
            'C' => 40,
            'D' => 20
        ];
    }

    public function map($user): array
    {
        $select = [];
        foreach ($this->columns as $array){
            if($array == "role" ){
                array_push($select,$user[$array]['role']);
            }else{
                array_push($select,$user[$array]);
            }

        }
        return $select;
    }
}

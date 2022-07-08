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

    public function __construct($data)
    {
        $this->columns = $data->options;
        $this->search = $data->search;
        $this->sort = $data->sort;
        $this->role_id = $data->role_id;
    }

    public function query()
    {
        $whereLike = [];
        if ($this->search) {
            array_push($whereLike, [DB::raw('BINARY `name`'), 'like', '%' . $this->search . '%']);
        }
        if ($this->role_id && $this->role_id != config('constants.role_id_max') && $this->role_id != config('constants.role_id_min')) {
            array_push($whereLike, ['role_id', $this->role_id]);
        }
        if ($this->sort['type'] == config('constants.non_short_type')) {
            $orderBy = ['id', config('constants.short_asc')];
        } else if ($this->sort['type'] == 1) {
            $orderBy = [$this->sort['key'], config('constants.short_asc')];
        } else {
            $orderBy = [$this->sort['key'], config('constants.short_desc')];
        }
        return User::select('id', 'name', 'email', 'role_id')->where($whereLike)->with(['role'])->orderBy($orderBy[0], $orderBy[1]);
    }

    public function headings(): array
    {
        return array_map('ucfirst', $this->columns);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 30,
            'C' => 40,
            'D' => 20
        ];
    }

    public function map($user): array
    {
        $select = [];
        foreach ($this->columns as $array) {
            if ($array == "role") {
                array_push($select, $user[$array]['role']);
            } else {
                array_push($select, $user[$array]);
            }
        }
        return $select;
    }
}

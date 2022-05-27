<?php

namespace App\Exports;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnWidths;


class UsersExport implements FromArray, WithHeadings,WithColumnWidths
{
    use Exportable;

    public function __construct($columns)
    {
        $this->columns = $columns;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        $users = DB::table('users')->join('roles','users.role_id','=','roles.id')
        ->select('users.id','users.name','users.email','roles.role')->get();
        $selectedusers = [];
        $arrays = $this->columns;
        foreach($users as $user){
            $selecteduser = [];
            foreach($arrays as $array){
                $selecteduser[$array] = $user->$array;
            }
            array_push($selectedusers,$selecteduser);
        }
        return $selectedusers;
    }

    // public function array(): array
    // {
    //     $selectedusers = [];
    //     DB::table('users')->join('roles','users.role_id','=','roles.id')
    //     ->select('users.id','users.name','users.email','roles.role')->chunk(10, function ($users) {
    //         foreach($users as $user){
    //             $selecteduser = [];
    //             foreach($this->columns as $array){
    //                 $selecteduser[$array] = $user->$array;
    //             }
    //             array_push($selectedusers,$selecteduser);
    //         }
    //     });

    //     return $selectedusers;
    // }

    public function headings(): array
    {
        return array_map('ucfirst',$this->columns);
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
}

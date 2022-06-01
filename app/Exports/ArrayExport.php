<?php
namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;

class ArrayExport implements FromArray, WithHeadings,WithColumnWidths
{
    use Exportable;

    public function __construct($columns)
    {
        $this->columns = $columns;
    }

    public function array(): array
    {
        $selectedusers = [];
        $arrays = $this->columns;
        DB::table('users')->join('roles','users.role_id','=','roles.id')
        ->select('users.id','users.name','users.email','roles.role')->orderBy('users.id')->chunk(5000, function ($users)  use (&$arrays, &$selectedusers) {
            foreach($users as $user){
                $selecteduser = [];
                foreach($arrays as $array){
                    $selecteduser[$array] = $user->$array;
                }
                array_push($selectedusers,$selecteduser);
            }
        });
        return $selectedusers;
    }

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

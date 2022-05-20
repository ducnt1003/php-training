<?php
namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\User::class;
    }

    public function getListWithRole(){
        // return \App\Models\User::class::with(['role'])->get();
        return $users = DB::table('users')->join('roles','users.role_id','=','roles.id')
        ->select('users.id','users.name','users.email','users.role_id','roles.role')->get();
    }

    public function getUserWithRole($id){
        // return \App\Models\User::class::with(['role'])->get();
        return $user = DB::table('users')->join('roles','users.role_id','=','roles.id')->where('users.id','=',$id)
        ->select('users.id','users.name','users.email','users.role_id','roles.role')->first();
    }

}

<?php
namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    //private const $paginate = 10;
    public function getModel()
    {
        return \App\Models\User::class;
    }

    public function getListWithRole($whereLike, $orderBy){
        return $users = DB::table('users')->join('roles','users.role_id','=','roles.id')
        ->select('users.id','users.name','users.email','users.role_id','roles.role')->where($whereLike)->orderBy($orderBy[0], $orderBy[1])->paginate(10);
    }

    public function getUserWithRole($id){
        return $user = DB::table('users')->join('roles','users.role_id','=','roles.id')->where('users.id','=',$id)
        ->select('users.id','users.name','users.email','users.role_id','roles.role')->first();
    }

    public function deleteAllUser(){
        $users = User::where('id','!=',1)->chunkById(100,function($users){
            foreach($users as $user) {
                $user->delete();
            }
        });
        return true;
    }

}

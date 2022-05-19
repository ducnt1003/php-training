<?php

namespace App\Services;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getList(){
        return $this->userRepository->getListWithRole();
    }

    public function create(Request $request){
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role_id' => $request->input('role_id'),
            'password' => Hash::make('123123'),
        ];
        return $this->userRepository->create($data);
    }

    public function edit($id,Request $request){
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role_id' => $request->input('role_id'),
        ];
        return $this->userRepository->update($id,$data);
    }
}
